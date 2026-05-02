{{-- FILE PATH: resources/views/products/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')
@section('page-subtitle', $product->name)

@section('content')

<div class="breadcrumb">
    <a href="{{ route('products.index') }}">Products</a>
    <span class="sep">›</span>
    <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
    <span class="sep">›</span>
    <span class="current">Edit</span>
</div>

<div class="page-header">
    <div>
        <h1>Edit Product</h1>
        <p class="mono" style="color:var(--gray4);">SKU: {{ $product->sku }}</p>
    </div>
    <a href="{{ route('products.show', $product) }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<form method="POST" action="{{ route('products.update', $product) }}">
    @csrf @method('PUT')

    <div style="display:grid; grid-template-columns: 1fr 320px; gap:20px; align-items:start;">
        <div>
            <div class="card" style="margin-bottom:18px;">
                <div class="card-header"><span class="card-title"><i class="fas fa-info-circle" style="color:var(--gold); margin-right:8px;"></i>Basic Information</span></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Product Name <span style="color:var(--red)">*</span></label>
                        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name', $product->name) }}" required>
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">SKU <span style="color:var(--red)">*</span></label>
                            <input type="text" name="sku" class="form-control mono {{ $errors->has('sku') ? 'is-invalid' : '' }}" value="{{ old('sku', $product->sku) }}" required>
                            @error('sku')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Unit <span style="color:var(--red)">*</span></label>
                            <select name="unit" class="form-select" required>
                                @foreach(['pcs','box','ream','kg','liter','set','roll','bag','can','pack'] as $u)
                                    <option value="{{ $u }}" {{ old('unit', $product->unit) == $u ? 'selected' : '' }}>{{ strtoupper($u) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><span class="card-title"><i class="fas fa-warehouse" style="color:var(--gold); margin-right:8px;"></i>Pricing & Thresholds</span></div>
                <div class="card-body">
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Price (₱)</label>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Reorder Level</label>
                            <input type="number" name="reorder_level" class="form-control" value="{{ old('reorder_level', $product->reorder_level) }}" min="0" required>
                        </div>
                    </div>
                    <div style="background:var(--amber2); border:1px solid #f0d080; border-radius:var(--radius); padding:12px 16px; font-size:13px; color:var(--amber);">
                        <i class="fas fa-circle-info"></i>
                        <strong>Current Stock:</strong> {{ $product->quantity }} {{ $product->unit }} — Use Stock In/Out on the product page to adjust quantity.
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="card" style="margin-bottom:18px;">
                <div class="card-header"><span class="card-title">Classification</span></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Supplier</label>
                        <select name="supplier_id" class="form-select" required>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}" {{ old('supplier_id', $product->supplier_id) == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active"   {{ old('status', $product->status) === 'active'   ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div style="display:flex; flex-direction:column; gap:10px;">
                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="{{ route('products.show', $product) }}" class="btn btn-outline" style="width:100%; justify-content:center;">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection