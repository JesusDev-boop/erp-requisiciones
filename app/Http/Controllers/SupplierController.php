<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
 public function index()
{
    $user = auth()->user();

    // Compras y Admin ven todos
    if (in_array($user->role, ['compras', 'administrador'])) {

        $suppliers = \App\Models\Supplier::where('activo', 1)->get();

    } else {
        // Coordinador solo los de su área
        $suppliers = \App\Models\Supplier::where('activo', 1)
            ->whereHas('areas', function ($query) use ($user) {
                $query->where('areas.id', $user->area_id);
            })
            ->get();
    }

    return view('suppliers.index', compact('suppliers'));
}

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
{
    $request->validate([ // si tu tabla lo tiene
        'nombre' => 'required',
        'rfc' => 'required|unique:suppliers',
        'direccion' => 'required',
        'contacto' => 'required',
    ]);

    // 1️⃣ Crear proveedor y guardarlo en variable
    $supplier = Supplier::create([
        'razon_social' => $request->razon_social ?? null,
        'nombre' => $request->nombre,
        'rfc' => $request->rfc,
        'direccion' => $request->direccion,
        'contacto' => $request->contacto,
        'activo' => 1
    ]);

    // 2️⃣ Asignarlo AUTOMÁTICAMENTE al área del coordinador
    $supplier->areas()->attach(auth()->user()->area_id);

    return redirect()->route('suppliers.index')
        ->with('success','Proveedor creado correctamente');
}
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
{
    $request->validate([
        'nombre' => 'required',
        'rfc' => 'required|unique:suppliers,rfc,' . $supplier->id,
        'direccion' => 'required',
        'contacto' => 'required',
    ]);

    $supplier->update([
        'nombre' => $request->nombre,
        'rfc' => $request->rfc,
        'direccion' => $request->direccion,
        'contacto' => $request->contacto,
        'activo' => $request->activo
    ]);

    return redirect()->route('suppliers.index')
        ->with('success','Proveedor actualizado correctamente');
}
    public function destroy(Supplier $supplier)
    {
        $supplier->update([
            'activo' => 0
        ]);

        return back()->with('success','Proveedor desactivado');
    }
}