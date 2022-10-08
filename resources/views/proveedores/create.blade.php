@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Proveedores</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 
                Proveedores
            </a></li>
            <li class="active">Proveedores</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-60">
            <div class="box-header">
                <h3 class="box-title display-block text-center">AGREGAR PROVEEDOR</h3>
            </div>
            <div class="box-body">

                <form class="form-horizontal" action="{{ route('proveedores.store') }}" method="POST">
                    @csrf
                    <div class="card-body card-padding">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Nombre</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="nombre_fantasia" name="nombre_fantasia" type="text" class="form-control" value="{{ old('nombre_fantasia') }}" />
                                @error('nombre_fantasia') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Razón Social</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="razon_social" name="razon_social" type="text" class="form-control" value="{{ old('razon_social') }}" />
                                @error('razon_social') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">RUC</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="ruc" name="ruc" type="text" class="form-control" value="{{ old('ruc') }}" />
                                @error('ruc') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Teléfono</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="telefono" name="telefono" type="text" class="form-control" value="{{ old('telefono') }}" />
                                @error('telefono') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Dirección</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="direccion" name="direccion" type="text" class="form-control" value="{{ old('direccion') }}" />
                                @error('direccion') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href="{{ route('proveedores.index') }}" class="btn btn-default m-l-5">Cancelar</a>
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