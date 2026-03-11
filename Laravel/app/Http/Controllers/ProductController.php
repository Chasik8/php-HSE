<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('q')) {
            $q = $request->string('q');
            $query->where(function ($builder) use ($q) {
                $builder
                    ->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }

        $products = $query->orderBy('name')->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product, Request $request)
    {
        $product->load('category', 'ratings.user');

        $recent = $request->session()->get('recently_viewed', []);
        $recent = array_values(array_unique(array_merge([$product->id], $recent)));
        $recent = array_slice($recent, 0, 5);
        $request->session()->put('recently_viewed', $recent);

        $recentProducts = Product::whereIn('id', $recent)
            ->where('id', '!=', $product->id)
            ->get();

        return view('products.show', compact('product', 'recentProducts'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image_url' => ['nullable', 'url'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Товар создан.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image_url' => ['nullable', 'url'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Товар обновлён.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Товар удалён.');
    }

    public function adminIndex()
    {
        $products = Product::with('category')->orderBy('name')->paginate(20);

        return view('admin.products.index', compact('products'));
    }
}

