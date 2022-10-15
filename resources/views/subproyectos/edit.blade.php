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

                <form class="form-horizontal" action="{{ route('proyectos.subproyectos.update', [$proyecto->id, $subproyecto->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body card-padding">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Nombre</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="nombre" name="nombre" type="text" class="form-control" value="{{ old('nombre', $subproyecto->nombre) }}" />
                                @error('nombre') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Descripción</label>
                            <div class="col-sm-10 col-xs-6">
                                <textarea id="descripcion" name="descripcion" class="form-control">{{ old('descripcion', $subproyecto->descripcion) }}</textarea>
                                @error('descripcion') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Código</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="codigo" name="codigo" type="text" class="form-control" value="{{ old('codigo', $subproyecto->codigo) }}" />
                                @error('codigo') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Contratado</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="contratado" name="contratado" type="number" class="form-control" value="{{ old('contratado', $subproyecto->contratado) }}" />
                                @error('contratado') <div class="text-red">{{ $message }}</div> @enderror
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