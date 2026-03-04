<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequestLog;
use App\Models\PurchaseRequest;
use App\Models\PurchaseOrder;
use App\Models\User;


class DashboardController extends Controller
{
    public function index()
{
    $user = auth()->user();

    $stats = [

        // REQUISICIONES DEL USUARIO
        'devueltas' => PurchaseRequest::where('user_id',$user->id)
                        ->where('estatus','devuelta')
                        ->count(),

        'en_revision' => PurchaseRequest::where('estatus','en_revision')->count(),

        // REQUISICIONES SISTEMA
        'numeradas' => PurchaseRequest::where('estatus','numerada')->count(),
        'aprobadas' => PurchaseRequest::where('estatus','aprobada')->count(),
        'rechazadas' => PurchaseRequest::where('estatus','rechazada')->count(),
        'total_requisiciones' => PurchaseRequest::count(),

        // ORDENES DE COMPRA
        'total_oc' => PurchaseOrder::count(),
        'oc_emitidas' => PurchaseOrder::where('estatus','emitida')->count(),
        'oc_borradores' => PurchaseOrder::where('estatus','borrador')->count(),
        'monto_oc' => PurchaseOrder::sum('total'),

        // USUARIOS
        'usuarios' => User::count(),

        // LOGS
        'logs_total' => PurchaseRequestLog::count(),

    ];

    $logs = PurchaseRequestLog::with([
            'user',
            'purchaseRequest'
        ])
        ->latest()
        ->take(100)
        ->get();

    return view('dashboard', compact('logs','stats'));
}
}