<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequestLog;
use App\Models\User;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(
            in_array(auth()->user()->role, ['compras','administrador']),
            403
        );

        $query = PurchaseRequestLog::with(['user','purchaseRequest'])
                    ->latest();

        /*
        |--------------------------------------------------------------------------
        | FILTRO POR NÚMERO DE REQUISICIÓN
        |--------------------------------------------------------------------------
        */
        if ($request->filled('numero')) {
            $query->whereHas('purchaseRequest', function ($q) use ($request) {
                $q->where('num_requisicion', 'like', '%'.$request->numero.'%');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTRO POR USUARIO
        |--------------------------------------------------------------------------
        */
        if ($request->filled('usuario')) {
            $query->where('changed_by', $request->usuario);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTRO POR FECHA
        |--------------------------------------------------------------------------
        */
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        $logs = $query->paginate(30)->withQueryString();

        // Usuarios para el select
        $usuarios = User::whereIn('role', ['compras','administrador','coordinador'])
                        ->orderBy('name')
                        ->get();

        return view('audit.index', compact('logs','usuarios'));
    }
}