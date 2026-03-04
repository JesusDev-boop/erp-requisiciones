<x-app-layout>
    <x-slot name="header">
     <div class="flex items-center gap-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">

            {{-- Lado Izquierdo --}}
            <div class="flex items-center gap-4">

               {{-- Botón Regresar al Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="p-3 bg-white/5 border border-white/10 rounded-2xl text-white hover:bg-white/10 hover:border-white/20 transition-all shadow-lg backdrop-blur-md group">
                    
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
                {{-- Título --}}
                <div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">
                        Nueva Requisición
                    </h2>

                    <div class="flex items-center gap-2 mt-2 text-sm text-slate-300 font-semibold">
                        <span>Solicitud</span>
                        <svg class="w-4 h-4 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="text-white font-bold">Crear</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-slot>
   <div class="py-10 min-h-screen font-semibold">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('purchase-requests.store') }}">
                @csrf

                <div class="space-y-8">
                    {{-- SECCIÓN 1: DATOS OPERATIVOS --}}
                    <div class="bg-white border border-slate-200 shadow-sm rounded-3xl p-8">
                        <div class="flex items-center space-x-3 mb-8 border-b border-slate-100 pb-4">
                            <div class="bg-sky-100 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider text-sm">Información del Proyecto</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="label">Pozo / Ubicación</label>
                                <input type="text" name="pozo" class="input" placeholder="Nombre del pozo">
                            </div>
                            <div>
                                <label class="label">Solicitud de Trabajo</label>
                                <input type="text" name="solicitud_trabajo" class="input" placeholder="Referencia ST">
                            </div>
                            <div>
                                <label class="label">Proyecto</label>
                                <select name="project_id" class="input select-custom">
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="label">Fecha Requisición</label>
                                <input type="date" name="fecha_requisicion" class="input" required>
                            </div>
                            <div>
                                <label class="label">Fecha Requerida</label>
                                <input type="date" name="fecha_requerida" class="input" required>
                            </div>
                            <div>
                                <label class="label">Solicitante</label>
                                <input type="text" name="solicitante" class="input" required placeholder="Nombre completo">
                            </div>
                            <div>
                                <label class="label text-slate-400">Área (Solo lectura)</label>
                                <input type="text" value="{{ auth()->user()->area->nombre }}" class="input bg-slate-50 text-slate-500 border-dashed cursor-not-allowed font-medium" readonly>
                                <input type="hidden" name="area_id" value="{{ auth()->user()->area_id }}">
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN 2: PROVEEDOR --}}
                    <div class="bg-white border border-slate-200 shadow-sm rounded-3xl p-8">
                        <div class="flex items-center space-x-3 mb-8 border-b border-slate-100 pb-4">
                            <div class="bg-emerald-100 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider text-sm">Detalles del Proveedor</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div class="md:col-span-2">
                                <label class="label">Proveedor</label>
                                <select name="supplier_id" id="supplier_select" class="input select-custom">
                                    <option value="">Seleccione proveedor</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" data-rfc="{{ $supplier->rfc }}" data-direccion="{{ $supplier->direccion }}" data-contacto="{{ $supplier->contacto }}">
                                            {{ $supplier->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="label">RFC</label>
                                <input type="text" name="rfc" id="rfc" class="input bg-slate-50 font-mono text-xs uppercase" readonly>
                            </div>
                            <div>
                                <label class="label">Contacto</label>
                                <input type="text" name="contacto" id="contacto" class="input" placeholder="Nombre de contacto">
                            </div>
                            <div class="md:col-span-2">
                                <label class="label">Dirección Fiscal</label>
                                <input type="text" name="direccion" id="direccion" class="input bg-slate-50 text-xs" readonly>
                            </div>
                            <div>
                                <label class="label">Moneda</label>
                                <select name="moneda" class="input">
                                    <option value="nacional">🇲🇽 MXN - Nacional</option>
                                    <option value="dolares">🇺🇸 USD - Dólares</option>
                                </select>
                            </div>
                            <div>
                                <label class="label">Condición de Pago</label>
                                <select name="condicion_pago" class="input">
                                    <option value="CREDITO">CRÉDITO</option>
                                    <option value="CREDITO 15 DIAS">15 DÍAS</option>
                                    <option value="CREDITO 30 DIAS">30 DÍAS</option>
                                    <option value="CONTADO">CONTADO</option>
                                </select>
                            </div>
                            <div>
                                <label class="label">Número de Cotización</label>
                                <input type="text" name="cotizacion" class="input font-bold text-sky-700" placeholder="Ej. 1982">
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN 3: PARTIDAS --}}
                  <div class="bg-white border border-slate-200 shadow-xl rounded-3xl overflow-hidden font-semibold">
                        <div class="p-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <h3 class="text-lg font-bold text-slate-800">Partidas de la Requisición</h3>
                            <button type="button" onclick="addRow()" class="inline-flex items-center px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl transition shadow-lg shadow-sky-200 uppercase tracking-widest">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Agregar Fila
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm" id="items-table">
                                <thead class="bg-slate-900 text-white uppercase text-[10px] tracking-widest">
                                    <tr>
                                        <th class="p-4 text-center">#</th>
                                        <th class="p-4 text-center w-24">Cant.</th>
                                        <th class="p-4 text-center w-32">Unidad</th>
                                        <th class="p-4 text-left">Descripción del Bien o Servicio</th>
                                        <th class="p-4 text-right w-40">Precio Unit.</th>
                                        <th class="p-4 text-right w-40">Importe</th>
                                        <th class="p-4 text-center w-16"></th>
                                    </tr>
                                </thead>
                                <tbody id="items-body" class="divide-y divide-slate-100">
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="p-4 text-center item-number font-bold text-slate-400">1</td>
                                        <td class="p-2">
                                            <input type="number" step="0.01" name="items[0][cantidad]" class="input-table cantidad text-center" placeholder="0">
                                        </td>
                                        <td class="p-2">
                                            <select name="items[0][unit_id]" class="input-table">
                                                @foreach($units as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="p-2">
                                            <input type="text" name="items[0][descripcion]" class="input-table" placeholder="Escriba el concepto...">
                                        </td>
                                        <td class="p-2">
                                            <div class="relative">
                                                <span class="absolute left-2 top-2.5 text-slate-400 text-xs">$</span>
                                                <input type="number" step="0.01" name="items[0][precio_unitario]" class="input-table price text-right pr-4" placeholder="0.00">
                                            </div>
                                        </td>
                                        <td class="p-4 total text-right font-bold text-slate-700 font-mono">
                                            $0.00
                                        </td>
                                        <td class="p-4 text-center">
                                            <button type="button" onclick="removeRow(this)" class="p-2 text-slate-300 hover:text-rose-600 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- PANEL DE TOTALES --}}
                        <div class="bg-slate-50 p-8 flex justify-end">
                            <div class="w-full md:w-80 space-y-3">
                                <div class="flex justify-between text-slate-600">
                                    <span class="font-medium">Subtotal</span>
                                    <span class="font-mono font-bold" id="subtotal_display">$0.00</span>
                                </div>
                                <div class="flex justify-between items-center text-slate-600">
                                    <span class="font-medium text-xs uppercase tracking-tighter">Descuento</span>
                                    <input type="number" step="0.01" name="descuento" id="descuento" class="w-24 bg-white border border-slate-200 rounded-lg p-1 text-right text-sm font-mono" value="0">
                                </div>
                                <div class="flex justify-between text-slate-600 border-b border-slate-200 pb-2">
                                    <span class="font-medium">IVA (16%)</span>
                                    <span class="font-mono font-bold" id="iva_display">$0.00</span>
                                </div>
                                <div class="flex justify-between items-center text-slate-500 text-xs italic">
                                    <span>Retención IVA</span>
                                    <input type="number" step="0.01" name="retencion_iva" id="retencion_iva" class="w-20 bg-transparent border-b border-slate-200 p-0 text-right focus:ring-0 focus:border-sky-500" value="0">
                                </div>
                                <div class="flex justify-between items-center text-slate-500 text-xs italic">
                                    <span>Retención ISR</span>
                                    <input type="number" step="0.01" name="retencion_isr" id="retencion_isr" class="w-20 bg-transparent border-b border-slate-200 p-0 text-right focus:ring-0 focus:border-sky-500" value="0">
                                </div>
                                <div class="flex justify-between text-slate-900 pt-4">
                                    <span class="text-lg font-black uppercase tracking-tighter">Total Final</span>
                                    <span class="text-2xl font-black text-sky-600 font-mono" id="total_display">$0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pb-12">
                        <button type="button" onclick="window.history.back()" class="text-slate-500 hover:text-slate-800 font-bold text-sm transition flex items-center">
                             <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                             Regresar
                        </button>
                        <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-12 py-4 rounded-2xl font-bold shadow-2xl transition-all transform hover:-translate-y-1 active:scale-95 flex items-center">
                            Guardar Requisición
                            <svg class="w-5 h-5 ml-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .label {
            display: block;
            font-size: 11px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
            padding-left: 4px;
        }
        .input {
            width: 100%;
            border: 1.5px solid #e2e8f0;
            padding: 10px 14px;
            border-radius: 14px;
            transition: all 0.2s;
            font-size: 14px;
            color: #000 important;
             background: #ffffff !important;
        }
        .input,
