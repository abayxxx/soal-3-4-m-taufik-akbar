<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //

    public function index()
    {

        $categories = Category::all();

        $products = Product::with('category')->get();

        return view('dashboard', compact('categories', 'products'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|min:3|max:255',
            'image' => 'required|mimes:jpg,png,jpeg|max:2048',
            'code' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        try {

            DB::beginTransaction();

            Product::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'image' => $request->file('image')->store('products'),
                'code' => $request->code,
                'price' => $request->price,
                'stock' => $request->stock,
            ]);

            DB::commit();

            return response()->json(['success' => 'Product created successfully']);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['error' => 'Product failed to create']);
        }
    }


    public function show($id)
    {
        $product = Product::find($id);

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|min:3|max:255',
            'image' => 'mimes:jpg,png,jpeg|max:2048',
            'code' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        try {

            DB::beginTransaction();

            $product = Product::find($id);


            $product->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'code' => $request->code,
                'price' => $request->price,
                'stock' => $request->stock,
            ]);

            if ($request->hasFile('image')) {
                $product->update([
                    'image' => $request->file('image')->store('products'),
                ]);
            }

            DB::commit();

            return  response()->json(['success' => 'Product updated successfully']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            DB::rollBack();
            return response()->json(['error' => 'Product failed to update']);
        }
    }

    public function destroy($id)
    {
        try {

            DB::beginTransaction();

            $product = Product::find($id);

            // Delete image
            Storage::delete($product->image);

            $product->delete();

            DB::commit();

            return response()->json(['success' => 'Product deleted successfully']);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['error' => 'Product failed to delete']);
        }
    }
}
