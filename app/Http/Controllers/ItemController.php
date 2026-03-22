<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ItemsDataTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ItemsImport;
use App\Models\Item;

class ItemController extends Controller
{
    // ── Public storefront ──────────────────────────────────────────────────

public function getItems(Request $request)
{
    $query = DB::table('item')->whereNull('deleted_at');

    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('title',        'LIKE', '%' . $request->search . '%')
              ->orWhere('description', 'LIKE', '%' . $request->search . '%')
              ->orWhere('category',    'LIKE', '%' . $request->search . '%');
        });
    }

    if ($request->filled('min_price')) {
        $query->where('sell_price', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('sell_price', '<=', $request->max_price);
    }
    if ($request->filled('category')) {
        $query->whereIn('category', (array) $request->category);
    }

    match ($request->input('sort', 'featured')) {
        'price_asc'  => $query->orderBy('sell_price', 'asc'),
        'price_desc' => $query->orderBy('sell_price', 'desc'),
        'newest'     => $query->orderBy('created_at', 'desc'),
        default      => $query->orderBy('item_id', 'asc'),
    };

    $items      = $query->paginate(12)->withQueryString();
    $categories = DB::table('item')->whereNull('deleted_at')->distinct()->pluck('category');

    return view('shop.index', compact('items', 'categories'));
}


public function addToCart($id)
{
    $item = DB::table('item')->where('item_id', $id)->whereNull('deleted_at')->first();
    abort_if(!$item, 404);

    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            'item_id'    => $item->item_id,
            'title'      => $item->title,
            'sell_price' => $item->sell_price,
            'img_path'   => $item->img_path,
            'quantity'   => 1,
        ];
    }

    session()->put('cart', $cart);
    return redirect()->back()->with('success', $item->title . ' added to cart.');
}

public function getCart()
{
    $cart  = session()->get('cart', []);
    $total = collect($cart)->sum(fn($i) => $i['sell_price'] * $i['quantity']);
    return view('shop.shopping-cart', compact('cart', 'total'));
}

public function getReduceByOne($id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        if ($cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity']--;
        } else {
            unset($cart[$id]);
        }
        session()->put('cart', $cart);
    }

    return redirect()->back();
}

public function getRemoveItem($id)
{
    $cart = session()->get('cart', []);
    unset($cart[$id]);
    session()->put('cart', $cart);
    return redirect()->back();
}

