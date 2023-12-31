@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Puertos</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 
                Puertos
            </a></li>
            <li class="active">Puertos</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-60">
            <div class="box-header">
                <h3 class="box-title display-block text-center">EDITAR PUERTO</h3>
            </div>
            <div class="box-body">

                <form class="form-horizontal" action="{{ route('puertos.update', $puerto->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body card-padding">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Nombre</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="nombre" name="nombre" type="text" class="form-control" value="{{ old('nombre', $puerto->nombre) }}" />
                                @error('nombre') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Dirección</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="direccion" name="direccion" type="text" class="form-control" value="{{ old('direccion', $puerto->direccion) }}" />
                                @error('direccion') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-warning">Modificar</button>
                                <a href="{{ route('puertos.index') }}" class="btn btn-default m-l-5">Cancelar</a>
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