{{-- FILE PATH: resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('title', $product->name)
@section('page-title', $product->name)
@section('page-subtitle', 'Product Detail')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('products.index') }}">Products</a>
    <span class="sep">›</span>
    <span class="current">{{ $product->name }}</span>
</div>

<div class="page-header">
    <div>
        <h1>{{ $product->name }}</h1>
        <div style="display:flex; align-items:center; gap:10px; margin-top:5px;">
            <span class="badge badge-navy mono">{{ $product->sku }}</span>
            @if($product->quantity == 0)
                <span class="badge badge-red">Out of Stock</span>
            @elseif($product->isLowStock())
                <span class="badge badge-amber">Low Stock</span>
            @else
                <span class="badge badge-green">In Stock</span>
            @endif
        </div>
    </div>
    <div style="display:flex; gap:10px;">
        <button onclick="openModal('stockInModal')" class="btn btn-success"><i class="fas fa-arrow-up"></i> Stock In</button>
        <button onclick="openModal('stockOutModal')" class="btn btn-danger" {{ $product->quantity == 0 ? 'disabled' : '' }}><i class="fas fa-arrow-down"></i> Stock Out</button>
        <a href="{{ route('products.edit', $product) }}" class="btn btn-outline"><i class="fas fa-pen"></i> Edit</a>
    </div>
</div>