public function postCheckout()
{
    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return redirect()->route('getCart')->with('error', 'Your cart is empty.');
    }
    $total = collect($cart)->sum(fn($i) => $i['sell_price'] * $i['quantity']);
    return view('shop.checkout', compact('cart', 'total'));
}
    // ── Admin CRUD ─────────────────────────────────────────────────────────

    public function index(ItemsDataTable $dataTable, Request $request)
    {
        if ($request->ajax()) {
            return $dataTable->ajax();
        }
        return $dataTable->render('item.index');
    }

    public function create()
    {
        return view('item.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string|max:255',
            'description' => 'required|string',
            'sell_price'  => 'required|numeric|min:0',
            'cost_price'  => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'images'      => 'nullable|array',
            'images.*'    => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imgPath = 'default.jpg';
        $paths   = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path    = $image->store('items', 'public');
                $paths[] = $path;
                if ($index === 0) $imgPath = $path;
            }
        }

        $itemId = DB::table('item')->insertGetId([
            'title'       => $request->title,
            'category'    => $request->category,
            'description' => $request->description,
            'sell_price'  => $request->sell_price,
            'cost_price'  => $request->cost_price,
            'img_path'    => $imgPath,
            'images'      => $paths ? implode(',', $paths) : null,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        DB::table('stock')->insert([
            'item_id'    => $itemId,
            'quantity'   => $request->quantity,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('items.index')->with('success', 'Item added successfully.');
    }

    public function show($id)
{
    $item = DB::table('item as i')
        ->leftJoin('stock as s', 'i.item_id', '=', 's.item_id')
        ->select('i.*', 's.quantity')
        ->where('i.item_id', $id)
        ->whereNull('i.deleted_at')
        ->first();

    abort_if(!$item, 404);

    if (request()->is('admin/*')) {
        return view('item.show', compact('item'));
    }

    // Get reviews with customer name
    try {
        $reviews = DB::table('reviews')
            ->join('customer', 'reviews.customer_id', '=', 'customer.id')
            ->where('reviews.item_id', $id)
            ->select('reviews.*', 'customer.fname', 'customer.lname')
            ->orderBy('reviews.created_at', 'desc')
            ->get();
    } catch (\Exception $e) {
        $reviews = collect();
    }

    // Check if logged-in user can review
    $canReview = false;
    $eligibleOrderId = null;

    if (auth()->check()) {
        $customer = DB::table('customer')
            ->where('user_id', auth()->id())
            ->first();

        if ($customer) {
            $eligibleOrder = DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
                ->where('orders.customer_id', $customer->id)
                ->where('orders.status', 'completed')
                ->where('order_items.item_id', $id)
                ->whereNotExists(function ($query) use ($id, $customer) {
                    $query->select(DB::raw(1))
                        ->from('reviews')
                        ->whereColumn('reviews.order_id', 'orders.order_id')
                        ->where('reviews.item_id', $id)
                        ->where('reviews.customer_id', $customer->id);
                })
                ->select('orders.order_id')
                ->first();

            if ($eligibleOrder) {
                $canReview = true;
                $eligibleOrderId = $eligibleOrder->order_id;
            }
        }
    }

    return view('shop.product', compact('item', 'reviews', 'canReview', 'eligibleOrderId'));
}

    public function edit($id)
    {
        $item = DB::table('item as i')
            ->leftJoin('stock as s', 'i.item_id', '=', 's.item_id')
            ->select('i.*', 's.quantity', 's.reorder_level')
            ->where('i.item_id', $id)
            ->whereNull('i.deleted_at')
            ->first();

        abort_if(!$item, 404);
        return view('item.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'category'      => 'required|string|max:255',
            'description'   => 'required|string',
            'sell_price'    => 'required|numeric|min:0',
            'cost_price'    => 'required|numeric|min:0',
            'quantity'      => 'required|integer|min:0',
            'images'        => 'nullable|array',
            'images.*'      => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'nullable|array',
        ]);

        $item = DB::table('item')->where('item_id', $id)->whereNull('deleted_at')->first();
        abort_if(!$item, 404);

        $existingPaths = $item->images ? explode(',', $item->images) : [];

        if ($request->filled('delete_images')) {
            foreach ($request->delete_images as $toDelete) {
                Storage::disk('public')->delete($toDelete);
                $existingPaths = array_filter($existingPaths, fn($p) => $p !== $toDelete);
            }
            $existingPaths = array_values($existingPaths);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $existingPaths[] = $image->store('items', 'public');
            }
        }

        $imgPath = $existingPaths[0] ?? 'default.jpg';

        DB::table('item')->where('item_id', $id)->update([
            'title'       => $request->title,
            'category'    => $request->category,
            'description' => $request->description,
            'sell_price'  => $request->sell_price,
            'cost_price'  => $request->cost_price,
            'img_path'    => $imgPath,
            'images'      => $existingPaths ? implode(',', $existingPaths) : null,
            'updated_at'  => now(),
        ]);

        $stock = DB::table('stock')->where('item_id', $id)->first();

        if ($stock) {
            DB::table('stock')->where('item_id', $id)->update([
                'quantity'   => $request->quantity,
                'updated_at' => now(),
            ]);
        } else {
            DB::table('stock')->insert([
                'item_id'    => $id,
                'quantity'   => $request->quantity,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    // Soft delete — sets deleted_at timestamp, keeps record and images intact
    public function destroy($id)
    {
        $item = DB::table('item')->where('item_id', $id)->whereNull('deleted_at')->first();
        abort_if(!$item, 404);

        DB::table('item')->where('item_id', $id)->update([
            'deleted_at' => now(),
        ]);

        return redirect()->route('items.index')->with('success', 'Item moved to trash.');
    }

    // ── Trash ──────────────────────────────────────────────────────────────

    // Show all soft-deleted items
    public function trash(Request $request)
    {
        $query = DB::table('item')->whereNotNull('deleted_at');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
            });
        }

        $items = $query->orderBy('deleted_at', 'desc')->paginate(10)->withQueryString();

        return view('item.trash', compact('items'));
    }

    // Restore a soft-deleted item
    public function restore($id)
    {
        DB::table('item')->where('item_id', $id)->update([
            'deleted_at' => null,
            'updated_at' => now(),
        ]);

        return redirect()->route('items.trash')->with('success', 'Item restored.');
    }

    // Permanently delete item and its images
    public function forceDelete($id)
    {
        $item = DB::table('item')->where('item_id', $id)->whereNotNull('deleted_at')->first();
        abort_if(!$item, 404);

        if ($item->images) {
            foreach (explode(',', $item->images) as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        DB::table('stock')->where('item_id', $id)->delete();
        DB::table('item')->where('item_id', $id)->delete();

        return redirect()->route('items.trash')->with('success', 'Item permanently deleted.');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new ItemsImport, $request->file('file'));
        return redirect()->route('items.index')->with('success', 'Items imported successfully.');
    }

    public function home(Request $request)
{
    $search = $request->input('search');
    $method = $request->input('method', 'like');

    if ($search) {
        $items = match($method) {

            // ── Option 1: LIKE query ───────────────────
            'like' => Item::where(function ($q) use ($search) {
                            $q->where('title',        'LIKE', "%{$search}%")
                              ->orWhere('description', 'LIKE', "%{$search}%")
                              ->orWhere('category',    'LIKE', "%{$search}%");
                        })
                        ->orderBy('item_id', 'desc')
                        ->paginate(9)
                        ->withQueryString(),

            // ── Option 2: Model Scope ──────────────────
            'scope' => Item::search($search)
                        ->orderBy('item_id', 'desc')
                        ->paginate(9)
                        ->withQueryString(),

            // ── Option 3: Laravel Scout ────────────────
            'scout' => Item::search($search)
                        ->query(fn($q) => $q->orderBy('item_id', 'desc'))
                        ->paginate(9),

            default => Item::orderBy('item_id', 'desc')->paginate(9)->withQueryString(),
        };
    } else {
        $items = Item::orderBy('item_id', 'desc')->paginate(9)->withQueryString();
    }

    return view('home', compact('items', 'search', 'method'));
}
}