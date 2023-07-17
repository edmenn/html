@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Informe de Gasto</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-list"></i> 
                Informe
            </a></li>
            <li class="active">Gasto</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-body">
                        <form id="form" class="form-horizontal" action="{{ route('reportes.gasto') }}" method="GET">
                            @csrf
                            <div class="card-body card-padding">
                                <label class="col-sm-2 col-xs-4 control-label">Presupuestos</label>
                                <div class="col-sm-6 col-xs-4">
                                    <select id="presupuesto" name="presupuesto" class="form-control">
                                        <option value="">--- TODOS ---</option>
                                        @foreach ($presupuestos as $item)
                                            <option value="{{ $item->id }}" @if($item->id==old('presupuesto', $presupuesto_id)) selected @endif>{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('presupuesto') <div class="text-red">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <i class="fa fa-tag"></i>
                        <h3 class="box-title">
                            {{ is_null($presupuesto) ? 'Todos los Gastos' : 'Gastos del Presupuesto '.$presupuesto->nombre .' / '.$presupuesto->anho_fiscal .'-'. sprintf("%03d", $presupuesto->codigo) }}
                        </h3>
                    </div>
                    <div class="box-body">
                    <ul>
                        <li><b>Gastos Totales: </b>{{ 'Gs. '.number_format($gastos_totales,0,',','.') }}<br /></li>
                        <li><b>Gastos Proyectos: </b>{{ 'Gs. '.number_format($gastos_proyectos,0,',','.') }}<br /></li>
                        <li><b>Gastos Subproyectos: </b>{{ 'Gs. '.number_format($gastos_subproyectos,0,',','.') }}<br /></li>
                        <li><b>Gastos Proveedores: </b>{{ 'Gs. '.number_format($gastos_proveedor,0,',','.') }}<br /></li>
                    </ul>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
let presupuesto = document.getElementById('presupuesto');
presupuesto.addEventListener("change", submitForm);

function submitForm(){
    document.getElementById('form').submit();
}
</script>
@endpush