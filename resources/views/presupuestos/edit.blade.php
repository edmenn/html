@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Presupuestos</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 
                Presupuestos
            </a></li>
            <li class="active">Presupuestos</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-60">
            <div class="box-header">
                <h3 class="box-title display-block text-center">EDITAR PRESUPUESTO</h3>
            </div>
            <div class="box-body">

                <form class="form-horizontal" action="{{ route('presupuestos.update', $presupuesto->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body card-padding">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Año Fiscal</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="anho_fiscal" name="anho_fiscal" type="text" class="form-control" value="{{ old('anho_fiscal', $presupuesto->anho_fiscal) }}" />
                                @error('anho_fiscal') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Código</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="codigo" name="codigo" type="text" class="form-control" value="{{ old('codigo', $presupuesto->codigo) }}" />
                                @error('codigo') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Puerto</label>
                            <div class="col-sm-10 col-xs-6">
                                <select id="puerto_id" name="puerto_id" class="form-control">
                                    @foreach ($puertos as $item)
                                        <option value="{{ $item->id }}" @if($item->id==old('puerto_id', $presupuesto->puerto_id)) selected @endif>
                                            {{ $item->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('puerto_id') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Descripción</label>
                            <div class="col-sm-10 col-xs-6">
                                <textarea id="descripcion" name="descripcion" class="form-control">{{ old('descripcion', $presupuesto->descripcion) }}</textarea>
                                @error('descripcion') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Costo</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="costo" name="costo" type="number" class="form-control" value="{{ old('costo', $presupuesto->costo) }}" />
                                @error('costo') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Responsable</label>
                            <div class="col-sm-10 col-xs-6">
                                <select id="responsable_id" name="responsable_id" class="form-control">
                                    @foreach ($usuarios as $item)
                                        <option value="{{ $item->id }}" @if($item->id==old('responsable_id', $presupuesto->responsable_id)) selected @endif>
                                            {{ $item->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('responsable_id') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Estado</label>
                            <div class="col-sm-10 col-xs-6">
                                <select id="estado_id" name="estado_id" class="form-control">
                                    @foreach ($estados as $item)
                                        <option value="{{ $item->id }}" @if($item->id==old('estado_id', $presupuesto->estado_id)) selected @endif>
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
                                <a href="{{ route('presupuestos.index') }}" class="btn btn-default m-l-5">Cancelar</a>
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