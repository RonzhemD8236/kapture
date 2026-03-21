<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ItemsDataTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ItemsImport;

class ItemController extends Controller
{
    // ── Public storefront ──────────────────────────────────────────────────

    public function getItems()
    {
        $items = DB::table('item')->whereNull('deleted_at')->get();
        return view('shop.index', compact('items'));
    }

    public function addToCart($id)      { /* cart logic */ }
    public function getCart()           { /* cart logic */ }
    public function getReduceByOne($id) { /* cart logic */ }
    public function getRemoveItem($id)  { /* cart logic */ }
    public function postCheckout()      { /* checkout logic */ }

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
            ->where('i.item_id', $id)
            ->whereNull('i.deleted_at')
            ->first();

        abort_if(!$item, 404);
        return view('item.show', compact('item'));
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
}