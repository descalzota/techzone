@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    .tz-card {
        border: 0;
        border-radius: 1rem;
        box-shadow: 0 2px 10px rgba(15, 23, 42, .06);
        overflow: hidden;
    }
    .tz-card-header {
        background: linear-gradient(135deg, #1f2937 0%, #2563eb 100%);
        color: #fff;
        padding: 1.25rem 1.5rem;
    }
    .tz-card-header .tz-header-icon {
        width: 46px;
        height: 46px;
        border-radius: .85rem;
        background: rgba(255, 255, 255, .15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .tz-form .form-label { font-weight: 600; font-size: .9rem; color: #374151; }
    .tz-form .form-control,
    .tz-form .form-select {
        border-radius: .6rem;
        padding: .6rem .85rem;
        border-color: #d1d5db;
    }
    .tz-form .form-control:focus,
    .tz-form .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .15);
    }
    .tz-form-actions {
        background: #f8f9fa;
        border-top: 1px solid #e5e7eb;
        padding: 1rem 1.5rem;
    }
</style>

{{-- Header --}}
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
        <i class="bi bi-arrow-left"></i> Back
    </a>
    <div>
        <h2 class="fw-bold mb-0">Add Product</h2>
        <div class="text-muted small">Register a new item in the TechZone inventory.</div>
    </div>
</div>

{{-- Validation summary --}}
@if ($errors->any())
    <div class="alert alert-danger d-flex align-items-start" role="alert">
        <i class="bi bi-exclamation-octagon me-2 mt-1"></i>
        <div>
            <strong>Please fix the following:</strong>
            <ul class="mb-0 mt-1 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="card tz-card">
    <div class="tz-card-header d-flex align-items-center gap-3">
        <div class="tz-header-icon"><i class="bi bi-box-seam"></i></div>
        <div>
            <h5 class="mb-0 fw-semibold">Product Details</h5>
            <div class="small opacity-75">Fill in the information below, then save.</div>
        </div>
    </div>

    <form action="{{ route('products.store') }}" method="POST" class="tz-form">
        @csrf

        <div class="card-body p-4">
            @include('products._form')
        </div>

        <div class="tz-form-actions d-flex justify-content-end gap-2">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                <i class="bi bi-x-lg"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
                <i class="bi bi-check-lg"></i> Save Product
            </button>
        </div>
    </form>
</div>
@endsection