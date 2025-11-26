<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class MovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movements = Movement::all();
        return view('movements.index', ['movements' => $movements]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('movements.create', [
            'products' => $products,
            'movements_types' => [
                Movement::MOVEMENT_TYPE_IN,
                Movement::MOVEMENT_TYPE_OUT,
                Movement::MOVEMENT_TYPE_DEVOLUTION
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $movement = new Movement();
            $movement->type = $request->input('type');
            $movement->ammount = $request->input('ammount');
            $movement->sale_point = $request->input('sale_point');
            $movement->product_id = $request->input('product');
            $movement->save();

            $product = Product::find($movement->product_id);
            if ($product) {
                switch ($movement->type) {
                    case Movement::MOVEMENT_TYPE_IN:
                    case Movement::MOVEMENT_TYPE_DEVOLUTION:-
                        $product->increment('ammount', $movement->ammount);
                        break;
                    case Movement::MOVEMENT_TYPE_OUT:
                       if  ($product->ammount < $movement->ammount) {
                           throw new \Exception('La cantidad solicitada supera la cantidad disponible en inventario, No hay suficiente inventario para realizar esta solicitud.');
                        }
            $product->decrement ('ammount', $movement -> ammount);
                break;
                }
            }
            $product->save();
        } catch (\Throwable $ex) {
            log :: error('Error al tratar de realizar el movimiento: ' . $ex->getMessage());
            session :: flash ('error', $ex->getMessage());
            DB::rollBack();
            // manejar el error o relanzar: throw $th;
        }
        DB::commit();
        return redirect()->route('movements.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Movement $movement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movement $movement)
    {
        $movements_types = ['entrada', 'salida', 'devolucion']; // Ajusta según tus tipos
        $products = Product::all(); // O tu lógica para obtener productos
    
        return view('movements.edit', compact('movement', 'movements_types', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movement $movement)
    {
        // Validación de los datos entrantes
        $request->validate([
        'type' => 'required',
        'ammount' => 'required|numeric|min:1',
        'sale_point' => 'required',
        'product_id' => 'required|exists:products,id'
    ]);
        $movement->type = $request-> type;
        $movement->ammount = $request-> ammount;
        $movement->sale_point = $request-> sale_point;
        $movement->product_id = $request-> product_id;
        $movement->save();
        return redirect()->route('movements.index')->with('success', 'Movimiento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movement $movement)
    {
        $movement->delete();
        return redirect()->route('movements.index')->with('success', 'Movimiento eliminado exitosamente.');
    }

    public function generatePDF($id)
    {
        $movement = Movement::findOrFail($id);
        $movements = Movement::all(); // O Movement::where(...)->get()
        
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('movements.pdf', compact('movement', 'movements'));
        return $pdf->stream('movement' . $movement->id . '.pdf');
    }
}
