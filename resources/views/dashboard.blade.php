<<<<<<< HEAD
{{-- FILE PATH: resources/views/dashboard.blade.php --}}
@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview')

@section('content')

{{-- WELCOME BANNER --}}
<div style="background:linear-gradient(135deg,#0f1d35 0%,#1e3258 100%);border-radius:12px;padding:22px 28px;margin-bottom:22px;display:flex;align-items:center;justify-content:space-between;">
    <div>
        <div style="font-size:19px;font-weight:700;color:#fff;">
            @if(Auth::user()->isAdmin()) 🛡️
            @elseif(Auth::user()->isManager()) 👔
            @else 👤 @endif
            Welcome, {{ Auth::user()->name }}!
            <span style="font-size:12px;background:{{ Auth::user()->getRoleBadgeColor() }};color:#fff;padding:2px 10px;border-radius:20px;margin-left:8px;font-weight:600;opacity:0.85;">{{ strtoupper(Auth::user()->role) }}</span>
        </div>
        <div style="font-size:13px;color:rgba(255,255,255,0.5);margin-top:4px;">{{ now()->format('l, F d, Y') }} &mdash; StockVault Inventory Management</div>
    </div>
    <div style="display:flex;gap:10px;">
        @if(Auth::user()->canEdit())
        <a href="{{ route('products.create') }}" class="btn btn-gold"><i class="fas fa-plus"></i> Add Product</a>
        @endif
        <a href="{{ route('products.index') }}" class="btn" style="background:rgba(255,255,255,0.1);color:#fff;border:1px solid rgba(255,255,255,0.2);"><i class="fas fa-boxes-stacked"></i> View Inventory</a>
    </div>
</div>

{{-- KPI CARDS ROW 1 --}}
<div class="stats-grid" style="margin-bottom:16px;">
    <div class="stat-card">
        <div class="stat-icon navy"><i class="fas fa-boxes-stacked"></i></div>
        <div>
            <div class="stat-label">Total Products</div>
            <div class="stat-value">{{ $totalProducts }}</div>
            <div class="stat-sub">Active inventory items</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon gold"><i class="fas fa-peso-sign"></i></div>
        <div>
            <div class="stat-label">Inventory Value</div>
            <div class="stat-value" style="font-size:19px;">₱{{ number_format($totalValue, 0) }}</div>
            <div class="stat-sub">At current pricing</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber"><i class="fas fa-triangle-exclamation"></i></div>
        <div>
            <div class="stat-label">Low Stock</div>
            <div class="stat-value">{{ $lowStockCount }}</div>
            <div class="stat-sub">Below reorder level</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-ban"></i></div>
        <div>
            <div class="stat-label">Out of Stock</div>
            <div class="stat-value">{{ $outOfStock }}</div>
            <div class="stat-sub">Needs immediate reorder</div>
        </div>
    </div>
</div>

