{{-- FILE PATH: resources/views/products/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Add Product')
@section('page-title', 'Add Product')
@section('page-subtitle', 'New Inventory Item')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('products.index') }}">Products</a>
    <span class="sep">›</span>
    <span class="current">New Product</span>
</div>

<div class="page-header">
    <div>
        <h1>Add New Product</h1>
        <p>Fill in the details below to add a new product to the inventory.</p>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<form method="POST" action="{{ route('products.store') }}">
    @csrf

    <div style="display:grid; grid-template-columns: 1fr 320px; gap:20px; align-items:start;">

        <div>
            {{-- BASIC INFO --}}
            <div class="card" style="margin-bottom:18px;">
                <div class="card-header"><span class="card-title"><i class="fas fa-info-circle" style="color:var(--gold); margin-right:8px;"></i>Basic Information</span></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Product Name <span style="color:var(--red)">*</span></label>
                        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}" placeholder="e.g. Wireless Keyboard Pro" required>
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">SKU / Item Code <span style="color:var(--red)">*</span></label>
                            <input type="text" name="sku" class="form-control mono {{ $errors->has('sku') ? 'is-invalid' : '' }}" value="{{ old('sku') }}" placeholder="e.g. ELEC-004" required>
                            @error('sku')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Unit of Measure <span style="color:var(--red)">*</span></label>
                            <select name="unit" class="form-select {{ $errors->has('unit') ? 'is-invalid' : '' }}" required>
                                <option value="">— Select Unit —</option>
                                @foreach(['pcs','box','ream','kg','liter','set','roll','bag','can','pack'] as $u)
                                    <option value="{{ $u }}" {{ old('unit') == $u ? 'selected' : '' }}>{{ strtoupper($u) }}</option>
                                @endforeach
                            </select>
                            @error('unit')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="Optional product description…">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- STOCK INFO --}}
            <div class="card">
                <div class="card-header"><span class="card-title"><i class="fas fa-warehouse" style="color:var(--gold); margin-right:8px;"></i>Stock & Pricing</span></div>
                <div class="card-body">
                    <div class="form-grid-3">
                        <div class="form-group">
                            <label class="form-label">Price (₱) <span style="color:var(--red)">*</span></label>
                            <input type="number" step="0.01" name="price" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" value="{{ old('price') }}" placeholder="0.00" required>
                            @error('price')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Initial Quantity <span style="color:var(--red)">*</span></label>
                            <input type="number" name="quantity" class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" value="{{ old('quantity', 0) }}" min="0" required>
                            @error('quantity')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Reorder Level <span style="color:var(--red)">*</span></label>
                            <input type="number" name="reorder_level" class="form-control {{ $errors->has('reorder_level') ? 'is-invalid' : '' }}" value="{{ old('reorder_level', 10) }}" min="0" required>
                            @error('reorder_level')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SIDEBAR FIELDS --}}
        <div>
            <div class="card" style="margin-bottom:18px;">
                <div class="card-header"><span class="card-title">Classification</span></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Category <span style="color:var(--red)">*</span></label>
                        <select name="category_id" class="form-select {{ $errors->has('category_id') ? 'is-invalid' : '' }}" required>
                            <option value="">— Select Category —</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Supplier <span style="color:var(--red)">*</span></label>
                        <select name="supplier_id" class="form-select {{ $errors->has('supplier_id') ? 'is-invalid' : '' }}" required>
                            <option value="">— Select Supplier —</option>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div style="display:flex; flex-direction:column; gap:10px;">
                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                    <i class="fas fa-save"></i> Save Product
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-outline" style="width:100%; justify-content:center;">
                    Cancel
                </a>
            </div>
        </div>
    </div>
</form>
@endsection