<x-app-layout>
   
<x-slot name="header">
    <div class="flex items-center gap-4">

        {{-- Botón Regresar --}}
        <a href="{{ route('dashboard') }}"
           class="p-3 bg-white/5 border border-white/10 rounded-2xl 
                  text-white hover:bg-white/10 hover:border-white/20 
                  transition-all shadow-lg backdrop-blur-md group">
            
            <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2.5"
                      d="M15 19l-7-7 7-7" />
            </svg>
        </a>

        <div>
            <h2 class="text-3xl font-black text-white tracking-tight">
                Vista Previa
            </h2>

            <p class="text-sm text-emerald-400 mt-1 font-semibold">
            Verifica La Informacion
            </p>
        </div>

    </div>
</x-slot>

    <div class="py-10 bg-slate-100 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-black p-6 text-[10px] leading-tight text-black">

                {{-- ================= ENCABEZADO TÉCNICO ================= --}}
                <div class="grid grid-cols-12 border border-black">
                    <div class="col-span-3 border-r border-black p-2 flex items-center justify-center">
    <img src="{{ asset('images/logo.png') }}"
         alt="Chemiservis"
         class="h-12 object-contain">
</div>
                    <div class="col-span-5 border-r border-black flex items-center justify-center font-bold text-sm">
                        FORMATO DE REQUISICION
                    </div>
                    <div class="col-span-4 grid grid-rows-2">
                        <div class="grid grid-cols-2 border-b border-black">
                            <div class="border-r border-black p-1 text-center font-bold">PREPARADO POR:</div>
                            <div class="p-1 text-center font-bold">APROBADO POR:</div>
                        </div>
                        <div class="grid grid-cols-2 uppercase">
                            <div class="border-r border-black p-1 text-center font-semibold">COMPRAS</div>
                            <div class="p-1 text-center font-semibold text-[9px]">GTE. OPERACIONES</div>
                        </div>
                    </div>
                </div>

                {{-- FILA DE CONTROL DE DOCUMENTO --}}
                <div class="grid grid-cols-5 border-x border-b border-black text-center font-bold">
                    <div class="border-r border-black p-1 bg-white">NÚMERO DE CONTROL</div>
                    <div class="border-r border-black p-1 bg-white">CLAS. DOC</div>
                    <div class="border-r border-black p-1 bg-white">TIPO. DOC</div>
                    <div class="border-r border-black p-1 bg-white">REVISIÓN N°</div>
                    <div class="p-1 bg-white">FECHA DE EMISIÓN</div>
                </div>
                <div class="grid grid-cols-5 border-x border-b border-black text-center mb-4">
                    <div class="border-r border-black p-1 uppercase">CHEMISERVIS-MX-N5-313</div>
                    <div class="border-r border-black p-1 uppercase">CONTROLADO</div>
                    <div class="border-r border-black p-1 uppercase">FORMATO</div>
                    <div class="border-r border-black p-1">1</div>
                    <div class="p-1 uppercase">30/08/2023</div>
                </div>

                {{-- ================= DATOS DE REQUISICIÓN ================= --}}
                <div class="grid grid-cols-12 border border-black mb-4">
                    <div class="col-span-8 border-r border-black">
                        {{-- Espacio vacío superior en imagen --}}
                        <div class="h-6 border-b border-black"></div>
                        <div class="grid grid-cols-6 border-b border-black">
                            <div class="p-1 font-bold bg-blue-200 border-r border-black uppercase">Pozo:</div>
                            <div class="p-1 col-span-5 uppercase">{{ $purchaseRequest->pozo }}</div>
                        </div>
                    </div>
                    <div class="col-span-4">
                        <div class="grid grid-cols-2 border-b border-black">
                            <div class="p-1 font-bold bg-blue-300 border-r border-black uppercase">Num. Requisicion:</div>
                            <div class="p-1 font-bold uppercase">{{ $purchaseRequest->num_requisicion }}</div>
                        </div>
                        <div class="h-6 border-b border-black"></div>
                        <div class="grid grid-cols-2">
    <div class="p-1 font-bold bg-blue-300 border-r border-black uppercase text-[9px]">
        Solicitud de Trabajo:
    </div>
    <div class="p-1 uppercase font-semibold">
        {{ $purchaseRequest->solicitud_trabajo }}
    </div>