{{-- KPI CARDS ROW 2 --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:22px;">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(99,102,241,0.12);color:#6366f1;"><i class="fas fa-tag"></i></div>
        <div><div class="stat-label">Categories</div><div class="stat-value">{{ $totalCategories }}</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(20,184,166,0.12);color:#14b8a6;"><i class="fas fa-truck"></i></div>
        <div><div class="stat-label">Suppliers</div><div class="stat-value">{{ $totalSuppliers }}</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-arrow-up"></i></div>
        <div><div class="stat-label">Stock In (7d)</div><div class="stat-value" style="color:var(--green);">+{{ $stockIn }}</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-arrow-down"></i></div>
        <div><div class="stat-label">Stock Out (7d)</div><div class="stat-value" style="color:var(--red);">-{{ $stockOut }}</div></div>
    </div>
</div>

{{-- CHARTS ROW --}}
<div style="display:grid;grid-template-columns:1.4fr 1fr;gap:20px;margin-bottom:22px;">
    {{-- Bar Chart --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-chart-bar" style="color:var(--gold);margin-right:8px;"></i>Stock Levels by Product</span>
            <span style="font-size:11px;color:var(--gray3);">Current vs Reorder Level</span>
        </div>
        <div class="card-body" style="position:relative;height:250px;">
            <canvas id="stockChart"></canvas>
        </div>
    </div>

    {{-- Donut Chart --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-chart-pie" style="color:var(--gold);margin-right:8px;"></i>By Category</span>
        </div>
        <div class="card-body" style="display:flex;align-items:center;gap:18px;">
            <div style="position:relative;flex-shrink:0;">
                <canvas id="categoryChart" width="160" height="160"></canvas>
                <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
                    <div style="font-size:20px;font-weight:800;color:var(--text);">{{ $totalProducts }}</div>
                    <div style="font-size:10px;color:var(--gray3);">items</div>
                </div>
            </div>
            <div id="categoryLegend" style="flex:1;"></div>
        </div>
    </div>
</div>

{{-- STOCK IN/OUT + VALUABLE --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:22px;">
    {{-- Stock In vs Out Bar --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-chart-column" style="color:var(--gold);margin-right:8px;"></i>Weekly Movement Summary</span>
            <span style="font-size:11px;color:var(--gray3);">Last 7 days</span>
        </div>
        <div class="card-body">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                <div style="background:var(--green2);border-radius:10px;padding:16px;text-align:center;border:1px solid #a8e0cc;">
                    <div style="font-size:28px;font-weight:800;color:var(--green);">+{{ $stockIn }}</div>
                    <div style="font-size:12px;color:var(--green);font-weight:600;margin-top:2px;"><i class="fas fa-arrow-up"></i> Total Stock In</div>
                </div>
                <div style="background:var(--red2);border-radius:10px;padding:16px;text-align:center;border:1px solid #f0c4be;">
                    <div style="font-size:28px;font-weight:800;color:var(--red);">-{{ $stockOut }}</div>
                    <div style="font-size:12px;color:var(--red);font-weight:600;margin-top:2px;"><i class="fas fa-arrow-down"></i> Total Stock Out</div>
                </div>
            </div>
            <div style="background:var(--gray1);border-radius:8px;padding:14px;">
                <div style="font-size:12px;color:var(--gray4);margin-bottom:8px;font-weight:600;">NET MOVEMENT</div>
                @php $net = $stockIn - $stockOut; @endphp
                <div style="font-size:24px;font-weight:800;color:{{ $net >= 0 ? 'var(--green)' : 'var(--red)' }};">
                    {{ $net >= 0 ? '+' : '' }}{{ $net }} units
                </div>
                <div style="font-size:12px;color:var(--gray3);margin-top:4px;">
                    {{ $net >= 0 ? 'Stock increased this week' : 'Stock decreased this week' }}

                </div>
            </div>
        </div>
    </div>

    {{-- Most Valuable Products --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-trophy" style="color:var(--gold);margin-right:8px;"></i>Most Valuable Stock</span>
            <span style="font-size:11px;color:var(--gray3);">By total value</span>
        </div>
        <div>
            @foreach($valuableProducts as $i => $vp)
            @php $value = $vp->price * $vp->quantity; @endphp
            <div style="display:flex;align-items:center;gap:12px;padding:12px 20px;border-bottom:1px solid var(--gray2);">
                <div style="width:26px;height:26px;border-radius:50%;background:{{ ['#c9a84c','#adb5c9','#b87333','#6366f1','#14b8a6'][$i] }};display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:#fff;flex-shrink:0;">{{ $i+1 }}</div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:13px;font-weight:600;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $vp->name }}</div>
                    <div style="font-size:11px;color:var(--gray4);">{{ $vp->quantity }} {{ $vp->unit }} @ ₱{{ number_format($vp->price,2) }}</div>
                </div>
                <div style="font-size:13px;font-weight:700;color:var(--navy);">₱{{ number_format($value,0) }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- BOTTOM ROW --}}
<div style="display:grid;grid-template-columns:1fr 300px;gap:20px;">

    {{-- Recent Movements Table --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-clock-rotate-left" style="color:var(--gold);margin-right:8px;"></i>Recent Stock Movements</span>
            <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm">View All</a>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr><th>Product</th><th>Type</th><th>Qty</th><th>Reference</th><th>By</th><th>Date</th></tr>
                </thead>
                <tbody>
                    @forelse($recentMovements as $mov)
                    <tr>
                        <td><strong>{{ Str::limit($mov->product->name ?? '—', 22) }}</strong></td>
                        <td>
                            @if($mov->type==='in') <span class="badge badge-green"><i class="fas fa-arrow-up"></i> In</span>
                            @elseif($mov->type==='out') <span class="badge badge-red"><i class="fas fa-arrow-down"></i> Out</span>
                            @else <span class="badge badge-gray"><i class="fas fa-sliders"></i> Adj</span>
                            @endif
                        </td>
                        <td class="mono fw-600" style="color:{{ $mov->type==='in'?'var(--green)':'var(--red)' }};">{{ $mov->type==='in'?'+':'-' }}{{ $mov->quantity }}</td>
                        <td class="mono text-muted" style="font-size:12px;">{{ $mov->reference ?? '—' }}</td>
                        <td style="font-size:12px;">{{ $mov->user->name ?? '—' }}</td>
                        <td class="text-muted" style="font-size:12px;">{{ $mov->created_at->format('M d, H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6"><div class="empty-state"><i class="fas fa-inbox"></i><p>No movements yet.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- RIGHT COLUMN --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Low Stock Alerts --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title"><i class="fas fa-bell" style="color:var(--amber);margin-right:8px;"></i>Alerts</span>
                @if($lowStockCount > 0)<span class="badge badge-amber">{{ $lowStockCount + $outOfStock }}</span>@endif
            </div>
            @forelse($lowStockProducts as $product)
            <a href="{{ route('products.show', $product) }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;text-decoration:none;border-bottom:1px solid var(--gray2);transition:background 0.12s;" onmouseover="this.style.background='var(--gray1)'" onmouseout="this.style.background='transparent'">
                <div style="width:30px;height:30px;border-radius:7px;background:{{ $product->quantity==0?'var(--red2)':'var(--amber2)' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-box" style="color:{{ $product->quantity==0?'var(--red)':'var(--amber)' }};font-size:12px;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:12px;font-weight:600;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $product->name }}</div>
                    <div style="font-size:10px;color:var(--gray4);">Min: {{ $product->reorder_level }} {{ $product->unit }}</div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:14px;font-weight:800;color:{{ $product->quantity==0?'var(--red)':'var(--amber)' }};">{{ $product->quantity }}</div>
                </div>
            </a>
            @empty
            <div class="empty-state" style="padding:22px;"><i class="fas fa-check-circle" style="color:var(--green);"></i><p style="font-size:13px;">All stock healthy!</p></div>
            @endforelse
        </div>

        {{-- Quick Actions (role-based) --}}
        <div class="card">
            <div class="card-header"><span class="card-title"><i class="fas fa-bolt" style="color:var(--gold);margin-right:8px;"></i>Quick Actions</span></div>
            <div class="card-body" style="padding:14px;display:flex;flex-direction:column;gap:8px;">
                @if(Auth::user()->canEdit())
                <a href="{{ route('products.create') }}" class="btn btn-primary" style="justify-content:center;"><i class="fas fa-plus"></i> Add New Product</a>
                @endif
                <a href="{{ route('products.index') }}?status=low" class="btn btn-outline" style="justify-content:center;border-color:var(--amber);color:var(--amber);"><i class="fas fa-triangle-exclamation"></i> Low Stock Items</a>
                <a href="{{ route('products.index') }}?status=out" class="btn btn-outline" style="justify-content:center;border-color:var(--red);color:var(--red);"><i class="fas fa-ban"></i> Out of Stock</a>
                <a href="{{ route('products.index') }}" class="btn btn-outline" style="justify-content:center;"><i class="fas fa-list"></i> All Products</a>
            </div>
        </div>
    </div>
</div>

{{-- CATEGORY CARDS --}}
<div class="card mt-4">
    <div class="card-header"><span class="card-title"><i class="fas fa-layer-group" style="color:var(--navy);margin-right:8px;"></i>Inventory by Category</span></div>
    <div class="card-body" style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;">
        @php $catColors=['#6366f1','#14b8a6','#f59e0b','#ef4444','#8b5cf6','#06b6d4']; @endphp
        @foreach($categoryData as $i => $cat)
        <div style="border:1px solid var(--gray2);border-radius:10px;padding:18px;text-align:center;border-top:3px solid {{ $catColors[$i%count($catColors)] }};">
            <div style="font-size:26px;font-weight:800;color:var(--text);">{{ $cat->products_count }}</div>
            <div style="font-size:13px;color:var(--gray4);margin-top:3px;font-weight:500;">{{ $cat->name }}</div>
            <div style="font-size:11px;color:var(--gray3);">products</div>
        </div>
        @endforeach
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
const stockData = @json($topProducts);
const catData   = @json($categoryData);
const COLORS    = ['#6366f1','#14b8a6','#f59e0b','#ef4444','#8b5cf6','#06b6d4'];

// Bar chart
const labels   = stockData.map(p => p.name.length>15 ? p.name.substring(0,15)+'…' : p.name);
const qty      = stockData.map(p => p.quantity);
const minQty   = stockData.map(p => p.reorder_level);
const bgColors = qty.map((q,i) => q===0?'#fee2e2': q<=minQty[i]?'#fef3c7':'#d1fae5');
const bdColors = qty.map((q,i) => q===0?'#ef4444': q<=minQty[i]?'#f59e0b':'#10b981');

new Chart(document.getElementById('stockChart'), {
    type: 'bar',
    data: {
        labels,
        datasets: [
            { label:'Current Stock', data:qty, backgroundColor:bgColors, borderColor:bdColors, borderWidth:2, borderRadius:6 },
            { label:'Reorder Level', data:minQty, type:'line', borderColor:'#f59e0b', borderDash:[5,5], borderWidth:2, pointRadius:3, fill:false, tension:0.1 }
        ]
    },
    options: {
        responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{ position:'bottom', labels:{ font:{size:11}, boxWidth:12 } } },
        scales:{
            y:{ beginAtZero:true, grid:{color:'#f1f3f7'}, ticks:{font:{size:11}} },
            x:{ grid:{display:false}, ticks:{font:{size:11}} }
        }
    }
});

// Donut chart
const catLabels = catData.map(c => c.name);
const catCounts = catData.map(c => c.products_count);
new Chart(document.getElementById('categoryChart'), {
    type:'doughnut',
    data:{ labels:catLabels, datasets:[{ data:catCounts, backgroundColor:COLORS, borderWidth:2, borderColor:'#fff' }] },
    options:{ responsive:false, cutout:'62%', plugins:{ legend:{display:false} } }
});

// Legend
const leg = document.getElementById('categoryLegend');
catLabels.forEach((l,i) => {
    leg.innerHTML += `<div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
        <div style="width:10px;height:10px;border-radius:3px;background:${COLORS[i]};flex-shrink:0;"></div>
        <div style="font-size:13px;color:var(--text2);flex:1;">${l}</div>
        <div style="font-size:13px;font-weight:700;color:var(--text);">${catCounts[i]}</div>
    </div>`;
});
</script>
@endsection


