{{-- FILE PATH: resources/views/products/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Products')
@section('page-title', 'Products')
@section('page-subtitle', 'Inventory List')

@section('content')

<div class="page-header">
    <div>
        <h1>
            @if(Auth::user()->isStaff()) View Products
            @elseif(Auth::user()->isInventoryManager()) Manage Products
            @else Inventory Overview
            @endif
        </h1>
        <p>{{ $products->total() }} total items &mdash;
            <span class="badge {{ Auth::user()->isAdmin() ? 'badge-gold' : (Auth::user()->isInventoryManager() ? 'badge-purple' : 'badge-teal') }}">
                <i class="fas {{ Auth::user()->getRoleIcon() }}"></i> {{ Auth::user()->getRoleLabel() }}
            </span>
        </p>
    </div>
    <div style="display:flex;gap:8px;">
        @if(Auth::user()->isInventoryManager())
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Product
            </a>
        @endif
        @if(Auth::user()->isAdmin() || Auth::user()->isInventoryManager())
            <a href="{{ route('products.index') }}?status=low" class="btn btn-outline" style="border-color:var(--amber);color:var(--amber);">
                <i class="fas fa-triangle-exclamation"></i> Low Stock
            </a>
        @endif
    </div>
</div>

{{-- ACCESS BANNER --}}
@if(Auth::user()->isAdmin())
<div style="background:rgba(201,168,76,0.08);border:1px solid rgba(201,168,76,0.25);border-radius:8px;padding:10px 16px;margin-bottom:18px;font-size:13px;color:#9a7a20;display:flex;align-items:center;gap:8px;">
    <i class="fas fa-shield-halved"></i>
    <span><strong>Administrator:</strong> You have full read access to inventory. Use the admin panel to manage users and configure the system. Inventory changes are handled by the Inventory Manager.</span>
</div>
@elseif(Auth::user()->isInventoryManager())
<div style="background:var(--purple2);border:1px solid #c7d2fe;border-radius:8px;padding:10px 16px;margin-bottom:18px;font-size:13px;color:var(--purple);display:flex;align-items:center;gap:8px;">
    <i class="fas fa-boxes-stacked"></i>
    <span><strong>Inventory Manager:</strong> You can Add, Update, Delete products and manage Request / Borrow / Return transactions.</span>
</div>
@elseif(Auth::user()->isStaff())
<div style="background:var(--teal2);border:1px solid #99f6e4;border-radius:8px;padding:10px 16px;margin-bottom:18px;font-size:13px;color:var(--teal);display:flex;align-items:center;gap:8px;">
    <i class="fas fa-user"></i>
    <span><strong>Staff:</strong> You can view all products and monitor stock levels. Contact the Inventory Manager for stock changes.</span>
</div>
@endif

{{-- FILTERS --}}
<div class="card mb-4">
    <div class="card-body" style="padding:14px 18px;">
        <form method="GET" action="{{ route('products.index') }}" class="search-form">
            <div class="search-input-wrap">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="form-control" placeholder="Search by name or SKU…" value="{{ request('search') }}">
            </div>
            <select name="category_id" class="form-select" style="width:170px;">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select" style="width:150px;">
                <option value="">All Status</option>
                <option value="low" {{ request('status')==='low' ? 'selected' : '' }}>Low Stock</option>
                <option value="out" {{ request('status')==='out' ? 'selected' : '' }}>Out of Stock</option>
            </select>
            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
            <a href="{{ route('products.index') }}" class="btn btn-outline"><i class="fas fa-xmark"></i> Clear</a>
        </form>
    </div>
</div>

{{-- TABLE --}}
<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td><span class="mono badge badge-navy">{{ $product->sku }}</span></td>
                    <td>
                        <strong>{{ $product->name }}</strong>
                        @if($product->description)
                        <div style="font-size:11px;color:var(--gray3);margin-top:2px;">{{ Str::limit($product->description, 40) }}</div>
                        @endif
                    </td>
                    <td>{{ $product->category->name ?? '—' }}</td>
                    <td style="font-size:12px;">{{ $product->supplier->name ?? '—' }}</td>
                    <td class="mono fw-600">₱{{ number_format($product->price, 2) }}</td>
                    <td>
                        <span style="font-weight:700;font-size:15px;color:{{ $product->quantity==0?'var(--red)':($product->isLowStock()?'var(--amber)':'var(--green)') }};">
                            {{ $product->quantity }}
                        </span>
                        <span style="font-size:11px;color:var(--gray3);"> {{ $product->unit }}</span>
                    </td>
                    <td>
                        @if($product->quantity == 0)
                            <span class="badge badge-red"><i class="fas fa-circle" style="font-size:7px;"></i> Out of Stock</span>
                        @elseif($product->isLowStock())
                            <span class="badge badge-amber"><i class="fas fa-circle" style="font-size:7px;"></i> Low Stock</span>
                        @else
                            <span class="badge badge-green"><i class="fas fa-circle" style="font-size:7px;"></i> In Stock</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:4px;justify-content:center;flex-wrap:wrap;">

                            {{-- View — ALL roles --}}
                            <a href="{{ route('products.show', $product) }}" class="btn btn-outline btn-sm btn-icon" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>

                            {{-- Edit — Inventory Manager only --}}
                            @if(Auth::user()->isInventoryManager())
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-outline btn-sm btn-icon" title="Update Product">
                                <i class="fas fa-pen"></i>
                            </a>
                            @endif

                            {{-- Delete — Inventory Manager only --}}
                            @if(Auth::user()->isInventoryManager())
                            <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Delete \'{{ $product->name }}\'? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm btn-icon" title="Delete Product">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif

                            {{-- Staff: no edit/delete buttons shown at all --}}
                            @if(Auth::user()->isStaff() || Auth::user()->isAdmin())
                            <span style="font-size:11px;color:var(--gray3);padding:6px 4px;display:flex;align-items:center;">
                                <i class="fas fa-eye-slash" style="margin-right:3px;"></i> Read only
                            </span>
                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="fas fa-boxes-stacked"></i>
                            <p>No products found.
                                @if(Auth::user()->isInventoryManager())
                                <a href="{{ route('products.create') }}" style="color:var(--navy);font-weight:600;">Add your first product.</a>
                                @endif
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="pagination-wrap">
        <span>Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} results</span>
        <div class="pagination">
            @if($products->onFirstPage())
                <span class="page-item"><span class="page-link" style="opacity:0.4;">‹</span></span>
            @else
                <span class="page-item"><a class="page-link" href="{{ $products->previousPageUrl() }}">‹</a></span>
            @endif
            @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                <span class="page-item {{ $page==$products->currentPage()?'active':'' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </span>
            @endforeach
            @if($products->hasMorePages())
                <span class="page-item"><a class="page-link" href="{{ $products->nextPageUrl() }}">›</a></span>
            @else
                <span class="page-item"><span class="page-link" style="opacity:0.4;">›</span></span>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection