@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Presupuestos</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 
                Proyectos
            </a></li>
            <li class="active">SubProyectos</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-60">
            <div class="box-header">
                <h3 class="box-title display-block text-center">EDITAR SUBPROYECTO</h3>
            </div>
            <div class="box-body">

                <form class="form-horizontal" action="{{ route('proyectos.subproyectos.updateEstado', [$proyecto->id, $subproyecto->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body card-padding">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Nombre</label>
                            <div class="col-sm-10 col-xs-6">
                                <input type="text" class="form-control" value="{{ $subproyecto->nombre }}" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Descripción</label>
                            <div class="col-sm-10 col-xs-6">
                                <textarea class="form-control" readonly>{{ $subproyecto->descripcion }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Código</label>
                            <div class="col-sm-10 col-xs-6">
                                <input type="text" class="form-control" value="{{ $subproyecto->codigo }}" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Costo</label>
                            <div class="col-sm-10 col-xs-6">
                                <input type="text" class="form-control" value="{{ $subproyecto->costo }}" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Contratado</label>
                            <div class="col-sm-10 col-xs-6">
                                <input type="text" class="form-control" value="{{ $subproyecto->contratado }}" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Estado</label>
                            <div class="col-sm-10 col-xs-6">
                                <select id="estado_id" name="estado_id" class="form-control">
                                    @foreach ($estados as $item)
                                        <option value="{{ $item->id }}" @if($item->id==old('estado_id', $subproyecto->estado_id)) selected @endif>
                                            {{ $item->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('estado_id') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-warning">Modificar</button>
                                <a href="{{ route('proyectos.subproyectos.index', $proyecto->id) }}" class="btn btn-default m-l-5">Cancelar</a>
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