<div style="display:grid; grid-template-columns: 1fr 300px; gap:20px; align-items:start; margin-bottom:20px;">

    {{-- PRODUCT DETAILS --}}
    <div class="card">
        <div class="card-header"><span class="card-title">Product Information</span></div>
        <div class="card-body">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                <div>
                    <div class="form-label">Product Name</div>
                    <div class="fw-600">{{ $product->name }}</div>
                </div>
                <div>
                    <div class="form-label">SKU</div>
                    <div class="mono fw-600">{{ $product->sku }}</div>
                </div>
                <div>
                    <div class="form-label">Category</div>
                    <div>{{ $product->category->name ?? '—' }}</div>
                </div>
                <div>
                    <div class="form-label">Supplier</div>
                    <div>{{ $product->supplier->name ?? '—' }}</div>
                </div>
                <div>
                    <div class="form-label">Unit Price</div>
                    <div class="fw-600" style="font-size:18px; color:var(--navy);">₱{{ number_format($product->price, 2) }}</div>
                </div>
                <div>
                    <div class="form-label">Unit of Measure</div>
                    <div>{{ strtoupper($product->unit) }}</div>
                </div>
                @if($product->description)
                <div style="grid-column: span 2;">
                    <div class="form-label">Description</div>
                    <div style="color:var(--text2);">{{ $product->description }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- STOCK SUMMARY --}}
    <div>
        <div class="card" style="margin-bottom:14px;">
            <div class="card-header"><span class="card-title">Stock Summary</span></div>
            <div class="card-body">
                <div style="text-align:center; padding:12px 0;">
                    <div style="font-size:52px; font-weight:800; color:{{ $product->quantity == 0 ? 'var(--red)' : ($product->isLowStock() ? 'var(--amber)' : 'var(--green)') }}; line-height:1;">
                        {{ $product->quantity }}
                    </div>
                    <div style="font-size:14px; color:var(--gray4); margin-top:4px;">{{ strtoupper($product->unit) }} available</div>
                </div>
                <div style="border-top:1px solid var(--gray2); padding-top:16px; margin-top:12px; display:grid; grid-template-columns:1fr 1fr; gap:12px; text-align:center;">
                    <div>
                        <div style="font-size:11px; color:var(--gray4);">Reorder Level</div>
                        <div style="font-size:18px; font-weight:700; color:var(--amber);">{{ $product->reorder_level }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px; color:var(--gray4);">Total Value</div>
                        <div style="font-size:18px; font-weight:700; color:var(--navy);">₱{{ number_format($product->price * $product->quantity, 0) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-title">Details</span></div>
            <div class="card-body" style="font-size:13px;">
                <div style="display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid var(--gray2);">
                    <span style="color:var(--gray4);">Status</span>
                    <span class="badge {{ $product->status === 'active' ? 'badge-green' : 'badge-gray' }}">{{ ucfirst($product->status) }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid var(--gray2);">
                    <span style="color:var(--gray4);">Added On</span>
                    <span>{{ $product->created_at->format('M d, Y') }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; padding:6px 0;">
                    <span style="color:var(--gray4);">Last Updated</span>
                    <span>{{ $product->updated_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MOVEMENT HISTORY --}}
<div class="card">
    <div class="card-header">
        <span class="card-title"><i class="fas fa-timeline" style="color:var(--gold); margin-right:8px;"></i>Stock Movement History</span>
        <span style="font-size:12px; color:var(--gray4);">{{ $movements->total() }} records</span>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Reference</th>
                    <th>Notes</th>
                    <th>Processed By</th>
                    <th>Date & Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movements as $mov)
                <tr>
                    <td class="mono text-muted">{{ $mov->id }}</td>
                    <td>
                        @if($mov->type === 'in')
                            <span class="badge badge-green"><i class="fas fa-plus"></i> Stock In</span>
                        @elseif($mov->type === 'out')
                            <span class="badge badge-red"><i class="fas fa-minus"></i> Stock Out</span>
                        @else
                            <span class="badge badge-gray"><i class="fas fa-sliders"></i> Adjustment</span>
                        @endif
                    </td>
                    <td class="mono fw-600" style="color:{{ $mov->type === 'in' ? 'var(--green)' : 'var(--red)' }};">
                        {{ $mov->type === 'in' ? '+' : '-' }}{{ $mov->quantity }}
                    </td>
                    <td class="mono">{{ $mov->reference ?? '—' }}</td>
                    <td style="max-width:200px; color:var(--text2);">{{ $mov->notes ?? '—' }}</td>
                    <td>{{ $mov->user->name ?? '—' }}</td>
                    <td class="text-muted">{{ $mov->created_at->format('M d, Y h:i A') }}</td>
                </tr>
                @empty
                <tr><td colspan="7"><div class="empty-state"><i class="fas fa-inbox"></i><p>No movements recorded yet.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($movements->hasPages())
    <div class="pagination-wrap">
        <span>Showing {{ $movements->firstItem() }}–{{ $movements->lastItem() }} of {{ $movements->total() }}</span>
        {{ $movements->links() }}
    </div>
    @endif
</div>

{{-- STOCK IN MODAL --}}
<div class="modal-overlay" id="stockInModal">
    <div class="modal-box">
        <div class="modal-header">
            <span class="modal-title"><i class="fas fa-arrow-up" style="color:var(--green); margin-right:8px;"></i>Stock In — {{ $product->name }}</span>
            <button class="modal-close" onclick="closeModal('stockInModal')">✕</button>
        </div>
        <form method="POST" action="{{ route('products.stock-in', $product) }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Quantity to Add <span style="color:var(--red)">*</span></label>
                    <input type="number" name="quantity" class="form-control" min="1" placeholder="Enter quantity" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Reference / PO Number</label>
                    <input type="text" name="reference" class="form-control mono" placeholder="e.g. PO-2024-001">
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" style="min-height:70px;" placeholder="Optional notes…"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('stockInModal')">Cancel</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Confirm Stock In</button>
            </div>
        </form>
    </div>
</div>

{{-- STOCK OUT MODAL --}}
<div class="modal-overlay" id="stockOutModal">
    <div class="modal-box">
        <div class="modal-header">
            <span class="modal-title"><i class="fas fa-arrow-down" style="color:var(--red); margin-right:8px;"></i>Stock Out — {{ $product->name }}</span>
            <button class="modal-close" onclick="closeModal('stockOutModal')">✕</button>
        </div>
        <form method="POST" action="{{ route('products.stock-out', $product) }}">
            @csrf
            <div class="modal-body">
                <div style="background:var(--amber2); border:1px solid #f0d080; border-radius:var(--radius); padding:10px 14px; font-size:13px; color:var(--amber); margin-bottom:16px;">
                    <strong>Available:</strong> {{ $product->quantity }} {{ $product->unit }}
                </div>
                <div class="form-group">
                    <label class="form-label">Quantity to Remove <span style="color:var(--red)">*</span></label>
                    <input type="number" name="quantity" class="form-control" min="1" max="{{ $product->quantity }}" placeholder="Enter quantity" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Reference / Issue No.</label>
                    <input type="text" name="reference" class="form-control mono" placeholder="e.g. ISS-2024-001">
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" style="min-height:70px;" placeholder="Optional notes…"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('stockOutModal')">Cancel</button>
                <button type="submit" class="btn btn-danger"><i class="fas fa-minus"></i> Confirm Stock Out</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.add('show'); }
    function closeModal(id) { document.getElementById(id).classList.remove('show'); }
    document.querySelectorAll('.modal-overlay').forEach(el => {
        el.addEventListener('click', e => { if (e.target === el) el.classList.remove('show'); });
    });
</script>
@endsection