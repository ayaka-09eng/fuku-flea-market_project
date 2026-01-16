<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExhibitionRequest;

class ItemController extends Controller
{
    public function index(Request $request) {
        $tab = $request->query('tab', 'recommend');
        $keyword = $request->query('keyword');

        if ($tab === 'mylist') {
            if (!Auth::check()) {
                $items = collect();
                return view('items.index', compact('items', 'tab', 'keyword'));
            }

            $query = Auth::user()
                ->likedItems()
                ->orderBy('created_at', 'desc');
        } else {
            if (Auth::check()) {
                $query = Item::where('user_id', '!=', Auth::id())
                    ->orderBy('created_at', 'desc');
            } else {
                $query = Item::orderBy('created_at', 'desc');
            }
        }

        $query = $query->keywordSearch($keyword);
        $items = $query->get();

        return view('items.index', compact('items', 'tab', 'keyword'));
    }

    public function create() {
        $conditions = Item::conditions();
        $categories = Category::all();
        return view('items.sell', compact('conditions', 'categories'));
    }

    public function store(ExhibitionRequest $request) {
        $validated = $request->validated();
        $brand = $request->input('brand');
        $validated['img_path'] = $request->file('img_path')->store('items', 'public');
        $validated['user_id'] = Auth::id();
        $item = Item::create($validated + ['brand' => $brand]);
        $item->categories()->attach($validated['category_id']);
        return redirect()->route('items.index');
    }

    public function show($item_id) {
        $item = Item::with(['likes', 'comments.user.profile', 'categories'])->findOrFail($item_id);
        return view('items.show', compact('item'));
    }

    public function toggleLike($id) {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $item = Item::findOrFail($id);
        $user = Auth::user();

        if ($item->likes()->where('user_id', $user->id)->exists()) {
            $item->likes()->detach($user->id);
            $status = 'unliked';
        } else {
            $item->likes()->attach($user->id);
            $status = 'liked';
        }

        return response()->json([
            'status' => $status,
            'count' => $item->likes()->count(),
        ]);
    }
}
