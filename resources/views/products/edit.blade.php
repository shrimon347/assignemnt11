@extends('layouts.app')
@section('title', 'Edit Product')
@section('breadcrumb-title', 'Products / Edit')

@push('styles')
<style>
    /* Step Progress Bar */
    #progressbar {
        display: flex;
        justify-content: space-between;
        padding: 0;
        margin-bottom: 30px;
        counter-reset: step;
    }
    #progressbar li {
        list-style-type: none;
        width: 33%;
        text-align: center;
        font-weight: bold;
        color: #6c757d;
        position: relative;
    }
    #progressbar li:before {
        content: counter(step);
        counter-increment: step;
        width: 40px;
        height: 40px;
        line-height: 40px;
        display: block;
        background: #d1d3e2;
        color: #fff;
        border-radius: 50%;
        margin: 0 auto 10px auto;
        font-size: 18px;
        font-weight: bold;
    }
    #progressbar li.active {
        color: #198754;
    }
    #progressbar li.active:before {
        background: #198754;
    }

    /* Stepper Line */
    #progressbar li::after {
        content: '';
        width: 100%;
        height: 4px;
        background: #d1d3e2;
        position: absolute;
        top: 20px;
        left: -50%;
        z-index: -1;
    }
    #progressbar li:first-child::after {
        content: none;
    }
    #progressbar li.active + li::after {
        background: #198754;
    }

    /* Fieldset Styling */
    fieldset {
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }
    fieldset.active {
        display: block;
    }

    /* Button Styling */
    .action-button {
        background: #198754;
        border: none;
        padding: 10px 20px;
        color: white;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .action-button:hover {
        background: #145c43;
    }
    .action-button-previous {
        background: #198754; /* Same as Next button */
        border: none;
        padding: 10px 20px;
        color: white;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .action-button-previous:hover {
        background: #145c43; 
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg p-4">
                <h3 class="fw-bold text-center mb-3">Edit Product</h3>
                <p class="text-center text-muted">Update product details step by step.</p>

                <form id="msform" action="{{ route('products.update', Crypt::encrypt($product->id)) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Progress Bar -->
                    <ul id="progressbar">
                        <li class="active">Product Details</li>
                        <li>Product Description</li>
                        <li>Additional Details</li>
                    </ul>

                    <div class="progress mb-4">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 33%;" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <!-- Step 1: Product Details -->
                    <fieldset class="active">
                        <div class="mb-3">
                            <label class="fw-bold">Product Name:</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required />
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Category:</label>
                            <select name="category" class="form-control" required>
                                <option value="Electronics" {{ old('category', $product->category) == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                                <option value="Clothing" {{ old('category', $product->category) == 'Clothing' ? 'selected' : '' }}>Clothing</option>
                                <option value="Home Appliances" {{ old('category', $product->category) == 'Home Appliances' ? 'selected' : '' }}>Home Appliances</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Price:</label>
                            <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" min="0" required />
                        </div>

                        <button type="button" class="next action-button">Next</button>
                    </fieldset>

                    <!-- Step 2: Product Description -->
                    <fieldset>
                        <div class="mb-3">
                            <label class="fw-bold">Short Description:</label>
                            <textarea name="short_description" class="form-control" required>{{ old('short_description', $product->short_description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Long Description:</label>
                            <textarea name="long_description" class="form-control" required>{{ old('long_description', $product->long_description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Upload Image:</label>
                            <input type="file" name="image" class="form-control" accept="image/*" />
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded mt-2" style="max-height: 100px;">
                            @endif
                        </div>

                        <button type="button" class="previous action-button-previous">Previous</button>
                        <button type="button" class="next action-button">Next</button>
                    </fieldset>

                    <!-- Step 3: Additional Details -->
                    <fieldset>
                        <div class="mb-3">
                            <label class="fw-bold">Stock:</label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" min="0" required />
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Status:</label>
                            <select name="status" class="form-control" required>
                                <option value="Active" {{ old('status', $product->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status', $product->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <label class="fieldlabels py-4">SEO Tags: *</label>
                            <input type="text"class="form-control" name="seo_tags" value="{{ old('seo_tags', $product->seo_tags) }}"/>
                        </div>

                        <button type="button" class="previous action-button-previous">Previous</button>
                        <button type="submit" class="action-button">Update</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
    $(document).ready(function () {
        var current_fs, next_fs, previous_fs; // Fieldsets
        var opacity;
        var current = 1;
        var steps = $("fieldset").length;
        setProgressBar(current);

        $(".next").click(function () {
            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            // Validate current fieldset before proceeding
            if (!current_fs.find("input, select, textarea").valid()) {
                return false; // Stop if validation fails
            }

            // Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            // Show the next fieldset
            next_fs.show();

            // Hide the current fieldset with style
            current_fs.animate(
                { opacity: 0 },
                {
                    step: function (now) {
                        opacity = 1 - now;
                        current_fs.css({
                            display: "none",
                            position: "relative",
                        });
                        next_fs.css({ opacity: opacity });
                    },
                    duration: 500,
                }
            );
            setProgressBar(++current);
        });

        $(".previous").click(function () {
            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            // Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            // Show the previous fieldset
            previous_fs.show();

            // Hide the current fieldset with style
            current_fs.animate(
                { opacity: 0 },
                {
                    step: function (now) {
                        opacity = 1 - now;
                        current_fs.css({
                            display: "none",
                            position: "relative",
                        });
                        previous_fs.css({ opacity: opacity });
                    },
                    duration: 500,
                }
            );
            setProgressBar(--current);
        });

        function setProgressBar(curStep) {
            var percent = parseFloat((100 / steps) * curStep);
            percent = percent.toFixed();
            $(".progress-bar").css("width", percent + "%");
        }

        $("#msform").validate({
            rules: {
                name: "required",
                category: "required",
                price: {
                    required: true,
                    number: true,
                    min: 0,
                },
                short_description: "required",
                long_description: "required",
                stock: {
                    required: true,
                    number: true,
                    min: 0,
                },
                status: "required",
                seo_tags: "required",
            },
            messages: {
                name: "Please enter the product name",
                category: "Please select a category",
                price: {
                    required: "Please enter the price",
                    number: "Please enter a valid number",
                    min: "Price cannot be negative",
                },
                short_description: "Please provide a short description",
                long_description: "Please provide a long description",
                stock: {
                    required: "Please enter the stock quantity",
                    number: "Please enter a valid number",
                    min: "Stock cannot be negative",
                },
                status: "Please select a status",
                seo_tags: "Please enter SEO tags",
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element); 
            },
        });
    });
</script>
@endpush
