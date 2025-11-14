<?php

namespace App\Http\Controllers;

use App\Models\FoodMenu;
use Illuminate\Http\Request;

class FoodMenuController extends Controller
{
    public function index()
    {
        $foodMenus = FoodMenu::all();
        return view('foodmenu.index', compact('foodMenus'));
    }

    public function create()
    {
        return view('foodmenu.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('food_images', 'public');
            $validated['image'] = $path;
        }

        FoodMenu::create($validated);

        return redirect()->route('foodmenu.index')->with('success', 'Food menu item created successfully.');
    }

    public function edit($id)
    {
        $foodMenu = FoodMenu::findOrFail($id);
        return view('foodmenu.edit', compact('foodMenu'));
    }

    public function update(Request $request, $id)
    {
        $foodMenu = FoodMenu::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('food_images', 'public');
            $validated['image'] = $path;
        }

        $foodMenu->update($validated);

        return redirect()->route('foodmenu.index')->with('success', 'Food menu item updated successfully.');
    }

    public function destroy($id)
    {
        $foodMenu = FoodMenu::findOrFail($id);
        $foodMenu->delete();

        return redirect()->route('foodmenu.index')->with('success', 'Food menu item deleted successfully.');
    }
}
