@php
  // For PDF rendering prefer a self-contained layout and styles (dompdf may ignore external CSS)
  function money($v) { return number_format($v, 2, ',', '.'); }
  function fmtDate($d) { try { return \Carbon\Carbon::parse($d)->format('d/m/Y'); } catch (\Exception $e) { return $d; } }
@endphp

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Reporte {{ $start->format('Y-m-d') }} - {{ $end->format('Y-m-d') }}</title>
  <style>
    body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color:#222; }
    .header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
    .brand { font-size:18px; font-weight:700; color:#0d6efd; }
    .meta { text-align:right; font-size:12px; }
    .box { border:1px solid #e0e0e0; padding:12px; margin-bottom:12px; }
    .totals { display:flex; gap:12px; margin-bottom:16px; }
    .tot { background:#f8f9fa; padding:10px; border-radius:4px; flex:1; text-align:center; }
    table { width:100%; border-collapse:collapse; font-size:12px; }
    th, td { padding:8px 10px; border:1px solid #ddd; }
    th { background:#f1f3f5; text-align:left; }
    tfoot td { font-weight:700; }
    .right { text-align:right; }
    .small { font-size:11px; color:#555; }
    footer { position:fixed; bottom:0; left:0; right:0; text-align:center; font-size:11px; color:#666; }
  </style>
</head>
<body>
  <div class="header">
    <div class="brand">InventarioApp — Reportes</div>
    <div class="meta">
      <div>Fecha: {{ now()->format('d/m/Y') }}</div>
      <div class="small">Periodo: {{ $start->format('d/m/Y') }} — {{ $end->format('d/m/Y') }}</div>
    </div>
  </div>

  <div class="totals">
    <div class="tot">
      <div class="small">Total productos</div>
      <div style="font-size:18px;">{{ $totalProducts }}</div>
    </div>
    <div class="tot">
      <div class="small">Movimientos (unidades)</div>
      <div style="font-size:18px;">{{ $totalUnits }}</div>
    </div>
    <div class="tot">
      <div class="small">Valor estimado</div>
      <div style="font-size:18px;">${{ money($totalValue) }}</div>
    </div>
  </div>

  <div class="box">
      <div class="header">
        <div class="brand">InventarioApp — Reportes</div>
        <div class="meta">
            <div>Fecha: {{ now()->format('d/m/Y') }}</div>
            <div class="small">Periodo: {{ $start->format('d/m/Y') }} — {{ $end->format('d/m/Y') }}</div>
        </div>
    </table>
  </div>

  <footer>InventarioApp — Generado el {{ now()->format('d/m/Y H:i') }}</footer>
</body>
</html>
