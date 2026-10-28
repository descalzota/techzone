<div class="mb-3">
    <label for="name" class="form-label">Product Name</label>
    <input type="text" id="name" name="name"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $product->name ?? '') }}">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="category" class="form-label">Category</label>
    <input type="text" id="category" name="category"
           class="form-control @error('category') is-invalid @enderror"
           value="{{ old('category', $product->category ?? '') }}">
    @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" step="0.01" id="price" name="price"
               class="form-control @error('price') is-invalid @enderror"
               value="{{ old('price', $product->price ?? '') }}">
        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="number" id="quantity" name="quantity"
               class="form-control @error('quantity') is-invalid @enderror"
               value="{{ old('quantity', $product->quantity ?? '') }}">
        @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label for="supplier" class="form-label">Supplier</label>
    <input type="text" id="supplier" name="supplier"
           class="form-control @error('supplier') is-invalid @enderror"
           value="{{ old('supplier', $product->supplier ?? '') }}">
    @error('supplier') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
        <option value="">-- Select Status --</option>
        @foreach ($statuses as $status)
            <option value="{{ $status }}"
                {{ old('status', $product->status ?? '') === $status ? 'selected' : '' }}>
                {{ $status }}
            </option>
        @endforeach
    </select>
    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description (optional)</label>
    <textarea id="description" name="description" rows="3"
              class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
