<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    @page { margin: 1cm; }
    body {
        font-family: 'Helvetica', 'Arial', sans-serif;
        font-size: 8px;
        margin: 0;
        color: #000;
        line-height: 1.2;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: -1px; /* Evita bordes dobles */
    }
    td, th {
        border: 1px solid #000;
        padding: 3px 5px;
    }
    .header-title {
        font-size: 11px;
        font-weight: bold;
        text-align: center;
    }
    .blue-light { background-color: #dce6f1; }
    .blue-medium { background-color: #b8cce4; }
    
    .bold { font-weight: bold; }
    .center { text-align: center; }
    .right { text-align: right; }
    .uppercase { text-transform: uppercase; }
    
    .logo-container { text-align: center; padding: 5px; }
    .no-border-bottom { border-bottom: none; }
    .no-border-top { border-top: none; }

    .signature-container {
        margin-top: 10px;
        width: 100%;
    }
    .signature-box {
        width: 33.33%;
        border: 1px solid #000;
        text-align: center;
        vertical-align: bottom;
        height: 80px;
        position: relative;
    }
    .signature-img {
        height: 45px;
        position: absolute;
        top: 5px;
        left: 50%;
        transform: translateX(-50%);
    }
    .footer-note {
        font-size: 7px;
        text-align: justify;
        margin-top: 10px;
        font-weight: bold;
    }
</style>
</head>
<body>

<table>
    <tr>
        <td width="25%" class="center">
            <img src="{{ public_path('images/logo.png') }}" height="35">
        </td>
        <td width="45%" class="header-title">FORMATO DE REQUISICION</td>
        <td width="30%" style="padding: 0;">
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="border: none; border-right: 1px solid #000; border-bottom: 1px solid #000;" class="bold center">PREPARADO POR:</td>
                    <td style="border: none; border-bottom: 1px solid #000;" class="bold center">APROBADO POR:</td>
                </tr>
                <tr>
                    <td style="border: none; border-right: 1px solid #000;" class="center">COMPRAS</td>
                    <td style="border: none;" class="center">GTE. OPERACIONES</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table>
    <tr class="bold center">
        <td width="20%">NÚMERO DE CONTROL</td>
        <td width="20%">CLAS. DOC</td>
        <td width="20%">TIPO. DOC</td>
        <td width="20%">REVISIÓN N°</td>
        <td width="20%">FECHA DE EMISIÓN</td>
    </tr>
    <tr class="center">
        <td>CHEMISERVIS-MX-N5-313</td>
        <td>CONTROLADO</td>
        <td>FORMATO</td>
        <td>1</td>
        <td>30/08/2023</td>
    </tr>
</table>

<div style="margin-top: 10px;"></div>

<table class="uppercase">
    <tr>
        <td colspan="3" class="no-border-bottom" height="15"></td>
        <td class="blue-medium bold" width="15%">NUM. REQUISICION:</td>
        <td width="20%" class="bold">{{ $purchaseRequest->num_requisicion }}</td>
    </tr>
    <tr>
        <td class="blue-light bold" width="10%">POZO:</td>
        <td colspan="2" width="55%">{{ $purchaseRequest->pozo }}</td>
        <td class="blue-medium bold">SOLICITUD DE TRABAJO:</td>
        <td>{{ $purchaseRequest->solicitud_trabajo }}</td>
    </tr>
</table>

<table>
    <tr class="blue-light bold center uppercase">
        <td width="65%">SOLICITANTE:</td>
        <td width="17.5%">FECHA DE REQUISICIÓN</td>
        <td width="17.5%">FECHA REQUERIDA</td>
    </tr>
    <tr class="center uppercase">
        <td class="bold">{{ $purchaseRequest->solicitante }}</td>
        <td>{{ \Carbon\Carbon::parse($purchaseRequest->fecha_requisicion)->format('d-M-y') }}</td>
        <td>{{ \Carbon\Carbon::parse($purchaseRequest->fecha_requerida)->format('d-M-y') }}</td>
    </tr>
</table>

<table>
    <tr class="blue-light bold center uppercase">
        <td width="65%">ÁREA SOLICITANTE:</td>
        <td width="35%">PROYECTO</td>
    </tr>
    <tr class="center uppercase">
        <td class="bold">{{ $purchaseRequest->area->nombre ?? '' }}</td>
        <td class="bold">{{ $purchaseRequest->project->nombre ?? 'GENERAL' }}</td>
    </tr>
</table>

<div style="margin-top: 5px;"></div>

<table>
    <tr class="blue-light bold center uppercase">
        <td width="50%">PROVEEDOR SUGERIDO:</td>
        <td width="50%">CONTACTO</td>
    </tr>
    <tr class="center uppercase">
        <td class="bold">{{ $purchaseRequest->supplier->nombre ?? '' }}</td>
        <td class="bold">{{ $purchaseRequest->supplier->contacto ?? '' }}</td>
    </tr>
</table>

<table>
    <tr class="blue-light bold center uppercase">
        <td width="65%">DIRECCIÓN</td>
        <td width="35%">R.F.C.</td>
    </tr>
    <tr class="center uppercase">
        <td style="font-size: 7px;">{{ $purchaseRequest->supplier->direccion ?? '' }}</td>
        <td class="bold">{{ $purchaseRequest->supplier->rfc ?? '' }}</td>
    </tr>
</table>

<table>
    <tr class="uppercase">
        <td class="blue-light bold" width="18%">CONDICIONES DE PAGO</td>
        <td width="42%" class="center">{{ $purchaseRequest->condicion_pago }}</td>
        <td class="blue-medium bold" width="10%">MONEDA</td>
        <td width="30%" class="center bold">{{ $purchaseRequest->moneda }}</td>
    </tr>
</table>

<div style="margin-top: 5px;"></div>

<table class="uppercase">
    <tr class="blue-light bold center">
        <td width="5%">ITEM</td>
        <td width="10%">CANTIDAD</td>
        <td width="10%">UNIDAD DE MEDIDA</td>
        <td width="45%">DESCRIPCIÓN</td>
        <td width="15%">PRECIO UNITARIO</td>
        <td width="15%">TOTAL</td>
    </tr>
    @foreach($purchaseRequest->items as $item)
    <tr>
        <td class="center">{{ $loop->iteration }}</td>
        <td class="center bold">{{ number_format($item->cantidad, 3) }}</td>
        <td class="center">{{ $item->unit->nombre ?? 'PIEZA' }}</td>
        <td style="font-size: 7px;">{{ $item->descripcion }}</td>
        <td class="right">$ {{ number_format($item->precio_unitario, 2) }}</td>
        <td class="right">$ {{ number_format($item->total, 2) }}</td>
    </tr>
    @endforeach
    <tr>
        <td colspan="6" class="center bold italic">COTIZACION: {{ $purchaseRequest->cotizacion ?? '' }}</td>
    </tr>
</table>

<table class="uppercase">
    <tr>
        <td width="70%" style="border:none;"></td>
        <td width="15%" class="blue-light bold">SUBTOTAL:</td>
        <td width="15%" class="right">$ {{ number_format($purchaseRequest->subtotal, 2) }}</td>
    </tr>
    <tr>
        <td style="border:none;"></td>
        <td class="blue-light bold">DESCUENTO:</td>
        <td class="right">$ {{ number_format($purchaseRequest->descuento, 2) }}</td>
    </tr>
    <tr>
        <td style="border:none;"></td>
        <td class="blue-light bold">I.V.A.:</td>
        <td class="right">$ {{ number_format($purchaseRequest->iva, 2) }}</td>
    </tr>
    <tr>
        <td style="border:none;"></td>
        <td class="blue-light bold" style="font-size: 7px;">RETENCIÓN I.V.A.:</td>
        <td class="right">$ {{ number_format($purchaseRequest->retencion_iva, 2) }}</td>
    </tr>
    <tr>
        <td style="border:none;"></td>
        <td class="blue-light bold" style="font-size: 7px;">RETENCION I.S.R:</td>
        <td class="right">$ {{ number_format($purchaseRequest->retencion_isr, 2) }}</td>
    </tr>
    <tr>
        <td style="border:none;"></td>
        <td class="blue-medium bold">TOTAL</td>
        <td class="right bold">$ {{ number_format($purchaseRequest->total, 2) }}</td>
    </tr>
</table>

<div style="margin-top: 5px;"></div>

<table class="uppercase">
    <tr class="blue-light bold center">
        <td>IMPORTE EN LETRA</td>
    </tr>
    <tr>
        <td class="center bold" style="padding: 5px; font-size: 9px;">{{ $purchaseRequest->total_letra }}</td>
    </tr>
</table>

<table class="signature-container uppercase">
    <tr>
        <td class="signature-box">
            @if($purchaseRequest->user && $purchaseRequest->user->firma)
                <img src="{{ public_path('storage/'.$purchaseRequest->user->firma) }}" class="signature-img">
            @endif
            <div class="bold" style="border-top: 1px solid #000; padding-top: 2px;">{{ $purchaseRequest->solicitante }}</div>
            <div>SOLICITANTE</div>
        </td>
        <td class="signature-box">
            <img src="{{ public_path('storage/firmas/gerente.png') }}" class="signature-img">
            <div class="bold" style="border-top: 1px solid #000; padding-top: 2px;">JUAN GABRIEL DE LA CRUZ TORRES</div>
            <div>GERENTE DE OPERACIONES</div>
        </td>
        <td class="signature-box">
            <img src="{{ public_path('storage/firmas/compras.png') }}" class="signature-img">
            <div class="bold" style="border-top: 1px solid #000; padding-top: 2px;">PATRICIA MA. ACOSTA LOPEZ</div>
            <div>COMPRAS</div>
        </td>
    </tr>
</table>

<div class="footer-note">
    Nota: Todo producto o servicio que requiera en su fase de recepción conocimientos o habilidades especializadas para validar su inspección o recepción, deberá ser realizado por el personal que realizó la solicitud y quien designará en su caso al responsable de efectuar la verificación del producto o servicio a adquirir.
</div>

<div style="text-align: center; font-size: 6px; margin-top: 5px;">
    DERECHOS RESERVADOS<br>
    QUEDA ESTRICTAMENTE PROHIBIDO LA REPRODUCCIÓN Y EL USO INDEBIDO DE ESTE DOCUMENTO...
</div>

</body>
</html>