<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $method = $request->input('method', 'like');

        if ($search) {
            $items = match($method) {

                // ── Option 1: LIKE query ───────────────
                'like' => Item::where(function ($q) use ($search) {
                                $q->where('title',        'LIKE', "%{$search}%")
                                  ->orWhere('description', 'LIKE', "%{$search}%")
                                  ->orWhere('category',    'LIKE', "%{$search}%");
                            })
                            ->orderBy('item_id', 'desc')
                            ->paginate(9),

                // ── Option 2: Model Scope ──────────────
                'scope' => Item::search($search)
                            ->orderBy('item_id', 'desc')
                            ->paginate(9),

                // ── Option 3: Laravel Scout ────────────
                'scout' => Item::search($search)->paginate(9),

                // ── Default fallback ───────────────────
                default => Item::orderBy('item_id', 'desc')->paginate(9),
            };
        } else {
            $items = Item::orderBy('item_id', 'desc')->paginate(9);
        }

        return view('home', compact('items', 'search', 'method'));
    }
}