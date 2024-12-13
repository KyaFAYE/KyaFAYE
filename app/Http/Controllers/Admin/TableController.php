<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Models\Category;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::with('category')->get();
        return view('admin.tables.index', compact('tables'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.tables.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tables',
            'capacity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'is_available' => 'boolean',
        ]);

        Table::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'category_id' => $request->category_id,
            'is_available' => $request->has('is_available') ? $request->is_available : true,
        ]);

        return redirect()->route('admin.tables.index')
                         ->with('success', 'Table créée avec succès.');
    }

    public function edit($id)
    {
        $table = Table::findOrFail($id);
        $categories = Category::all();
        return view('admin.tables.edit', compact('table', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tables,name,' . $id,
            'capacity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'is_available' => 'boolean',
        ]);

        $table = Table::findOrFail($id);
        $table->update([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'category_id' => $request->category_id,
            'is_available' => $request->has('is_available') ? $request->is_available : true,
        ]);

        return redirect()->route('admin.tables.index')
                         ->with('success', 'Table mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $table = Table::findOrFail($id);
        $table->delete();

        return redirect()->route('admin.tables.index')
                         ->with('success', 'Table supprimée avec succès.');
    }
}
