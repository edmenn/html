@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Documentos</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 
                Proyectos
            </a></li>
            <li class="active">Documentos</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-60">
            <div class="box-header">
                <h3 class="box-title display-block text-center">AGREGAR REGISTRO</h3>
            </div>
            <div class="box-body">

                <form class="form-horizontal" action="{{ route('documentosproyectos.store', $proyecto->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="card-body card-padding">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Tipo de Documento</label>
                            <div class="col-sm-10 col-xs-6">
                                <select id="tipo_documento_id" name="tipo_documento_id" class="form-control">
                                    @foreach ($tipos_documento as $item)
                                        <option value="{{ $item->id }}" @if($item->id==old('tipo_documento_id')) selected @endif>
                                            {{ $item->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo_documento_id') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Nombre</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="nombre" name="nombre" type="text" class="form-control" value="{{ old('nombre') }}" />
                                @error('nombre') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Archivo</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="archivo" name="archivo" type="file" class="form-control" value="{{ old('archivo') }}" />
                                @error('archivo') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href="{{ route('documentosproyectos.index', $proyecto->id) }}" class="btn btn-default m-l-5">Cancelar</a>
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