</div>
                    </div>
                </div>

                {{-- SOLICITANTE Y FECHAS --}}
                <div class="grid grid-cols-12 border-x border-t border-black bg-blue-200 text-center font-bold uppercase">
                    <div class="col-span-8 border-r border-black p-1">Solicitante:</div>
                    <div class="col-span-2 border-r border-black p-1 text-[8px]">Fecha de Requisición</div>
                    <div class="col-span-2 p-1 text-[8px]">Fecha Requerida</div>
                </div>
                <div class="grid grid-cols-12 border border-black text-center uppercase mb-1">
                    <div class="col-span-8 border-r border-black p-1 font-semibold">
    {{ $purchaseRequest->solicitante }}
</div>
                    <div class="col-span-2 border-r border-black p-1">{{ \Carbon\Carbon::parse($purchaseRequest->fecha_requisicion)->format('d-M-y') }}</div>
                    <div class="col-span-2 p-1">{{ \Carbon\Carbon::parse($purchaseRequest->fecha_requerida)->format('d-M-y') }}</div>
                </div>

                <div class="grid grid-cols-12 border border-black bg-blue-200 text-center font-bold uppercase mb-1">
                    <div class="col-span-8 border-r border-black p-1">Área Solicitante:</div>
                    <div class="col-span-4 p-1">Proyecto</div>
                </div>
                <div class="grid grid-cols-12 border border-black text-center uppercase mb-4">
                    <div class="col-span-8 border-r border-black p-1 font-semibold">{{ $purchaseRequest->area->nombre }}</div>
                    <div class="col-span-4 p-1 font-semibold">{{ $purchaseRequest->project->nombre }}</div>
                </div>

                {{-- PROVEEDOR --}}
                <div class="grid grid-cols-2 border-x border-t border-black bg-blue-200 text-center font-bold uppercase">
                    <div class="border-r border-black p-1">Proveedor Sugerido:</div>
                    <div class="p-1">Contacto</div>
                </div>
                <div class="grid grid-cols-2 border border-black text-center uppercase mb-1">
                    <div class="border-r border-black p-1 font-semibold">{{ $purchaseRequest->supplier->nombre }}</div>
                    <div class="p-1 font-semibold">{{ $purchaseRequest->supplier->contacto }}</div>
                </div>

                <div class="grid grid-cols-12 border border-black bg-blue-200 text-center font-bold uppercase mb-1">
                    <div class="col-span-8 border-r border-black p-1 text-[9px]">Dirección</div>
                    <div class="col-span-4 p-1">R.F.C.</div>
                </div>
                <div class="grid grid-cols-12 border border-black text-center uppercase mb-4">
                    <div class="col-span-8 border-r border-black p-1 text-[9px]">{{ $purchaseRequest->supplier->direccion }}</div>
                    <div class="col-span-4 p-1 font-semibold">{{ $purchaseRequest->supplier->rfc }}</div>
                </div>

                {{-- CONDICIONES --}}
                <div class="grid grid-cols-10 border border-black mb-4 uppercase">
                    <div class="col-span-2 p-1 font-bold bg-blue-200 border-r border-black">Condiciones de Pago</div>
                    <div class="col-span-4 p-1 border-r border-black text-center">{{ $purchaseRequest->condicion_pago }}</div>
                    <div class="col-span-2 p-1 font-bold bg-blue-300 border-r border-black">Moneda</div>
                    <div class="col-span-2 p-1 text-center font-semibold">{{ $purchaseRequest->moneda }}</div>
                </div>

                {{-- ================= TABLA DE PARTIDAS ================= --}}
                <table class="w-full border border-black mb-0 uppercase">
                    <thead>
                        <tr class="bg-blue-200 text-center font-bold border-b border-black">
                            <th class="p-1 border-r border-black w-10">ITEM</th>
                            <th class="p-1 border-r border-black w-20">CANTIDAD</th>
                            <th class="p-1 border-r border-black w-24 text-[8px]">UNIDAD DE MEDIDA</th>
                            <th class="p-1 border-r border-black">DESCRIPCIÓN</th>
                            <th class="p-1 border-r border-black w-28">PRECIO UNITARIO</th>
                            <th class="p-1 w-28">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchaseRequest->items as $item)
                        <tr class="border-b border-black text-[9px]">
                            <td class="p-2 border-r border-black text-center">{{ $loop->iteration }}</td>
                            <td class="p-2 border-r border-black text-center font-semibold">{{ number_format($item->cantidad, 2) }}</td>
                            <td class="p-2 border-r border-black text-center">{{ $item->unit->nombre ?? 'PIEZA' }}</td>
                            <td class="p-2 border-r border-black leading-tight">{{ $item->descripcion }}</td>
                            <td class="p-2 border-r border-black text-right font-semibold">$ {{ number_format($item->precio_unitario, 2) }}</td>
                            <td class="p-2 text-right font-semibold">$ {{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="border-x border-b border-black p-1 text-center font-bold bg-white italic">
                  COTIZACION: {{ $purchaseRequest->cotizacion ?? '' }}
                </div>

                {{-- ================= TOTALES ================= --}}
                <div class="flex justify-end mt-4">
                    <div class="w-1/3 border border-black font-bold">
                        <div class="grid grid-cols-2 border-b border-black">
                            <div class="p-1 bg-blue-200 border-r border-black">SUBTOTAL:</div>
                            <div class="p-1 text-right font-normal">$ {{ number_format($purchaseRequest->subtotal, 2) }}</div>
                        </div>
                        <div class="grid grid-cols-2 border-b border-black">
                            <div class="p-1 bg-blue-200 border-r border-black">DESCUENTO:</div>
                            <div class="p-1 text-right font-normal">$ {{ number_format($purchaseRequest->descuento, 2) }}</div>
                        </div>
                        <div class="grid grid-cols-2 border-b border-black">
                            <div class="p-1 bg-blue-200 border-r border-black">I.V.A.:</div>
                            <div class="p-1 text-right font-normal">$ {{ number_format($purchaseRequest->iva, 2) }}</div>
                        </div>
                        <div class="grid grid-cols-2 border-b border-black">
                            <div class="p-1 bg-blue-200 border-r border-black text-[9px]">RETENCIÓN I.V.A.:</div>
                            <div class="p-1 text-right font-normal">$ {{ number_format($purchaseRequest->retencion_iva, 2) }}</div>
                        </div>
                        <div class="grid grid-cols-2 border-b border-black">
                            <div class="p-1 bg-blue-200 border-r border-black text-[9px]">RETENCION I.S.R:</div>
                            <div class="p-1 text-right font-normal font-semibold">$ {{ number_format($purchaseRequest->retencion_isr, 2) }}</div>
                        </div>
                        <div class="grid grid-cols-2 bg-white">
                            <div class="p-1 bg-blue-300 border-r border-black">TOTAL</div>
                            <div class="p-1 text-right font-bold">$ {{ number_format($purchaseRequest->total, 2) }}</div>
                        </div>
                    </div>
                </div>

                {{-- IMPORTE EN LETRA --}}
                <div class="mt-4 border border-black uppercase">
                    <div class="bg-blue-200 p-1 font-bold text-center border-b border-black text-[9px]">Importe en letra</div>
                    <div class="p-2 text-center font-semibold text-[9px]">
                        {{ $purchaseRequest->total_letra }}
                    </div>
                </div>



               <div class="grid grid-cols-3 mt-6 border border-black h-25">

    {{-- ================= SOLICITANTE (DINÁMICA) ================= --}}
    <div class="border-r border-black flex flex-col justify-end text-center p-1 relative">

       @if(in_array($purchaseRequest->estatus, ['numerada','aprobada']))
    @if($purchaseRequest->user && $purchaseRequest->user->firma)
        <img src="{{ asset('storage/'.$purchaseRequest->user->firma) }}"
             class="max-h-28 mx-auto object-contain mb-2">
    @endif
@endif

        <div class="font-bold border-t border-black pt-1 uppercase">
            {{ $purchaseRequest->solicitante }}
        </div>
        <div class="text-[8px] uppercase">Solicitante</div>
    </div>


    {{-- ================= GERENTE (FIJA) ================= --}}
    <div class="border-r border-black flex flex-col justify-end text-center p-1 relative">

        @if(in_array($purchaseRequest->estatus, ['numerada','aprobada']))
          <img src="{{ asset('storage/firmas/gerente.png') }}"
     class="max-h-28 mx-auto object-contain mb-2"
                 alt="Firma Gerente">
        @endif

        <div class="font-bold border-t border-black pt-1 uppercase">
            JUAN GABRIEL DE LA CRUZ TORRES
        </div>
        <div class="text-[8px] uppercase">Gerente de Operaciones</div>
    </div>


    {{-- ================= COMPRAS (FIJA) ================= --}}
    <div class="flex flex-col justify-end text-center p-1 relative">

        @if(in_array($purchaseRequest->estatus, ['aprobada']))
          <img src="{{ asset('storage/firmas/compras.png') }}"
     class="max-h-28 mx-auto object-contain mb-2"
                 alt="Firma Compras">
        @endif

        <div class="font-bold border-t border-black pt-1 uppercase">
            PATRICIA MA. ACOSTA LOPEZ
        </div>
        <div class="text-[8px] uppercase">Compras</div>
    </div>

</div>

            </div>
        </div>
    </div>


    @php
    $role = auth()->user()->role;
@endphp

@if(in_array($role, ['compras','administrador']))

<div class="max-w-5xl mx-auto sm:px-6 lg:px-8 mt-10">
    <div class="bg-slate-900 border border-white/10 
                shadow-2xl rounded-3xl p-8 text-white">

        <div class="flex items-center justify-between mb-8">
            <h3 class="text-xl font-black tracking-tight">
                Historial de Cambios
            </h3>

            <span class="text-xs text-slate-400 uppercase tracking-widest">
                Auditoría interna
            </span>
        </div>

        @if($purchaseRequest->logs->isEmpty())

            <div class="text-center py-6">
                <p class="text-slate-400 text-sm">
                    No hay movimientos registrados.
                </p>
            </div>

        @else

            <div class="space-y-5">

                @foreach($purchaseRequest->logs as $log)

                    <div class="flex items-start gap-4">

                        {{-- Punto visual --}}
                        <div class="mt-2 h-3 w-3 rounded-full 
                                    bg-amber-400 shadow-lg shadow-amber-500/30">
                        </div>

                        {{-- Contenido --}}
                        <div class="flex-1 bg-white/5 
                                    border border-white/10 
                                    rounded-2xl p-5 
                                    hover:bg-white/10 
                                    transition-all duration-200">

                            <div class="flex justify-between items-start">

                                <div>
                                    <p class="text-sm text-slate-300">
                                        Estado cambiado de
                                        <span class="font-bold text-slate-200">
                                            {{ ucfirst($log->from_status ?? '—') }}
                                        </span>
                                        →
                                        <span class="font-bold text-amber-400">
                                            {{ ucfirst($log->to_status) }}
                                        </span>
                                    </p>

                                    <p class="text-xs text-slate-500 mt-1">
                                        Por: {{ $log->user->name ?? 'Sistema' }}
                                    </p>

                                    @if($log->reason)
                                        <p class="text-xs text-slate-400 mt-2 italic">
                                            Motivo: {{ $log->reason }}
                                        </p>
                                    @endif
                                </div>

                                <div class="text-xs text-slate-500 text-right">
                                    {{ $log->created_at->format('d/m/Y') }} <br>
                                    {{ $log->created_at->format('H:i') }}
                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>
</div>

@endif
</x-app-layout>