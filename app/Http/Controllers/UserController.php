<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Area;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Listado de usuarios
     */
    public function index()
    {
        $users = User::with('area')->latest()->get();

        return view('users.index', compact('users'));
    }

    /**
     * Formulario crear usuario
     */
    public function create()
    {
        $areas = Area::all();

        return view('users.create', compact('areas'));
    }

    /**
     * Guardar usuario
     */
    public function store(Request $request)
    {
        $request->validate([
    'name' => 'required',
    'email' => 'required|email|unique:users',
    'password' => 'required|min:6',
    'role' => 'required',
    'area_id' => $request->role === 'compras'
        ? 'nullable'
        : 'required|exists:areas,id',
]);
User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'role' => $request->role,
    'area_id' => $request->role === 'compras'
        ? null
        : $request->area_id,
]);

        return redirect()->route('users.index')
            ->with('success','Usuario creado correctamente');
    }

    /**
     * Editar usuario
     */
    public function edit(User $user)
    {
        $areas = Area::all();

        return view('users.edit', compact('user','areas'));
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required',
            'area_id' => 'required|exists:areas,id',
        ]);
        if ($request->role === 'compras') {
    $request->merge(['area_id' => null]);
}

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'area_id' => $request->area_id,
        ]);

        if ($request->hasFile('firma')) {
    $path = $request->file('firma')->store('firmas', 'public');
    $user->firma = $path;
}

$user->save();

        return redirect()->route('users.index')
            ->with('success','Usuario actualizado correctamente');
    }

    /**
     * Eliminar usuario
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success','Usuario eliminado correctamente');
    }
}