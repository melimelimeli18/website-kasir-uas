<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    // INDEXING
    public function itemsIndex()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    public function saleIndex()
    {
        $items = Item::all();
        return view('sale.index', compact('items'));
    }
    // EDIT
    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    //CREATE
    public function create()
    {
        return view('items.create');
    }

    //UPDATE
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'photo' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // Jika ada foto baru, hapus foto lama dan simpan yang baru
        if ($request->hasFile('photo')) {
            if ($item->photo) {
                Storage::disk('public')->delete($item->photo);
            }
            $photoPath = $request->file('photo')->store('food_photos', 'public');
            $item->photo = $photoPath;
        }

        $item->name = $request->name;
        $item->price = $request->price;
        $item->stock = $request->stock;
        $item->save();

        return redirect()->route('items.index')->with('success', 'Menu berhasil diperbarui!');
    }

    //DESTROY
    public function destroy(Item $item)
    {
        if ($item->photo) {
            Storage::disk('public')->delete($item->photo);
        }
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Menu berhasil dihapus!');
    }
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('food_photos', 'public');
        }

        Item::create([
            'photo' => $photoPath,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('items.index')->with('success', 'Menu berhasil ditambahkan!');
    }
}
