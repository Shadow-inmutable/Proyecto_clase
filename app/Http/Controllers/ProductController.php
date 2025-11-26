<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
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
        $product = new Product();
        $product->code = $request-> code;
        $product->name = $request-> name;
        $product->ammount = $request-> ammount;
        $product->unit = $request-> unit;
        $product->price = $request-> price;
        $product->timestamps = Carbon::now();
        $product->save();

        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->code = $request-> code;
        $product->name = $request-> name;
        $product->ammount = $request-> ammount;
        $product->unit = $request-> unit;
        $product->price = $request-> price;
        $product->timestamps = Carbon::now();
        $product->save();

        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
    }
    

    public function generatePDF($id)
    {
        $product = Product::findOrFail($id);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('products.pdf', compact('product'));
        return $pdf->stream('product' . $product->id . '.pdf');
    }
}
