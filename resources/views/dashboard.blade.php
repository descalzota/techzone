@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    .tz-hero {
        background: linear-gradient(135deg, #1f2937 0%, #2563eb 100%);
        border-radius: 1rem;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .tz-hero::after {
        content: "\F4E1"; /* bi-cpu */
        font-family: "bootstrap-icons";
        position: absolute;
        right: 2rem;
        bottom: -1.5rem;
        font-size: 9rem;
        opacity: .12;
        line-height: 1;
    }
    .tz-hero p { color: rgba(255,255,255,.85); max-width: 640px; }

    .tz-stat {
        border: 0;
        border-radius: 1rem;
        box-shadow: 0 2px 10px rgba(15, 23, 42, .06);
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .tz-stat:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(15, 23, 42, .12);
    }
    .tz-icon {
        width: 52px;
        height: 52px;
        border-radius: .85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    .tz-label {
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #6b7280;
        font-weight: 600;
    }
    .tz-value { font-size: 2rem; font-weight: 700; line-height: 1.1; }
    .tz-action {
        border-radius: 1rem;
        border: 1px solid #e5e7eb;
        transition: border-color .2s ease, background .2s ease;
        text-decoration: none;
        color: inherit;
    }
    .tz-action:hover { border-color: #2563eb; background: #f8fbff; color: inherit; }
</style>

{{-- Hero --}}
<div class="tz-hero p-4 p-md-5 mb-4 shadow-sm">
    <h1 class="fw-bold mb-2">TechZone Inventory Management System</h1>
    <p class="lead mb-4">
        Manage your Inventory in one place.
    </p>
    <a href="{{ route('products.index') }}" class="btn btn-light fw-semibold me-2">
        <i class="bi bi-box-seam me-1"></i> View All Products
    </a>
    <a href="{{ route('products.create') }}" class="btn btn-outline-light fw-semibold">
        <i class="bi bi-plus-lg me-1"></i> Add Product
    </a>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card tz-stat h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="tz-icon bg-primary-subtle text-primary"><i class="bi bi-box-seam"></i></div>
                <div>
                    <div class="tz-label">Total Products</div>
                    <div class="tz-value">{{ number_format($totalProducts) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card tz-stat h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="tz-icon bg-success-subtle text-success"><i class="bi bi-stack"></i></div>
                <div>
                    <div class="tz-label">Total Stock</div>
                    <div class="tz-value">{{ number_format($totalStock) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card tz-stat h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="tz-icon bg-warning-subtle text-warning"><i class="bi bi-exclamation-triangle"></i></div>
                <div>
                    <div class="tz-label">Low Stock Items</div>
                    <div class="tz-value {{ $lowStockCount > 0 ? 'text-warning' : '' }}">
                        {{ number_format($lowStockCount) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card tz-stat h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="tz-icon bg-info-subtle text-info"><i class="bi bi-tags"></i></div>
                <div>
                    <div class="tz-label">Categories</div>
                    <div class="tz-value">{{ number_format($totalCategories) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Stock health + quick actions --}}
@php
    $lowPercent = $totalProducts > 0 ? round(($lowStockCount / $totalProducts) * 100) : 0;
    $healthyPercent = 100 - $lowPercent;
@endphp

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card tz-stat h-100">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-1">Stock Health</h5>
                <p class="text-muted small mb-3">Share of products running low on stock.</p>

                <div class="progress" style="height: 14px; border-radius: 99px;">
                    <div class="progress-bar bg-success" style="width: {{ $healthyPercent }}%"></div>
                    <div class="progress-bar bg-warning" style="width: {{ $lowPercent }}%"></div>
                </div>

                <div class="d-flex justify-content-between mt-3 small">
                    <span><i class="bi bi-circle-fill text-success me-1"></i>Healthy: {{ $healthyPercent }}%</span>
                    <span><i class="bi bi-circle-fill text-warning me-1"></i>Low stock: {{ $lowPercent }}%</span>
                </div>

                @if($lowStockCount > 0)
                    <div class="alert alert-warning d-flex align-items-center mt-3 mb-0 py-2" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        {{ $lowStockCount }} {{ Str::plural('item', $lowStockCount) }} need restocking soon.
                    </div>
                @else
                    <div class="alert alert-success d-flex align-items-center mt-3 mb-0 py-2" role="alert">
                        <i class="bi bi-check-circle me-2"></i> All products are well stocked.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card tz-stat h-100">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Quick Actions</h5>

                <a href="{{ route('products.create') }}" class="tz-action d-flex align-items-center gap-3 p-3 mb-3">
                    <div class="tz-icon bg-success-subtle text-success"><i class="bi bi-plus-circle"></i></div>
                    <div>
                        <div class="fw-semibold">Add a new product</div>
                        <div class="text-muted small">Register a new item in the inventory</div>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>

                <a href="{{ route('products.index') }}" class="tz-action d-flex align-items-center gap-3 p-3">
                    <div class="tz-icon bg-primary-subtle text-primary"><i class="bi bi-list-ul"></i></div>
                    <div>
                        <div class="fw-semibold">Browse products</div>
                        <div class="text-muted small">View, edit, or remove existing items</div>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection