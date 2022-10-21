@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Licitaciones</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 
                Subproyectos
            </a></li>
            <li class="active">Licitaciones</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-60">
            <div class="box-header">
                <h3 class="box-title display-block text-center">AGREGAR REGISTRO</h3>
            </div>
            <div class="box-body">

                <form class="form-horizontal" action="{{ route('subproyectos.licitaciones.store', $subproyecto->id) }}" method="POST">
                    @csrf
                    
                    <div class="card-body card-padding">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Proveedor</label>
                            <div class="col-sm-10 col-xs-6">
                                <select id="proveedor_id" name="proveedor_id" class="form-control">
                                    @foreach ($proveedores as $item)
                                        <option value="{{ $item->id }}" @if($item->id==old('proveedor_id')) selected @endif>
                                            {{ $item->nombre_fantasia }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('proveedor_id') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Concepto</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="concepto" name="concepto" type="text" class="form-control" value="{{ old('concepto') }}" />
                                @error('concepto') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Monto</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="monto" name="monto" type="number" class="form-control" value="{{ old('monto') }}" />
                                @error('monto') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Comentarios</label>
                            <div class="col-sm-10 col-xs-6">
                                <textarea id="comentarios" name="comentarios" class="form-control">{{ old('comentarios') }}</textarea>
                                @error('comentarios') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href="{{ route('subproyectos.licitaciones.index', $subproyecto->id) }}" class="btn btn-default m-l-5">Cancelar</a>
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