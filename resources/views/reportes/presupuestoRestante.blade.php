@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Informe de Presupuesto Restante</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-list"></i> 
                Informe
            </a></li>
            <li class="active">Presupuesto Restante</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-body">
                        <form id="form" class="form-horizontal" action="{{ route('reportes.presupuestoRestante') }}" method="GET">
                            @csrf
                            <div class="card-body card-padding">
                                <label class="col-sm-2 col-xs-4 control-label">Presupuestos</label>
                                <div class="col-sm-6 col-xs-4">
                                    <select id="presupuesto" name="presupuesto" class="form-control">
                                        <option value="">--- TODOS ---</option>
                                        @foreach ($presupuestos_list as $item)
                                            <option value="{{ $item->id }}" @if($item->id==old('presupuesto', $presupuesto)) selected @endif>{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('presupuesto') <div class="text-red">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @foreach ($presupuestos as $presupuesto)
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <i class="fa fa-tag"></i>
                        <h3 class="box-title">
                            {{ $presupuesto->nombre .' / '.$presupuesto->anho_fiscal .'-'. sprintf("%03d", $presupuesto->codigo) }} - Presupuesto: </b>{{ 'Gs. '.number_format($presupuesto->costo,0,',','.') }}
                        </h3>
                    </div>
                    <div class="box-body">
                    <ul>
                        @foreach ($presupuesto->proyectos as $proyecto)    
                        <li>
                            <h4>Proyecto {{ $proyecto->nombre }}</h4>
                            <p>
                                <b>Costo: </b>{{ 'Gs. '.number_format($proyecto->costo,0,',','.') }}<br />
                                <b>Contratado: </b>{{ 'Gs. '.number_format($proyecto->contratado,0,',','.') }}<br />
                                <b>Monto restante: </b>{{ 'Gs. '.number_format(intval($proyecto->costo) - intval($proyecto->contratado),0,',','.') }}
                            </p>
                            <ul>
                            @foreach ($proyecto->subproyectos as $subproyecto)
                                <h5>Suproyecto {{ $subproyecto->nombre }}</h5>
                                <p>
                                    <b>Costo: </b>{{ 'Gs. '.number_format($subproyecto->costo,0,',','.') }}<br />
                                    <b>Contratado: </b>{{ 'Gs. '.number_format($subproyecto->contratado,0,',','.') }}<br />
                                    <b>Monto restante: </b>{{ 'Gs. '.number_format(intval($subproyecto->costo) - intval($subproyecto->contratado),0,',','.') }}
                                </p>
                            @endforeach
                            </ul>
                            <hr />
                        </li>
                        @endforeach
                    </ul>
                    </div>
                </div>
            </div>
            @endforeach

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