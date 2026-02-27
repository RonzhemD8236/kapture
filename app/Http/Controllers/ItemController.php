<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ItemsImport;

class ItemController extends Controller
{
    // ── Public storefront ──────────────────────────────────────────────────

    public function getItems()
    {
        $items = DB::table('item')->get();
        return view('shop.index', compact('items'));
    }

    public function addToCart($id)      { /* cart logic */ }
    public function getCart()           { /* cart logic */ }
    public function getReduceByOne($id) { /* cart logic */ }
    public function getRemoveItem($id)  { /* cart logic */ }
    public function postCheckout()      { /* checkout logic */ }

    // ── Admin CRUD ─────────────────────────────────────────────────────────

    // ── Admin CRUD ─────────────────────────────────────────────────────────

    public function index(Request $request)
{
    $query = DB::table('item as i')
        ->leftJoin('stock as s', 'i.item_id', '=', 's.item_id')
        ->select(
            'i.item_id',
            'i.description',
            'i.sell_price',
            'i.cost_price',
            'i.img_path',
            's.quantity'
        );

    if ($request->filled('search')) {
        $query->where('i.description', 'like', '%' . $request->search . '%');
    }

    $items = $query->orderBy('i.item_id')->paginate(15);

    return view('item.index', compact('items'));
}

    public function create()
    {
        return view('item.create');
    }

        public function store(Request $request)
{
    $request->validate([
        'description' => 'required|string',
        'sell_price'  => 'required|numeric|min:0',
        'cost_price'  => 'required|numeric|min:0',
        'quantity'    => 'required|integer|min:0',
        'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imgPath = 'default.jpg';
    if ($request->hasFile('image')) {
        $imgPath = $request->file('image')->store('items', 'public');
    }

    $itemId = DB::table('item')->insertGetId([
        'description' => $request->description,
        'sell_price'  => $request->sell_price,
        'cost_price'  => $request->cost_price,
        'img_path'    => $imgPath,
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
        ->first();

    abort_if(!$item, 404);
    return view('item.edit', compact('item'));
}

    public function update(Request $request, $id)
{
    $request->validate([
        'description' => 'required|string',
        'sell_price'  => 'required|numeric|min:0',
        'cost_price'  => 'required|numeric|min:0',
        'quantity'    => 'required|integer|min:0',
        'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $item = DB::table('item')->where('item_id', $id)->first();
    abort_if(!$item, 404);

    $imgPath = $item->img_path;
    if ($request->hasFile('image')) {
        $imgPath = $request->file('image')->store('items', 'public');
    }

    DB::table('item')->where('item_id', $id)->update([
        'description' => $request->description,
        'sell_price'  => $request->sell_price,
        'cost_price'  => $request->cost_price,
        'img_path'    => $imgPath,
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

public function destroy($id)
{
    DB::table('stock')->where('item_id', $id)->delete(); // delete stock first
    DB::table('item')->where('item_id', $id)->delete();
    return redirect()->route('items.index')->with('success', 'Item deleted.');
}

    // ── Excel Import ───────────────────────────────────────────────────────

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new ItemsImport, $request->file('file'));
        return redirect()->route('items.index')->with('success', 'Items imported successfully.');
    }
}