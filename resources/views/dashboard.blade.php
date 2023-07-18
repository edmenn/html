@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Dashboard</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 
                Dashboard
            </a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <section class="content">
        <div class="form-group">
            <center><h3>Barras de Presupuesto vs Gasto</h3></center>
            <label class="col-sm-2 col-xs-4 control-label">Anho Fiscal</label>
            <div class="col-sm-6 col-xs-4">
                <select id="anho_fiscal" name="anho_fiscal" class="form-control">
                    <option value="">--- TODOS ---</option>
                    @foreach ($anho_fiscal as $item)
                        <option value="{{ $item->anho_fiscal }}" @if($item->anho_fiscal==old('anho_fiscal')) selected @endif>{{ $item->anho_fiscal }}</option>
                    @endforeach
                </select>
                @error('anho_fiscal') <div class="text-red">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="clearfix"></div><br />
        <div id="grafico2" style="width: 800px; height: 500px;"></div>
    </section>

    <section class="content">
        <div class="form-group">
            <center><h3>Barras de Licitaciones por Proveedor</h3></center>
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
        <div id="grafico1" style="width: 800px; height: 500px;"></div>
    </section>

    <section class="content">
        <div class="form-group">
            <center><h3>Pastel de Gastos por Proyecto</h3></center>
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
        <div id="grafico3" style="width: 800px; height: 500px;"></div>
    </section>

</div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
// LOAD GOOGLE PACKAGES
google.charts.load('current', {'packages':['bar', 'corechart']});
google.charts.setOnLoadCallback(load_page);
// INITIALIZE VARIABLES
let proveedor = document.getElementById('proveedor');
let anho_fiscal = document.getElementById('anho_fiscal');
let presupuesto = document.getElementById('presupuesto');
proveedor.addEventListener("change", load_page_data1);
anho_fiscal.addEventListener("change", load_page_data2);
presupuesto.addEventListener("change", load_page_data3);

function load_page_data1(){
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
            drawChart1(preparedData);
        });
    } catch (error) {
        alert("Advertencia: Ocurrio un error intentado resolver la solicitud, pruebe recargando de vuelta la pagina.");
        console.log(error);
    }
}

function drawChart1(preparedData) {
    var data = google.visualization.arrayToDataTable(preparedData);
    var options = {
        chart: {
        title: 'Gráfico de Barras',
        subtitle: 'Licitaciones por Proveedor',
        }
    };
    var chart = new google.charts.Bar(document.getElementById('grafico1'));
    chart.draw(data, google.charts.Bar.convertOptions(options));
}

function load_page_data2(){
    try {
        let requestBody = { _token: '{{ csrf_token() }}', anho_fiscal: anho_fiscal.value }
        fetch("/graficos/barra/presupuestoVsGasto/data", 
            { method: "POST", headers: new Headers( {"Content-Type": "application/json"} ),
            body: JSON.stringify( requestBody )
        })
        .then((response) => response.json())
        .then((data) => {
            let items = data.data;
            let preparedData = [['Presupuesto', 'Presupuestado', 'Contratado']];
            for (let index = 0; index < items.length; index++) {
                preparedData.push([items[index].nombre, items[index].costo, items[index].gasto_real])
            }
            drawChart2(preparedData);
        });
    } catch (error) {
        alert("Advertencia: Ocurrio un error intentado resolver la solicitud, pruebe recargando de vuelta la pagina.");
        console.log(error);
    }
}

function drawChart2(preparedData) {
    var data = google.visualization.arrayToDataTable(preparedData);
    var options = {
        chart: {
        title: 'Gráfico de Barras',
        subtitle: 'Presupuesto vs Gasto Real',
        }
    };
    var chart = new google.charts.Bar(document.getElementById('grafico2'));
    chart.draw(data, google.charts.Bar.convertOptions(options));
}

function load_page_data3(){
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
            drawChart3(preparedData);
        });
    } catch (error) {
        alert("Advertencia: Ocurrio un error intentado resolver la solicitud, pruebe recargando de vuelta la pagina.");
        console.log(error);
    }
}

function drawChart3(preparedData) {
    let nombre_presupuesto = presupuesto.options[presupuesto.selectedIndex].text;
    var data = google.visualization.arrayToDataTable(preparedData);
    var options = { title: 'Gastos por Proyecto - '+nombre_presupuesto };
    var chart = new google.visualization.PieChart(document.getElementById('grafico3'));
    chart.draw(data, options);
}

function load_page(){
    load_page_data1();
    load_page_data2();
    load_page_data3();
}
</script>
@endpush