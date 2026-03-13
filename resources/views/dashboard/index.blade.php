@extends('layouts.admin-base')

@section('body')

<style>
    .kapture-page {
        background: var(--kapture-black);
        min-height: 100vh;
        padding: 2rem 2.5rem;
        font-family: 'Montserrat', sans-serif;
        color: var(--kapture-text);
    }

    /* ── Header ── */
    .dash-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--kapture-border);
    }
    .dash-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem;
        font-weight: 300;
        color: #fff;
        margin: 0;
        line-height: 1;
    }
    .dash-sub {
        font-size: 0.62rem;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--kapture-muted);
        margin-top: 0.25rem;
        font-style: italic;
    }
    .dash-user {
        font-size: 0.6rem;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--kapture-gold);
    }

    /* ── Stat Cards ── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.85rem;
        margin-bottom: 1rem;
    }

    .stat-card {
        border: 1px solid var(--kapture-border-subtle);
        padding: 1rem 1.25rem;
        background: rgba(255,255,255,0.01);
        display: flex;
        align-items: center;
        gap: 0.9rem;
        transition: border-color 0.3s;
        position: relative;
        overflow: hidden;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 2px;
        background: var(--kapture-gold);
        opacity: 0.4;
    }

    .stat-card:hover { border-color: rgba(201,168,76,0.3); }

    .stat-icon-wrap {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--kapture-border-subtle);
        color: var(--kapture-gold);
        font-size: 1rem;
        flex-shrink: 0;
    }

    .stat-body { flex: 1; min-width: 0; }

    .stat-label {
        font-size: 0.55rem;
        font-weight: 500;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--kapture-muted);
        margin-bottom: 0.2rem;
        white-space: nowrap;
    }

    .stat-value {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.6rem;
        font-weight: 300;
        color: #fff;
        line-height: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stat-value sup {
        font-size: 0.65rem;
        color: var(--kapture-gold);
        font-family: 'Montserrat', sans-serif;
        font-weight: 500;
        vertical-align: super;
    }

    /* ── Chart layout ── */
    .chart-full {
        margin-bottom: 0.85rem;
    }

    .chart-half {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.85rem;
    }

    /* ── Panel ── */
    .kap-panel {
        border: 1px solid var(--kapture-border-subtle);
        padding: 1.1rem 1.4rem 1.25rem;
        background: rgba(255,255,255,0.01);
    }

    .kap-panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.85rem;
        padding-bottom: 0.6rem;
        border-bottom: 1px solid var(--kapture-border-subtle);
    }

    .kap-panel-title {
        font-size: 0.52rem;
        font-weight: 600;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: var(--kapture-gold);
        margin: 0;
    }

    /* ── Date Filter ── */
    .kap-filter {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .kap-filter input[type=date] {
        background: transparent;
        border: none;
        border-bottom: 1px solid var(--kapture-border-subtle);
        color: var(--kapture-text);
        font-family: 'Montserrat', sans-serif;
        font-size: 0.58rem;
        padding: 0.1rem 0;
        outline: none;
        color-scheme: dark;
        width: 100px;
        transition: border-color 0.2s;
    }
    .kap-filter input[type=date]:focus { border-bottom-color: var(--kapture-gold); }
    .kap-filter span { font-size: 0.52rem; color: var(--kapture-muted); }
    .kap-filter button {
        background: transparent;
        border: 1px solid var(--kapture-border-subtle);
        color: var(--kapture-gold);
        font-family: 'Montserrat', sans-serif;
        font-size: 0.5rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        padding: 0.18rem 0.55rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .kap-filter button:hover {
        border-color: var(--kapture-gold);
        background: rgba(201,168,76,0.07);
    }

    /* ── Chart canvas sizing ── */
    .chart-full .kap-panel { }
    .chart-full canvas {
        max-height: 160px !important;
        width: 100% !important;
    }
    .chart-half canvas {
        max-height: 190px !important;
        width: 100% !important;
    }

    canvas { max-width: 100% !important; }

    @media (max-width: 1100px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 860px)  { .chart-half { grid-template-columns: 1fr; } }
    @media (max-width: 520px)  { .stat-grid { grid-template-columns: 1fr; } }
</style>

<div class="kapture-page">

    {{-- Header --}}
    <div class="dash-header">
        <div>
            <h1 class="dash-title">Dashboard</h1>
            <p class="dash-sub">Overview — Analytics & Reports</p>
        </div>
        <span class="dash-user">{{ Auth::check() ? Auth::user()->name : 'Admin' }}</span>
    </div>

    {{-- Stat Cards --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon-wrap"><i class="bi bi-bag-check"></i></div>
            <div class="stat-body">
                <p class="stat-label">Total Orders</p>
                <p class="stat-value">{{ number_format($totalOrders) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-wrap"><i class="bi bi-cash-stack"></i></div>
            <div class="stat-body">
                <p class="stat-label">Total Revenue</p>
                <p class="stat-value"><sup>₱</sup>{{ number_format($totalRevenue, 0) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-wrap"><i class="bi bi-people"></i></div>
            <div class="stat-body">
                <p class="stat-label">Users</p>
                <p class="stat-value">{{ number_format($totalUsers) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-wrap"><i class="bi bi-camera"></i></div>
            <div class="stat-body">
                <p class="stat-label">Catalogue Items</p>
                <p class="stat-value">{{ number_format($totalItems) }}</p>
            </div>
        </div>
    </div>

    {{-- Yearly Sales — full width --}}
    <div class="chart-full">
        <div class="kap-panel">
            <div class="kap-panel-head">
                <p class="kap-panel-title">Yearly Sales — Last 5 Years</p>
            </div>
            {!! $yearlyChart->container() !!}
        </div>
    </div>

    {{-- Sales by Product + Pie — side by side --}}
    <div class="chart-half">
        <div class="kap-panel">
            <div class="kap-panel-head">
                <p class="kap-panel-title">Sales by Product</p>
                <div class="kap-filter">
                    <input type="date" id="dateFrom" value="{{ $dateFrom }}">
                    <span>–</span>
                    <input type="date" id="dateTo" value="{{ $dateTo }}">
                    <button id="filterBtn">Filter</button>
                </div>
            </div>
            {!! $productBarChart->container() !!}
        </div>

        <div class="kap-panel">
            <div class="kap-panel-head">
                <p class="kap-panel-title">Sales Share per Product</p>
            </div>
            <div style="display:flex; align-items:center; gap:0;">
                <div style="flex:0 0 42%; max-width:42%;">
                    {!! $itemChart->container() !!}
                </div>
                <div id="pie-legend" style="
                    flex: 1;
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 0.22rem 0.75rem;
                    min-width: 0;
                    align-content: center;
                    padding-left: 1rem;
                "></div>
            </div>
        </div>
    </div>

</div>

{!! $yearlyChart->script() !!}
{!! $productBarChart->script() !!}
{!! $itemChart->script() !!}

<script>
document.addEventListener('DOMContentLoaded', function () {
    const gold      = '#C9A84C';
    const gridColor = 'rgba(255,255,255,0.04)';
    const textColor = 'rgba(255,255,255,0.35)';
    const bgColors  = [
        '#C9A84C','#d4b456','#b89028','#e0c068','#a07830',
        '#f0d888','#806020','#c0a050','#e8c878','#987030'
    ];

    function applyTheme() {
        if (typeof Chart === 'undefined') return;
        Chart.defaults.color       = textColor;
        Chart.defaults.borderColor = gridColor;

        Object.values(Chart.instances).forEach(chart => {
            const type = chart.config.type;
            const opts = chart.options;

            // Force hide axes on pie/doughnut
            if (type === 'pie' || type === 'doughnut') {
                opts.scales = {};
                if (chart.scales) {
                    Object.keys(chart.scales).forEach(key => {
                        chart.scales[key].options.display = false;
                    });
                }
            }

            // Axis styles — skip pie/doughnut
            if (opts.scales && type !== 'pie' && type !== 'doughnut') {
                ['x','y'].forEach(axis => {
                    if (!opts.scales[axis]) return;
                    opts.scales[axis].ticks = {
                        ...(opts.scales[axis].ticks || {}),
                        color: textColor,
                        font: { family: 'Montserrat', size: 9 },
                        maxRotation: 35,
                        maxTicksLimit: axis === 'y' ? 5 : undefined,
                    };
                    opts.scales[axis].grid   = { color: gridColor };
                    opts.scales[axis].border = { color: 'transparent' };
                });
            }

            // Legend
            if (opts.plugins?.legend) {
                opts.plugins.legend.labels = {
                    color: textColor,
                    font: { family: 'Montserrat', size: 9 },
                    boxWidth: 8,
                    padding: 10,
                };
            }

            // Tooltip
            opts.plugins = opts.plugins || {};
            opts.plugins.tooltip = {
                backgroundColor : 'rgba(10,10,15,0.95)',
                titleColor      : gold,
                bodyColor       : 'rgba(255,255,255,0.65)',
                borderColor     : 'rgba(201,168,76,0.2)',
                borderWidth     : 1,
                titleFont       : { family: 'Montserrat', size: 10, weight: '600' },
                bodyFont        : { family: 'Montserrat', size: 9 },
                padding         : 8,
                cornerRadius    : 0,
                callbacks: (type === 'pie' || type === 'doughnut') ? {
                    label: ctx => ` ${ctx.label}: ${ctx.parsed}%`
                } : {},
            };

            // Dataset colors
            chart.data.datasets.forEach((ds, i) => {
                if (type === 'bar') {
                    ds.backgroundColor = bgColors.map(c => c + 'bb');
                    ds.borderColor     = bgColors;
                    ds.borderWidth     = 1;
                    ds.borderRadius    = 2;
                } else if (type === 'pie' || type === 'doughnut') {
                    ds.backgroundColor = bgColors;
                    ds.borderColor     = '#0a0a0f';
                    ds.borderWidth     = 2;
                }
            });

            chart.update();
        });
    }

    function buildPieLegend() {
        const pie = Object.values(Chart.instances).find(c =>
            c.config.type === 'pie' || c.config.type === 'doughnut'
        );
        const el = document.getElementById('pie-legend');
        if (!pie || !el) return;

        const labels = pie.data.labels || [];
        const colors = pie.data.datasets[0]?.backgroundColor || [];

        el.innerHTML = labels.map((label, i) => `
            <div style="display:flex; align-items:center; gap:0.3rem; overflow:hidden;">
                <span style="
                    width:7px; height:7px; border-radius:1px;
                    background:${colors[i] || '#C9A84C'};
                    flex-shrink:0;
                "></span>
                <span style="
                    font-family:'Montserrat',sans-serif;
                    font-size:0.55rem;
                    color:rgba(255,255,255,0.4);
                    white-space:nowrap;
                    overflow:hidden;
                    text-overflow:ellipsis;
                    letter-spacing:0.02em;
                ">${label}</span>
            </div>
        `).join('');
    }

    setTimeout(applyTheme, 200);
    setTimeout(buildPieLegend, 400);

    // Date filter
    document.getElementById('filterBtn').addEventListener('click', function () {
        const dateFrom = document.getElementById('dateFrom').value;
        const dateTo   = document.getElementById('dateTo').value;
        if (!dateFrom || !dateTo) return;

        fetch(`{{ route('dashboard.productChartData') }}?date_from=${dateFrom}&date_to=${dateTo}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            const chart = Object.values(Chart.instances).find(c =>
                c.data.datasets[0]?.label === 'Revenue (₱)'
            );
            if (!chart) return;
            chart.data.labels                      = data.labels;
            chart.data.datasets[0].data            = data.totals;
            chart.data.datasets[0].backgroundColor = bgColors.slice(0, data.labels.length).map(c => c + 'bb');
            chart.data.datasets[0].borderColor     = bgColors.slice(0, data.labels.length);
            chart.update();
        })
        .catch(err => console.error('Filter error:', err));
    });
});
</script>

@endsection