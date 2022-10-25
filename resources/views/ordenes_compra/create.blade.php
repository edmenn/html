@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Órdenes de compra</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 
                Órdenes de compra
            </a></li>
            <li class="active">Órdenes de compra</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-60">
            <div class="box-header">
                <h3 class="box-title display-block text-center">AGREGAR REGISTRO</h3>
            </div>
            <div class="box-body">

                <form class="form-horizontal" action="{{ route('ordenes_compra.store') }}" method="POST">
                    @csrf
                    
                    <div class="card-body card-padding">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Concepto</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="concepto" name="concepto" type="text" class="form-control" value="{{ old('concepto') }}" />
                                @error('concepto') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

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
                            <label class="col-sm-2 col-xs-6 control-label">Fecha de factura</label>
                            <div class="col-sm-10 col-xs-6">
                                <input type="text" id="fecha_factura" name="fecha_factura" class="form-control" placeholder="dd/mm/yyyy (Ejemplo 27/05/2022)" value="{{ old('fecha_factura') }}" />
                                @error('fecha_factura') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Número de factura</label>
                            <div class="col-sm-10 col-xs-6">
                                <input type="text" id="numero_factura" name="numero_factura" class="form-control" value="{{ old('numero_factura') }}" />
                                @error('numero_factura') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Monto</label>
                            <div class="col-sm-10 col-xs-6">
                                <input type="number" id="monto" name="monto" class="form-control" value="{{ old('monto') }}" />
                                @error('monto') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">IVA (en %)</label>
                            <div class="col-sm-10 col-xs-6">
                                <input type="number" id="iva" name="iva" class="form-control" value="{{ old('iva') }}" />
                                @error('iva') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Monto IVA</label>
                            <div class="col-sm-10 col-xs-6">
                                <input type="number" id="monto_iva" name="monto_iva" class="form-control" value="{{ old('monto_iva') }}" />
                                @error('monto_iva') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href="{{ route('ordenes_compra.index') }}" class="btn btn-default m-l-5">Cancelar</a>
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