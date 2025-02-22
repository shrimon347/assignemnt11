<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::select(['id', 'name', 'category', 'price', 'stock']);

            return DataTables::of($products)
                ->addColumn('actions', function ($product) {  
                    $encryptedId = Crypt::encrypt($product->id);
                    return '
                        <a href="'.route('products.show', $encryptedId).'" class="btn btn-sm btn-primary">view</a>
                        <a href="'.route('products.edit', $encryptedId).'" class="btn btn-sm btn-warning">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger delete-product" data-id="'.$encryptedId.'">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])  
                ->make(true);
        }

        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate inputs
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:Active,Inactive',
            'seo_tags' => 'required|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Save product details
        $product = new Product();
        $product->name = $validatedData['name'];
        $product->category = $validatedData['category'];
        $product->price = $validatedData['price'];
        $product->short_description = $validatedData['short_description'];
        $product->long_description = $validatedData['long_description'];
        $product->image = $imagePath;
        $product->stock = $validatedData['stock'];
        $product->status = $validatedData['status'];
        $product->seo_tags = $validatedData['seo_tags'];
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($encryptedId)
    {   
        $id = Crypt::decrypt($encryptedId);
        $product = Product::findOrFail($id);

        return view('products.view', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $encryptedId)
    {
        // Validate inputs
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:Active,Inactive',
            'seo_tags' => 'required|string',
        ]);
        $id = Crypt::decrypt($encryptedId);
        $product = Product::findOrFail($id);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $product->image = $imagePath;
        }

        // Save product details
        $product->name = $validatedData['name'];
        $product->category = $validatedData['category'];
        $product->price = $validatedData['price'];
        $product->short_description = $validatedData['short_description'];
        $product->long_description = $validatedData['long_description'];
        $product->stock = $validatedData['stock'];
        $product->status = $validatedData['status'];
        $product->seo_tags = $validatedData['seo_tags'];
        $product->save();


        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }
    
        // Delete image if exists
        if ($product->image) {
            \Storage::delete('public/' . $product->image);
        }
    
        $product->delete();
    
        return response()->json(['success' => true, 'message' => 'Product deleted successfully!']);
    }
}
