<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    private array $statuses = ['Available', 'Low Stock', 'Out of Stock'];

    private function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'supplier' => 'required|string|max:255',
            'status' => ['required', Rule::in($this->statuses)],
            'description' => 'nullable|string|max:1000',
        ];
    }

    private function messages(): array
    {
        return [
            'name.required' => 'Please enter the product name.',
            'category.required' => 'Please enter the category.',
            'price.required' => 'Please enter the price.',
            'price.numeric' => 'Price must be a number.',
            'price.min' => 'Price cannot be negative.',
            'quantity.required' => 'Please enter the quantity.',
            'quantity.integer' => 'Quantity must be a whole number.',
            'quantity.min' => 'Quantity cannot be negative.',
            'supplier.required' => 'Please enter the supplier.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Please select a valid status.',
        ];
    }

    public function index()
    {
        $products = Product::latest()->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create', ['statuses' => $this->statuses]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());
        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product added successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product,
            'statuses' => $this->statuses,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate($this->rules(), $this->messages());
        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
