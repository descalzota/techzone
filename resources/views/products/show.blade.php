@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<h2 class="mb-3">Product Details</h2>

<div class="card card-body">
    <table class="table table-borderless mb-0">
        <tr><th style="width: 200px;">Product Code</th><td>{{ $product->product_code }}</td></tr>
        <tr><th>Product Name</th><td>{{ $product->name }}</td></tr>
        <tr><th>Category</th><td>{{ $product->category }}</td></tr>
        <tr><th>Price</th><td>₱{{ number_format($product->price, 2) }}</td></tr>
        <tr><th>Quantity</th><td>{{ $product->quantity }}</td></tr>
        <tr><th>Supplier</th><td>{{ $product->supplier }}</td></tr>
        <tr><th>Status</th><td>{{ $product->status }}</td></tr>
        <tr><th>Description</th><td>{{ $product->description ?? 'N/A' }}</td></tr>
        <tr><th>Created</th><td>{{ $product->created_at }}</td></tr>
        <tr><th>Last Updated</th><td>{{ $product->updated_at }}</td></tr>
    </table>
</div>

<div class="mt-3">
    <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
