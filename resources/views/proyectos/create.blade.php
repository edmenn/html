@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Presupuestos</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 
                Proyectos
            </a></li>
            <li class="active">Proyectos</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-60">
            <div class="box-header">
                <h3 class="box-title display-block text-center">AGREGAR PROYECTO</h3>
            </div>
            <div class="box-body">

                <form class="form-horizontal" action="{{ route('presupuestos.proyectos.store', $presupuesto->id) }}" method="POST">
                    @csrf
                    <div class="card-body card-padding">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Nombre</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="nombre" name="nombre" type="text" class="form-control" value="{{ old('nombre') }}" />
                                @error('nombre') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Descripción</label>
                            <div class="col-sm-10 col-xs-6">
                                <textarea id="descripcion" name="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
                                @error('descripcion') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Año Fiscal</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="anho_fiscal" name="anho_fiscal" type="text" class="form-control" value="{{ old('anho_fiscal') }}" />
                                @error('anho_fiscal') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Código</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="codigo" name="codigo" type="text" class="form-control" value="{{ old('codigo') }}" />
                                @error('codigo') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Departamento</label>
                            <div class="col-sm-10 col-xs-6">
                                <select id="departamento_id" name="departamento_id" class="form-control">
                                    @foreach ($departamentos as $item)
                                        <option value="{{ $item->id }}" @if($item->id==old('departamento_id')) selected @endif>
                                            {{ $item->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('departamento_id') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Usuario</label>
                            <div class="col-sm-10 col-xs-6">
                                <select id="user_id" name="user_id" class="form-control">
                                    @foreach ($usuarios as $item)
                                        <option value="{{ $item->id }}" @if($item->id==old('user_id')) selected @endif>
                                            {{ $item->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Costo</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="costo" name="costo" type="number" class="form-control" value="{{ old('costo') }}" />
                                @error('costo') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href="{{ route('presupuestos.proyectos.index', $presupuesto->id) }}" class="btn btn-default m-l-5">Cancelar</a>
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