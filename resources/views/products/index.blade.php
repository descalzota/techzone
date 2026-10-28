@extends('layouts.app')

@section('title', 'Products')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    .tz-card {
        border: 0;
        border-radius: 1rem;
        box-shadow: 0 2px 10px rgba(15, 23, 42, .06);
        overflow: hidden;
    }
    .tz-table thead th {
        background: #1f2937;
        color: #fff;
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .06em;
        font-weight: 600;
        border: 0;
        padding: .9rem 1rem;
        white-space: nowrap;
    }
    .tz-table tbody td { padding: .85rem 1rem; border-color: #f1f3f5; }
    .tz-table tbody tr { transition: background .15s ease; }
    .tz-table tbody tr:hover { background: #f5f9ff; }
    .tz-code {
        font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
        font-size: .85rem;
        background: #f1f3f5;
        padding: .2rem .5rem;
        border-radius: .4rem;
        color: #374151;
    }
    .tz-icon-btn {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: .6rem;
        border: 0;
        font-size: 1rem;
        transition: transform .15s ease;
    }
    .tz-icon-btn:hover { transform: translateY(-2px); }
    .tz-badge {
        font-weight: 600;
        padding: .4rem .7rem;
        border-radius: 99px;
        font-size: .75rem;
    }
</style>

{{-- Header --}}
@php
    $isPaginated = method_exists($products, 'total');
    $totalCount  = $isPaginated ? $products->total() : $products->count();
    $categories  = collect($products)->pluck('category')->filter()->unique()->sort()->values();
@endphp

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        <div>
            <h2 class="fw-bold mb-0">Products</h2>
            <div class="text-muted small">{{ $totalCount }} {{ Str::plural('item', $totalCount) }} in inventory</div>
        </div>
    </div>
    <a href="{{ route('products.create') }}" class="btn btn-primary d-flex align-items-center gap-1">
        <i class="bi bi-plus-lg"></i> Add Product
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
    </div>
@endif

<div class="card tz-card">
    {{-- Toolbar --}}
    <div class="card-body border-bottom">
        <div class="row g-2">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" id="tzSearch" class="form-control border-start-0"
                           placeholder="Search by code, name, or supplier...">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <select id="tzCategory" class="form-select">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ strtolower($category) }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-3">
                <select id="tzStatus" class="form-select">
                    <option value="">All statuses</option>
                    <option value="available">Available</option>
                    <option value="low stock">Low Stock</option>
                    <option value="out of stock">Out of Stock</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table tz-table align-middle mb-0">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th class="text-end">Price</th>
                    <th class="text-center">Qty</th>
                    <th>Supplier</th>
                    <th>Status</th>
                    <th class="text-end" style="width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody id="tzBody">
                @forelse ($products as $product)
                    <tr data-category="{{ strtolower($product->category) }}"
                        data-status="{{ strtolower($product->status) }}"
                        data-search="{{ strtolower($product->product_code . ' ' . $product->name . ' ' . $product->supplier) }}">
                        <td><span class="tz-code">{{ $product->product_code }}</span></td>
                        <td class="fw-semibold">{{ $product->name }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $product->category }}</span></td>
                        <td class="text-end">₱{{ number_format($product->price, 2) }}</td>
                        <td class="text-center fw-semibold
                            {{ $product->quantity == 0 ? 'text-danger' : ($product->status === 'Low Stock' ? 'text-warning' : '') }}">
                            {{ $product->quantity }}
                        </td>
                        <td class="text-muted">{{ $product->supplier }}</td>
                        <td>
                            @if ($product->status === 'Available')
                                <span class="tz-badge bg-success-subtle text-success">
                                    <i class="bi bi-check-circle-fill me-1"></i>Available
                                </span>
                            @elseif ($product->status === 'Low Stock')
                                <span class="tz-badge bg-warning-subtle text-warning-emphasis">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>Low Stock
                                </span>
                            @else
                                <span class="tz-badge bg-danger-subtle text-danger">
                                    <i class="bi bi-x-circle-fill me-1"></i>Out of Stock
                                </span>
                            @endif
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('products.show', $product) }}"
                               class="tz-icon-btn bg-info-subtle text-info-emphasis"
                               title="View" data-bs-toggle="tooltip"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('products.edit', $product) }}"
                               class="tz-icon-btn bg-warning-subtle text-warning-emphasis"
                               title="Edit" data-bs-toggle="tooltip"><i class="bi bi-pencil-square"></i></a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="tz-icon-btn bg-danger-subtle text-danger"
                                        title="Delete" data-bs-toggle="tooltip"><i class="bi bi-trash3"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                            No products found.
                        </td>
                    </tr>
                @endforelse

                {{-- Shown by JS when filters match nothing --}}
                <tr id="tzNoMatch" class="d-none">
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-search fs-1 d-block mb-2"></i>
                        No products match your filters.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    @if ($isPaginated && $products->hasPages())
        <div class="card-footer bg-white">{{ $products->links() }}</div>
    @endif
</div>

<script>
    (function () {
        const search = document.getElementById('tzSearch');
        const category = document.getElementById('tzCategory');
        const status = document.getElementById('tzStatus');
        const noMatch = document.getElementById('tzNoMatch');
        const rows = document.querySelectorAll('#tzBody tr[data-search]');

        function applyFilters() {
            const q = search.value.trim().toLowerCase();
            let visible = 0;

            rows.forEach(function (row) {
                const show =
                    (!q || row.dataset.search.includes(q)) &&
                    (!category.value || row.dataset.category === category.value) &&
                    (!status.value || row.dataset.status === status.value);
                row.classList.toggle('d-none', !show);
                if (show) visible++;
            });

            noMatch.classList.toggle('d-none', visible > 0 || rows.length === 0);
        }

        [search, category, status].forEach(function (el) {
            el.addEventListener('input', applyFilters);
        });

        // Enable Bootstrap tooltips if the bundle is loaded
        if (window.bootstrap) {
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
                new bootstrap.Tooltip(el);
            });
        }
    })();
</script>
@endsection
