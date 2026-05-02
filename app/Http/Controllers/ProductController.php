<?php
// FILE PATH: app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // ✅ ALL roles — view product list
    public function index(Request $request)
    {
        $query = Product::with(['category', 'supplier']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('sku',  'like', "%{$request->search}%");
            });
        }
        if ($request->category_id) $query->where('category_id', $request->category_id);
        if ($request->status === 'low') $query->whereColumn('quantity', '<=', 'reorder_level')->where('quantity', '>', 0);
        elseif ($request->status === 'out') $query->where('quantity', 0);

        $products   = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();
        return view('products.index', compact('products', 'categories'));
    }

    // ✅ INVENTORY MANAGER only — Add Product
    public function create()
    {
        if (!Auth::user()->canAddProduct()) {
            return redirect()->route('dashboard')
                ->with('error', '🔒 Access Denied: Only Inventory Managers can add products.');
        }
        return view('products.create', [
            'categories' => Category::all(),
            'suppliers'  => Supplier::all(),
        ]);
    }

    // ✅ INVENTORY MANAGER only — Save new product
    public function store(Request $request)
    {
        if (!Auth::user()->canAddProduct()) {
            return redirect()->route('dashboard')
                ->with('error', '🔒 Access Denied: Only Inventory Managers can add products.');
        }

        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'sku'           => 'required|string|unique:products',
            'description'   => 'nullable|string',
            'category_id'   => 'required|exists:categories,id',
            'supplier_id'   => 'required|exists:suppliers,id',
            'price'         => 'required|numeric|min:0',
            'quantity'      => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'unit'          => 'required|string',
            'status'        => 'required|in:active,inactive',
        ]);

        $product = Product::create($data);

        if ($data['quantity'] > 0) {
            StockMovement::create([
                'product_id' => $product->id,
                'type'       => 'in',
                'quantity'   => $data['quantity'],
                'reference'  => 'INITIAL',
                'notes'      => 'Initial stock entry',
                'user_id'    => Auth::id(),
            ]);
        }

        return redirect()->route('products.index')
            ->with('success', "✅ Product '{$product->name}' added successfully.");
    }

    // ✅ ALL roles — view product detail
    public function show(Product $product)
    {
        $product->load(['category', 'supplier']);
        $movements = $product->stockMovements()->with('user')->latest()->paginate(10);
        return view('products.show', compact('product', 'movements'));
    }

    // ✅ INVENTORY MANAGER only — Update Product form
    public function edit(Product $product)
    {
        if (!Auth::user()->canUpdateProduct()) {
            return redirect()->route('products.show', $product)
                ->with('error', '🔒 Access Denied: Only Inventory Managers can update products.');
        }
        return view('products.edit', [
            'product'    => $product,
            'categories' => Category::all(),
            'suppliers'  => Supplier::all(),
        ]);
    }

    // ✅ INVENTORY MANAGER only — Save updates
    public function update(Request $request, Product $product)
    {
        if (!Auth::user()->canUpdateProduct()) {
            return redirect()->route('dashboard')
                ->with('error', '🔒 Access Denied: Only Inventory Managers can update products.');
        }

        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'sku'           => 'required|string|unique:products,sku,' . $product->id,
            'description'   => 'nullable|string',
            'category_id'   => 'required|exists:categories,id',
            'supplier_id'   => 'required|exists:suppliers,id',
            'price'         => 'required|numeric|min:0',
            'reorder_level' => 'required|integer|min:0',
            'unit'          => 'required|string',
            'status'        => 'required|in:active,inactive',
        ]);

        $product->update($data);
        return redirect()->route('products.index')
            ->with('success', "✅ Product '{$product->name}' updated successfully.");
    }

    // ✅ INVENTORY MANAGER only — Delete Product
    public function destroy(Product $product)
    {
        if (!Auth::user()->canDeleteProduct()) {
            return redirect()->route('products.index')
                ->with('error', '🔒 Access Denied: Only Inventory Managers can delete products.');
        }

        $name = $product->name;
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', "🗑️ Product '{$name}' deleted successfully.");
    }

    // ✅ ALL roles — Stock In (Request/Borrow item)
    public function stockIn(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity'  => 'required|integer|min:1',
            'reference' => 'nullable|string|max:100',
            'notes'     => 'nullable|string',
        ]);

        $product->increment('quantity', $data['quantity']);
        StockMovement::create([
            'product_id' => $product->id,
            'type'       => 'in',
            'quantity'   => $data['quantity'],
            'reference'  => $data['reference'] ?? null,
            'notes'      => $data['notes'] ?? null,
            'user_id'    => Auth::id(),
        ]);

        return back()->with('success', "✅ +{$data['quantity']} {$product->unit} added to stock.");
    }

    // ✅ ALL roles — Stock Out (Return item / issue)
    public function stockOut(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity'  => "required|integer|min:1|max:{$product->quantity}",
            'reference' => 'nullable|string|max:100',
            'notes'     => 'nullable|string',
        ]);

        $product->decrement('quantity', $data['quantity']);
        StockMovement::create([
            'product_id' => $product->id,
            'type'       => 'out',
            'quantity'   => $data['quantity'],
            'reference'  => $data['reference'] ?? null,
            'notes'      => $data['notes'] ?? null,
            'user_id'    => Auth::id(),
        ]);

        return back()->with('success', "✅ -{$data['quantity']} {$product->unit} removed from stock.");
    }
}