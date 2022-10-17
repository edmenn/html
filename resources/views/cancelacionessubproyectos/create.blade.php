@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Cancelación de Monto</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 
                Subproyectos
            </a></li>
            <li class="active">Cancelación de Monto</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-60">
            <div class="box-header">
                <h3 class="box-title display-block text-center">AGREGAR REGISTRO</h3>
            </div>
            <div class="box-body">

                <form class="form-horizontal" action="{{ route('cancelacionessubproyectos.store', $subproyecto->id) }}" method="POST">
                    @csrf
                    
                    <div class="card-body card-padding">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Monto a cancelar</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="monto_cancelado" name="monto_cancelado" type="number" class="form-control" value="{{ old('monto_cancelado') }}" />
                                @error('monto_cancelado') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Motivo</label>
                            <div class="col-sm-10 col-xs-6">
                                <textarea id="motivo" name="motivo" class="form-control">{{ old('motivo') }}</textarea>
                                @error('motivo') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href="{{ route('cancelacionessubproyectos.index', $subproyecto->id) }}" class="btn btn-default m-l-5">Cancelar</a>
                            </div>
                        </div>

                        @error('mensaje')
                        <div class="col-sm-offset-1 col-sm-10 m-t-20">
                            <div class="alert alert-warning">{{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </form>

            </div>
        </div>
    </section>
</div>
@endsection