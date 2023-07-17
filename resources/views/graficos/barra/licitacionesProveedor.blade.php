@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Licitaciones por Proveedor</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-bar-chart"></i> 
                Gráficos
            </a></li>
            <li class="active">Barra</li>
        </ol>
    </section>

    <section class="content">
        <div class="form-group">
            <label class="col-sm-2 col-xs-4 control-label">Proveedores</label>
            <div class="col-sm-6 col-xs-4">
                <select id="proveedor" name="proveedor" class="form-control">
                    <option value="">--- TODOS ---</option>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" @if($proveedor->id==old('proveedor')) selected @endif>{{ $proveedor->nombre_fantasia }}</option>
                    @endforeach
                </select>
                @error('proveedor') <div class="text-red">{{ $message }}</div> @enderror
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
google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(load_page_data);
let proveedor = document.getElementById('proveedor');
proveedor.addEventListener("change", load_page_data);

function load_page_data(){
    try {
        let requestBody = { _token: '{{ csrf_token() }}', proveedor: proveedor.value }
        fetch("/graficos/barra/licitacionesProveedor/data", 
            { method: "POST", headers: new Headers( {"Content-Type": "application/json"} ),
            body: JSON.stringify( requestBody )
        })
        .then((response) => response.json())
        .then((data) => {
            let items = data.data;
            let preparedData = [['Proveedor', 'Monto Adjudicado']];
            for (let index = 0; index < items.length; index++) {
                preparedData.push([items[index].nombre_fantasia, items[index].monto_adjudicado])
            }
            drawChart(preparedData);
        });
    } catch (error) {
        alert("Advertencia: Ocurrio un error intentado resolver la solicitud, pruebe recargando de vuelta la pagina.");
        console.log(error);
    }
}

    function drawChart(preparedData) {
        var data = google.visualization.arrayToDataTable(preparedData);
        var options = {
            chart: {
            title: 'Gráfico de Barras',
            subtitle: 'Licitaciones por Proveedor',
            }
        };
        var chart = new google.charts.Bar(document.getElementById('grafico'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }


</script>
@endpush