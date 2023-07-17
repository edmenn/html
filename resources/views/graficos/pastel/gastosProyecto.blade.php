@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Gastos por Proyecto</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-bar-chart"></i> 
                Gráficos
            </a></li>
            <li class="active">Pastel</li>
        </ol>
    </section>

    <section class="content">
        <div class="form-group">
            <label class="col-sm-2 col-xs-4 control-label">Presupuestos</label>
            <div class="col-sm-6 col-xs-4">
                <select id="presupuesto" name="presupuesto" class="form-control">
                    <option value="">--- TODOS ---</option>
                    @foreach ($presupuestos as $item)
                        <option value="{{ $item->id }}" @if($item->id==old('presupuesto', $presupuesto)) selected @endif>{{ $item->nombre }}</option>
                    @endforeach
                </select>
                @error('presupuesto') <div class="text-red">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="clearfix"></div><br />
        <div id="grafico" style="width: 800px; height: 500px;"></div>
    </section>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(load_page_data);
let presupuesto = document.getElementById('presupuesto');
presupuesto.addEventListener("change", load_page_data);

function load_page_data(){
    try {
        let requestBody = { _token: '{{ csrf_token() }}', presupuesto: presupuesto.value }
        fetch("/graficos/pastel/gastosProyecto/data", 
            { method: "POST", headers: new Headers( {"Content-Type": "application/json"} ),
            body: JSON.stringify( requestBody )
        })
        .then((response) => response.json())
        .then((data) => {
            let items = data.data;
            let preparedData = [['Proyecto', 'Costo']];
            for (let index = 0; index < items.length; index++) {
                preparedData.push([items[index].nombre, items[index].costo])
            }
            drawChart(preparedData);
        });
    } catch (error) {
        alert("Advertencia: Ocurrio un error intentado resolver la solicitud, pruebe recargando de vuelta la pagina.");
        console.log(error);
    }
}

function drawChart(preparedData) {
    let nombre_presupuesto = presupuesto.options[presupuesto.selectedIndex].text;
    var data = google.visualization.arrayToDataTable(preparedData);
    var options = { title: 'Gastos por Proyecto - '+nombre_presupuesto };
    var chart = new google.visualization.PieChart(document.getElementById('grafico'));
    chart.draw(data, options);
}


</script>
@endpush