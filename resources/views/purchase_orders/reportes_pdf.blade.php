<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

body{
font-family: DejaVu Sans;
font-size:10px;
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
border:1px solid #000;
padding:6px;
}

th{
background:#eee;
}

</style>

</head>

<body>

<h2>Reporte de Órdenes Emitidas</h2>

<table>

<thead>
<tr>
<th>OC</th>
<th>Proveedor</th>
<th>Proyecto</th>
<th>Total</th>
</tr>
</thead>

<tbody>

@foreach($ordenes as $o)

<tr>
<td>{{ $o->numero_oc }}</td>
<td>{{ $o->proveedor_nombre }}</td>
<td>{{ $o->proyecto }}</td>
<td>${{ number_format($o->total,2) }}</td>
</tr>

@endforeach

</tbody>

</table>

</body>
</html>