@extends('layouts.admin')
@section('title', 'Sales Reports')
@push('styles')
<style>
.period-tabs{display:flex;gap:0;margin-bottom:28px;border:1.5px solid var(--border);border-radius:10px;overflow:hidden;width:fit-content}
.period-tab{padding:9px 22px;font-size:.85rem;font-weight:600;color:var(--muted);text-decoration:none;transition:all .2s;border:none;background:var(--bg)}
.period-tab.active{background:var(--green);color:#fff}
.period-tab:hover:not(.active){background:var(--green-xpale)}
.report-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:18px;margin-bottom:32px}
.rcard{background:var(--white);border:1px solid var(--border);border-radius:14px;padding:22px;text-align:center}
.rcard .rv{font-size:1.9rem;font-weight:700;color:var(--green);font-family:'Playfair Display',serif}
.rcard .rl{font-size:.75rem;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.05em;margin-top:4px}
.rcard.amber .rv{color:var(--amber)}
.rcard.red .rv{color:var(--red)}
.chart-bars{display:flex;align-items:flex-end;gap:8px;height:160px}
.bar-col{flex:1;display:flex;flex-direction:column;align-items:center;gap:5px}
.bar-val{font-size:.65rem;color:var(--muted);font-weight:600;text-align:center}
.bar-rect{width:100%;border-radius:5px 5px 0 0;transition:height .4s ease}
.bar-lbl{font-size:.65rem;color:var(--muted);font-weight:600}
.top-products-list{}
.tp-row{display:flex;align-items:center;gap:14px;padding:12px 0;border-bottom:1px solid var(--border)}
.tp-rank{font-size:1.1rem;font-weight:700;color:var(--muted);width:28px;text-align:center}
.tp-info{flex:1}
.tp-name{font-size:.88rem;font-weight:600}
.tp-meta{font-size:.76rem;color:var(--muted)}
.tp-rev{font-size:.88rem;font-weight:700;color:var(--green)}
.status-dots{display:flex;flex-wrap:wrap;gap:10px}
.status-dot{padding:6px 14px;border-radius:50px;font-size:.8rem;font-weight:600}
</style>
@endpush
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <h1 style="font-family:'Playfair Display',serif;font-size:1.8rem">📈 Sales Reports</h1>
    <div style="font-size:.82rem;color:var(--muted)">{{ $label }}</div>
</div>

<div class="period-tabs">
    <a href="{{ route('admin.reports.index', ['period'=>'daily']) }}"  class="period-tab {{ $period==='daily'  ? 'active' : '' }}">📅 Today</a>
    <a href="{{ route('admin.reports.index', ['period'=>'weekly']) }}" class="period-tab {{ $period==='weekly' ? 'active' : '' }}">📆 Last 7 Days</a>
    <a href="{{ route('admin.reports.index', ['period'=>'monthly']) }}"class="period-tab {{ $period==='monthly'? 'active' : '' }}">🗓 Last 30 Days</a>
</div>

<div class="report-grid">
    <div class="rcard">
        <div class="rv">{{ $summary['orders'] }}</div>
        <div class="rl">Total Orders</div>
    </div>
    <div class="rcard">
        <div class="rv" style="font-size:1.4rem">PKR {{ number_format($summary['revenue'], 0) }}</div>
        <div class="rl">Revenue</div>
    </div>
    <div class="rcard amber">
        <div class="rv" style="font-size:1.4rem">PKR {{ number_format($summary['avg_order'], 0) }}</div>
        <div class="rl">Avg Order Value</div>
    </div>
    <div class="rcard red">
        <div class="rv">{{ $summary['cancelled'] }}</div>
        <div class="rl">Cancelled</div>
    </div>
</div>

{{-- Revenue Chart --}}
<div class="admin-card" style="margin-bottom:24px">
    <h3 style="font-family:'Playfair Display',serif;font-size:1.1rem;margin-bottom:4px">Revenue — {{ $label }}</h3>
    <div style="font-size:.8rem;color:var(--muted);margin-bottom:20px">PKR revenue per {{ $period === 'daily' ? 'hour slot' : 'day' }}</div>
    @php $maxRev = max(array_column($chart,'revenue')) ?: 1; @endphp
    <div class="chart-bars">
        @foreach($chart as $day)
        @php $h = max(4, round(($day['revenue']/$maxRev)*140)); @endphp
        <div class="bar-col">
            <div class="bar-val">{{ $day['revenue'] > 0 ? number_format($day['revenue']/1000,0).'k' : '' }}</div>
            <div class="bar-rect" style="height:{{ $h }}px;background:{{ $day['revenue']>0 ? 'var(--green)' : 'var(--border)' }}"></div>
            <div class="bar-lbl">{{ $day['label'] }}</div>
        </div>
        @endforeach
    </div>