.input-table {
    color: #000 !important;
    background: #ffffff !important;
}
        .input:focus {
            outline: none;
            border-color: #0ea5e9;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
            background: #fff;
        }
        .input-table {
            width: 100%;
            background: transparent;
            border: 1.5px solid transparent;
            padding: 8px;
            border-radius: 10px;
            transition: all 0.2s;
        }
        .input-table:focus {
            outline: none;
            background: white;
            border-color: #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }
        .select-custom {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1rem;
        }
    </style>

    {{-- EL SCRIPT SE MANTIENE EXACTAMENTE IGUAL --}}
   <script>
document.getElementById('supplier_select')
.addEventListener('change', function() {

    let selected = this.options[this.selectedIndex];

    document.getElementById('rfc').value =
        selected.getAttribute('data-rfc') || '';

    document.getElementById('direccion').value =
        selected.getAttribute('data-direccion') || '';

    document.getElementById('contacto').value =
        selected.getAttribute('data-contacto') || '';
});

let itemIndex = 1;

function addRow() {

    const table = document.getElementById('items-body');
    const rowCount = table.rows.length;

    const newRow = table.rows[0].cloneNode(true);

    newRow.querySelector('.item-number').innerText = rowCount + 1;

    newRow.querySelectorAll('input').forEach(input => {
        input.value = '';
    });

    newRow.querySelector('.total').innerText = '$0.00';

    newRow.querySelectorAll('input, select').forEach(field => {
        const name = field.getAttribute('name');
        field.setAttribute('name', name.replace(/\d+/, rowCount));
    });

    table.appendChild(newRow);
}

function removeRow(button) {
    const table = document.getElementById('items-body');

    if (table.rows.length > 1) {
        button.closest('tr').remove();
        reNumber();
    }
}

function reNumber() {
    const rows = document.querySelectorAll('#items-body tr');
    rows.forEach((row, index) => {
        row.querySelector('.item-number').innerText = index + 1;
    });
}

// 🔥 CALCULO AUTOMATICO
document.addEventListener('input', function(e) {

    if (e.target.classList.contains('price') || 
        e.target.name.includes('[cantidad]')) {

        const row = e.target.closest('tr');

        const cantidad = parseFloat(
            row.querySelector('input[name*="[cantidad]"]').value
        ) || 0;

        const precio = parseFloat(
            row.querySelector('.price').value
        ) || 0;

        const total = cantidad * precio;

        row.querySelector('.total').innerText =
            '$' + total.toLocaleString('es-MX', { minimumFractionDigits: 2 });
    }

});

function calcularTotales() {

    let subtotal = 0;

    document.querySelectorAll('#items-body tr').forEach(row => {

        const cantidad = parseFloat(
            row.querySelector('input[name*="[cantidad]"]').value
        ) || 0;

        const precio = parseFloat(
            row.querySelector('input[name*="[precio_unitario]"]').value
        ) || 0;

        subtotal += cantidad * precio;
    });

    let descuento = parseFloat(document.getElementById('descuento').value) || 0;

    let iva = subtotal * 0.16;

    let retencionIva = parseFloat(document.getElementById('retencion_iva').value) || 0;
    let retencionIsr = parseFloat(document.getElementById('retencion_isr').value) || 0;

    let total = subtotal + iva - descuento - retencionIva - retencionIsr;

    document.getElementById('subtotal_display').innerText =
        '$' + subtotal.toLocaleString('es-MX',{minimumFractionDigits:2});

    document.getElementById('iva_display').innerText =
        '$' + iva.toLocaleString('es-MX',{minimumFractionDigits:2});

    document.getElementById('total_display').innerText =
        '$' + total.toLocaleString('es-MX',{minimumFractionDigits:2});
}

document.addEventListener('input', function(e) {
    if (
        e.target.classList.contains('price') ||
        e.target.name.includes('[cantidad]') ||
        e.target.id === 'descuento' ||
        e.target.id === 'retencion_iva' ||
        e.target.id === 'retencion_isr'
    ) {
        calcularTotales();
    }
});

</script>

</x-app-layout>