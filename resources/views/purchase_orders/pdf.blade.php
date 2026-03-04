<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    @page { margin: 0.8cm; }

    body{
        font-family: Helvetica, Arial, sans-serif;
        font-size: 8px;
        color:#000;
        margin:0;
        line-height:1.1;
    }

    table{
        width:100%;
        border-collapse:collapse;
    }

    td{
        border:1px solid #000;
        padding:3px 4px;
        vertical-align:middle;
    }

    .center{text-align:center;}
    .right{text-align:right;}
    .bold{font-weight:bold;}
    .upper{text-transform:uppercase;}

    .bg-header{
        background:#b8cce4;
        font-weight:bold;
        text-align:center;
    }

    .bg-label{
        background:#dce6f1;
        font-weight:bold;
    }

    .small{font-size:7px;}
    .mini{font-size:6px;color:#666;}
</style>
</head>
<body>

{{-- ================= HEADER PRINCIPAL ================= --}}
<table>
    <tr>
        <td width="25%" class="center">
            <img src="{{ public_path('images/logo.png') }}" height="35">
        </td>
        <td width="45%" class="center bold" style="font-size:14px;">
            ORDEN DE COMPRA
        </td>
        <td width="30%" style="padding:0;">
            <table>
                <tr>
                    <td class="center bold" width="50%">PREPARADO POR:</td>
                    <td class="center bold" width="50%">APROBADO POR:</td>
                </tr>
                <tr>
                    <td class="center">QHSE.</td>
                    <td class="center">GTE. DE OPE.</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- ================= CONTROL DOCUMENTAL ================= --}}
<table class="center bold small">
    <tr class="bg-label">
        <td width="20%">NÚMERO DE CONTROL</td>
        <td width="30%">CLASIFICACIÓN DEL DOCUMENTO</td>
        <td width="20%">TIPO DE DOCUMENTO</td>
        <td width="15%">REVISIÓN N°</td>
        <td width="15%">FECHA DE EMISIÓN</td>
    </tr>
    <tr>
        <td>CHEMISERVIS-MX-N5-73</td>
        <td>CONTROLADO</td>
        <td>FORMATO</td>
        <td>04</td>
        <td>30/08/2023</td>
    </tr>
</table>

<br>

{{-- ================= DATOS GENERALES ================= --}}
<table>
    <tr>
        <td width="15%" class="bg-label">No. DE O/C</td>
        <td width="35%" class="bold">{{ $order->numero_oc }}</td>
        <td width="50%" class="bg-header">DATOS DE CHEMISERVIS</td>
    </tr>

    <tr>
        <td colspan="2" class="bg-header">DATOS DEL PROVEEDOR</td>
        <td rowspan="5" style="padding:0;">
            <table>
                <tr><td class="bold" width="35%">ENVIAR A:</td><td>BENJAMIN ROMERO MORALES</td></tr>
                <tr><td class="bold">CARGO:</td><td>GERENTE GENERAL</td></tr>
                <tr><td class="bold">COMPAÑÍA:</td><td>CHEMISERVIS S.A. DE C.V.</td></tr>
                <tr><td class="bold">RFC:</td><td>CEM140704IU7</td></tr>
                <tr>
                    <td class="bold">DIRECCIÓN:</td>
                    <td class="small">CARRETERA CARDENAS-COMALCALCO LOTE #5 COL. SANTA ROSALIA, CARDENAS, TAB. CP 86470.</td>
                </tr>
            </table>
        </td>
    </tr>

    <tr><td class="bg-label">COMPAÑÍA:</td><td>{{ $order->proveedor_nombre }}</td></tr>
    <tr><td class="bg-label">CONTACTO:</td><td>{{ $order->proveedor_contacto }}</td></tr>
    <tr><td class="bg-label">RFC:</td><td>{{ $order->proveedor_rfc }}</td></tr>
    <tr>
        <td class="bg-label">DIRECCIÓN:</td>
        <td class="small">{{ $order->proveedor_direccion }}</td>
    </tr>
</table>

{{-- ================= REQUISICIÓN ================= --}}
<table>
    <tr>
        <td width="15%" class="bg-label">No. DE REQ.</td>
        <td width="35%">{{ $order->numero_requisicion }}</td>
        <td width="15%" class="bg-label">AREA SOLICITANTE:</td>
        <td width="35%">{{ $order->area }}</td>
    </tr>
    <tr>
        <td class="bg-label">POZO:</td>
        <td>{{ $order->pozo }}</td>
        <td class="bg-label">PROYECTO:</td>
        <td>{{ $order->proyecto }}</td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td class="bg-label">SOLICITUD DE TRABAJO</td>
        <td>{{ $order->solicitud_trabajo }}</td>
    </tr>
