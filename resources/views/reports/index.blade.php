@extends('layaout.layaout')
@section('title','Reportes')

@section('content')
<div class="card mt-3">
  <div class="card-body">
    <h4 class="mb-3">Reportes</h4>

    <form method="GET" action="{{ route('reports.index') }}" class="form-inline mb-3">
      <select name="period" class="form-control mr-2">
        <option value="day" {{ $period=='day' ? 'selected' : '' }}>Día</option>
        <option value="week" {{ $period=='week' ? 'selected' : '' }}>Semana</option>
        <option value="month" {{ $period=='month' ? 'selected' : '' }}>Mes</option>
        <option value="year" {{ $period=='year' ? 'selected' : '' }}>Año</option>
        <option value="range" {{ $period=='range' ? 'selected' : '' }}>Rango</option>
      </select>

      <input type="date" name="from" value="{{ request('from') }}" class="form-control mr-2" />
      <input type="date" name="to" value="{{ request('to') }}" class="form-control mr-2" />

      <button class="btn btn-primary">Filtrar</button>
      <a href="{{ route('reports.exportPdf', request()->all()) }}" class="btn btn-outline-secondary ml-2">Exportar PDF</a>
    </form>

    <div class="row">
      <div class="col-md-4">
        <div class="card p-3 mb-3">
          <strong>Total productos:</strong> {{ $totalProducts ?? 0 }}
        </div>
        <div class="card p-3">
          <strong>Movimientos (unidades):</strong> {{ $totalUnits ?? 0 }} <br>
          <strong>Valor total (estimado):</strong> ${{ number_format($totalValue ?? 0,2) }}
        </div>
      </div>

      <div class="col-md-8">
        <canvas id="reportChart" height="140"></canvas>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const labels = {!! json_encode($labels ?? []) !!};
  const dataUnits = {!! json_encode($dataUnits ?? []) !!};
  const dataValue = {!! json_encode($dataValue ?? []) !!};

  const ctx = document.getElementById('reportChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [
        { label: 'Unidades movidas', data: dataUnits, borderColor: 'rgba(54,162,235,1)', backgroundColor: 'rgba(54,162,235,0.2)', fill: true },
        { label: 'Valor estimado', data: dataValue, borderColor: 'rgba(255,99,132,1)', backgroundColor: 'rgba(255,99,132,0.15)', fill: true }
      ]
    },
    options: { scales: { y: { beginAtZero: true } } }
  });
</script>
@endpush
