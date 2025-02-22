@extends('layouts.app')
@section('title', 'Product Details')
@section('breadcrumb-title', 'Products / View')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="row g-0">
                    <!-- Left Side - Product Image -->
                    <div class="col-md-6 text-center p-4">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                alt="{{ $product->name }}" 
                                class="img-fluid rounded shadow-sm" 
                                style="max-height: 400px; object-fit: contain;">
                        @else
                            <img src="{{ asset('images/default-placeholder.png') }}" 
                                alt="No Image Available" 
                                class="img-fluid rounded shadow-sm">
                        @endif
                    </div>

                    <!-- Right Side - Product Details -->
                    <div class="col-md-6 p-4">
                        <h2 class="fw-bold">{{ $product->name }}</h2>
                        <p class="text-muted">{{ $product->category }}</p>

                        <div class="mb-3">
                            <h4 class="text-success fw-bold">${{ number_format($product->price, 2) }}</h4>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Short Description:</label>
                            <p>{{ $product->short_description }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Long Description:</label>
                            <p class="small text-secondary">{{ $product->long_description }}</p>
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                            </span>
                            <span class="text-muted">Status: <strong>{{ ucfirst($product->status) }}</strong></span>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">SEO Tags:</label>
                            <p class="small text-muted">{{ $product->seo_tags }}</p>
                        </div>

                        <div class="d-flex gap-3">
                        <a href="{{ route('products.edit', Crypt::encrypt($product->id)) }}" 
                            class="btn" 
                            style="background-color: #673AB7; color: white; border-radius: 8px; padding: 10px 20px; font-size: 16px; font-weight: bold; box-shadow: 2px 2px 5px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                            <i class="fas fa-edit me-2"></i>Edit
                            </a>

                            <a href="{{ route('products.index') }}" 
                            class="btn" 
                            style="background-color: #6c757d; color: white; border-radius: 8px; padding: 10px 20px; font-size: 16px; font-weight: bold; box-shadow: 2px 2px 5px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
