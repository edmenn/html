@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Comentarios</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 
                Subproyectos
            </a></li>
            <li class="active">Comentarios</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-60">
            <div class="box-header">
                <h3 class="box-title display-block text-center">AGREGAR REGISTRO</h3>
            </div>
            <div class="box-body">

                <form class="form-horizontal" action="{{ route('subproyectos.comentarios.store', $subproyecto->id) }}" method="POST">
                    @csrf
                    
                    <div class="card-body card-padding">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Comentario</label>
                            <div class="col-sm-10 col-xs-6">
                                <textarea id="comentario" name="comentario" class="form-control">{{ old('comentario') }}</textarea>
                                @error('comentario') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href="{{ route('subproyectos.comentarios.index', $subproyecto->id) }}" class="btn btn-default m-l-5">Cancelar</a>
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