</div>

{{-- Orders Chart --}}
<div class="admin-card" style="margin-bottom:24px">
    <h3 style="font-family:'Playfair Display',serif;font-size:1.1rem;margin-bottom:4px">Orders — {{ $label }}</h3>
    <div style="font-size:.8rem;color:var(--muted);margin-bottom:20px">Number of orders per {{ $period === 'daily' ? 'hour' : 'day' }}</div>
    @php $maxOrd = max(array_column($chart,'orders')) ?: 1; @endphp
    <div class="chart-bars">
        @foreach($chart as $day)
        @php $h = max(4, round(($day['orders']/$maxOrd)*140)); @endphp
        <div class="bar-col">
            <div class="bar-val">{{ $day['orders'] > 0 ? $day['orders'] : '' }}</div>
            <div class="bar-rect" style="height:{{ $h }}px;background:{{ $day['orders']>0 ? '#1d6fa4' : 'var(--border)' }}"></div>
            <div class="bar-lbl">{{ $day['label'] }}</div>
        </div>
        @endforeach
    </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:24px">
    <div class="admin-card">
        <h3 style="font-family:'Playfair Display',serif;font-size:1.1rem;margin-bottom:16px">🏆 Top Selling Products</h3>
        @if($top_products->isEmpty())
        <p style="color:var(--muted);font-size:.88rem">No sales data for this period yet.</p>
        @else
        <div class="top-products-list">
            @foreach($top_products as $i => $item)
            <div class="tp-row">
                <div class="tp-rank">{{ $i + 1 }}</div>
                @if($item->product)
                <img src="{{ $item->product->image }}" style="width:44px;height:44px;border-radius:8px;object-fit:cover">
                <div class="tp-info">
                    <div class="tp-name">{{ $item->product->name }}</div>
                    <div class="tp-meta">{{ $item->total_qty }} units sold</div>
                </div>
                @else
                <div class="tp-info"><div class="tp-name" style="color:var(--muted)">Deleted product</div></div>
                @endif
                <div class="tp-rev">PKR {{ number_format($item->total_revenue, 0) }}</div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <div class="admin-card">
        <h3 style="font-family:'Playfair Display',serif;font-size:1.1rem;margin-bottom:16px">📊 Order Status Breakdown</h3>
        @php
            $statusColors = [
                'pending'    => '#e9a825',
                'confirmed'  => '#2d6a4f',
                'processing' => '#1d6fa4',
                'shipped'    => '#8338ec',
                'delivered'  => '#27ae60',
                'cancelled'  => '#c0392b',
            ];
        @endphp
        @if($status_counts->isEmpty())
        <p style="color:var(--muted);font-size:.88rem">No orders in this period.</p>
        @else
        <div style="display:flex;flex-direction:column;gap:10px">
            @foreach($status_counts as $status => $count)
            @php $color = $statusColors[$status] ?? '#666'; @endphp
            <div style="display:flex;align-items:center;gap:10px">
                <div style="width:10px;height:10px;border-radius:50%;background:{{ $color }};flex-shrink:0"></div>
                <div style="flex:1;font-size:.85rem;font-weight:600">{{ ucfirst($status) }}</div>
                <div style="font-size:.85rem;font-weight:700;color:{{ $color }}">{{ $count }}</div>
            </div>
            @endforeach
        </div>
        <div style="margin-top:20px;padding-top:16px;border-top:1px solid var(--border)">
            @php $total = $status_counts->sum(); @endphp
            @foreach($status_counts as $status => $count)
            @php $color = $statusColors[$status] ?? '#666'; $pct = $total > 0 ? round(($count/$total)*100) : 0; @endphp
            <div style="margin-bottom:8px">
                <div style="display:flex;justify-content:space-between;font-size:.74rem;color:var(--muted);margin-bottom:3px">
                    <span>{{ ucfirst($status) }}</span><span>{{ $pct }}%</span>
                </div>
                <div style="height:6px;background:var(--border);border-radius:50px;overflow:hidden">
                    <div style="height:100%;width:{{ $pct }}%;background:{{ $color }};border-radius:50px"></div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