</table>

{{-- ================= FECHA Y CONDICIONES ================= --}}
<table class="center small">
    <tr class="bg-header">
        <td width="20%">FECHA DE O/C</td>
        <td width="30%">SOLICITANTE</td>
        <td width="20%">CONDICIONES DE PAGO</td>
        <td width="15%">MONEDA</td>
        <td width="15%">NO. PREFACTURA</td>
    </tr>
    <tr>
        <td>{{ $order->fecha }}</td>
        <td class="upper">{{ $order->solicitante_nombre }}</td>
        <td class="upper">{{ $order->condiciones_pago }}</td>
        <td class="upper">{{ $order->moneda }}</td>
        <td class="bold">COT: {{ $order->cotizacion }}</td>
    </tr>
</table>

{{-- ================= DETALLE PRODUCTOS ================= --}}
<table style="margin-top:5px;">
    <tr class="bg-header">
        <td width="10%">CANTIDAD</td>
        <td width="55%">DESCRIPCIÓN</td>
        <td width="10%">UNIDAD</td>
        <td width="12%">PRECIO UNITARIO</td>
        <td width="13%">TOTAL</td>
    </tr>

    @foreach($order->items as $item)
    <tr>
        <td class="center">{{ number_format($item->cantidad,3) }}</td>
        <td class="upper small">{{ $item->descripcion }}</td>
        <td class="center upper">{{ $item->unidad }}</td>
        <td class="right">$ {{ number_format($item->precio_unitario,2) }}</td>
        <td class="right">$ {{ number_format($item->total,2) }}</td>
    </tr>
    @endforeach
</table>

{{-- ================= TOTALES ================= --}}
<table>
<tr>
<td width="65%" style="border:none;"></td>
<td width="35%" style="padding:0;">
<table>
<tr><td class="bg-label">SUBTOTAL:</td><td class="right">$ {{ number_format($order->subtotal,2) }}</td></tr>
<tr><td class="bg-label">DESCUENTO:</td><td class="right">$ {{ number_format($order->descuento,2) }}</td></tr>
<tr><td class="bg-label">I.V.A:</td><td class="right">$ {{ number_format($order->iva,2) }}</td></tr>
<tr><td class="bg-label small">RETENCIÓN I.V.A:</td><td class="right">$ {{ number_format($order->retencion_iva,2) }}</td></tr>
<tr><td class="bg-label small">RETENCIÓN I.S.R:</td><td class="right">$ {{ number_format($order->retencion_isr,2) }}</td></tr>
<tr class="bg-label bold"><td>TOTAL</td><td class="right">$ {{ number_format($order->total,2) }}</td></tr>
</table>
</td>
</tr>
</table>

{{-- ================= IMPORTE EN LETRA ================= --}}
<table style="margin-top:5px;">
<tr class="bg-label center">
<td>IMPORTE EN LETRA</td>
</tr>
<tr>
<td class="center bold upper" style="padding:5px;">
{{ $order->total_letra }}
</td>
</tr>
</table>

{{-- ================= FIRMAS ================= --}}
<table style="margin-top:10px;">
<tr>
<td width="50%" class="center">
@if($order->firma_autorizada)
<img src="{{ public_path('storage/'.$order->firma_autorizada) }}" height="40">
@endif
<br>
<strong>{{ $order->autorizador_nombre }}</strong>
</td>
<td width="50%" class="center">
{{ $order->fecha }}
</td>
</tr>
<tr class="bg-label center">
<td>AUTORIZADO POR:</td>
<td>FECHA</td>
</tr>
</table>

{{-- ================= NOTA ================= --}}
<div class="small" style="margin-top:8px;text-align:justify;">
<strong>Nota:</strong> Todo producto o servicio que requiera en su fase de recepción conocimientos o habilidades especializadas para validar su inspección o recepción, deberá ser realizado por el personal que realizó la solicitud y quien designará en su caso al responsable de efectuar la verificación del producto o servicio a adquirir.
</div>

<div class="center mini" style="margin-top:5px;">
DERECHOS RESERVADOS. QUEDA ESTRICTAMENTE PROHIBIDA LA REPRODUCCIÓN Y EL USO INDEBIDO...
</div>

</body>
</html>