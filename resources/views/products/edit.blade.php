@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<h2 class="mb-3">Edit Product</h2>

<div class="card card-body">
    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        @include('products._form')
        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection