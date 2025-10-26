<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query()
            ->whereNull('deleted_at')
            ->filter($request); // kendi filter scope’un varsa burada çalışır

        // 🔹 Varsayılan sıralama (sort parametresi yoksa)
        if (!$request->has('sort')) {
            $query->orderBy('updated_at', 'desc');
        }

        // 🔹 Sayfalama: her sayfada 10 kayıt, mevcut query stringleri koru
        $categories = $query->paginate(10)->withQueryString();

        return view('categories.index', compact('categories'));
    }


    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->whereNull('deleted_at'),
            ],
        ], [
            'name.required' => 'Kategori adı zorunludur.',
            'name.unique' => 'Bu kategori zaten mevcut.',
        ]);
        Category::create($request->only('name'));
        return redirect()->route('categories.index')->with('success', 'Kategori eklendi.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category->id)->whereNull('deleted_at'),
            ],
        ], [
            'name.unique' => 'Bu kategori adı zaten mevcut.',
        ]);
        $category->update($request->only('name'));
        return redirect()->route('categories.index')->with('success', 'Kategori güncellendi.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if ($category->tasks()->exists()) {
            return redirect()->route('categories.index')
                ->with('error', 'Bu kategoriye ait görevler bulunduğu için silinemez. Önce görevleri silmelisiniz.');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori silindi.');
    }
}
