@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Usuarios</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 
                Usuarios
            </a></li>
            <li class="active">Usuarios</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-60">
            <div class="box-header">
                <h3 class="box-title display-block text-center">AGREGAR USUARIO</h3>
            </div>
            <div class="box-body">

                <form class="form-horizontal" action="{{ route('users.store') }}" method="POST">
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
                            <label class="col-sm-2 col-xs-6 control-label">Apellido</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="apellido" name="apellido" type="text" class="form-control" value="{{ old('apellido') }}" />
                                @error('apellido') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Cédula</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="cedula" name="cedula" type="text" class="form-control" value="{{ old('cedula') }}" />
                                @error('cedula') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Rol</label>
                            <div class="col-sm-10 col-xs-6">
                                <select id="rol_id" name="rol_id" class="form-control">
                                    @foreach ($roles as $item)
                                        <option value="{{ $item->id }}" @if($item->id==old('rol_id')) selected @endif>
                                            {{ $item->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rol_id') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Email</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="email" name="email" type="email" class="form-control" value="{{ old('email') }}" />
                                @error('email') <div class="text-red">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-6 control-label">Password</label>
                            <div class="col-sm-10 col-xs-6">
                                <input id="password" name="password" type="password" class="form-control" value="{{ old('password') }}" />
                                @error('password') <div class="text-red">{{ $message }}</div> @enderror
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
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href="{{ route('users.index') }}" class="btn btn-default m-l-5">Cancelar</a>
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