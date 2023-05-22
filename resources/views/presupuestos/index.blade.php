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
        <div class="box">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">Listado de Presupuestos</h3>
                </div>
                <div class="pull-right">
                    <a href="{{ route('presupuestos.create') }}" class="btn btn-primary">Agregar Presupuesto</a>
                </div>
            </div>
            <div class="box-body table-responsive">
                <div id="tabla_wrapper" class="dataTables_wrapper no-footer">
                    <form id="fo1" method="GET">
                    @csrf
                    <div class="dataTables_length" id="mostrar">
                        <label>Mostrar <select name="mostrar" aria-controls="tabla" onChange="document.getElementById('fo1').submit();">
                            @foreach ([10, 25, 50, 100] as $item)
                                <option value="{{$item}}" {{ $item == $mostrar ? "selected" : null }}>{{$item}}</option>
                            @endforeach
                        </select> registros</label>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-3">
                            <select id="localidad" name="localidad" class="form-control" onChange="document.getElementById('fo1').submit();">
                                <option value="">Localidad (todos)</option>
                                @foreach ($localidades as $item)
                                    <option value="{{ $item->id }}" {{ $item->id==$localidad? 'selected' : null }}>{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="departamento" name="departamento" class="form-control" onChange="document.getElementById('fo1').submit();">
                                <option value="">Departamento (todos)</option>
                                @foreach ($departamentos as $item)
                                    <option value="{{ $item->id }}" {{ $item->id==$departamento? 'selected' : null }}>{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="anho_fiscal" name="anho_fiscal" class="form-control" onChange="document.getElementById('fo1').submit();">
                                <option value="">Año fiscal (todos)</option>
                                @foreach ($anho_fiscales as $item)
                                    <option value="{{ $item }}" {{ $item==$anho_fiscal? 'selected' : null }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="estado" name="estado" class="form-control" onChange="document.getElementById('fo1').submit();">
                                <option value="">Estado (todos)</option>
                                @foreach ($estados as $item)
                                    <option value="{{ $item->id }}" {{ $item->id==$estado? 'selected' : null }}>{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    </form>
                    <table id="tabla" class="table table-bordered table-hover m-t-10">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Código</th>
                                <th>Localidad</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Tipo</th>
                                <th>Costo</th>
                                <th>Departamento</th>
                                <th>Responsable</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 0 @endphp
                            @foreach ($presupuestos as $item)    
                            <tr>
                                @php ++$index @endphp
                                <td>{{ ($presupuestos->currentPage() -1) * $mostrar + $index }}</td>
                                <td>{{ $item->anho_fiscal .'-'. sprintf("%03d", $item->codigo) }}</td>
                                <td>{{ $item->localidad->nombre }}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->descripcion }}</td>
                                <td>{{ $item->tipo }}</td>
                                <td>{{ 'Gs. '.number_format($item->costo,0,',','.') }}</td>
                                <td>{{ $item->departamento->nombre }}</td>
                                <td>{{ $item->responsable->nombre.' '.$item->responsable->apellido }}</td>
                                <td>{{ $item->estado->nombre }}</td>
                                <td>
                                    <table>
                                        <tbody><tr>
                                            <td class="text-center"><a href="{{ route('presupuestos.proyectos.index', $item->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i> </a></td>
                                            <td class="text-center"><a href="{{ route('presupuestos.edit', $item->id) }}" class="btn btn-warning"><i class="fa fa-pencil"></i> </a></td>
                                            <td class="text-center"><button onclick="eliminateHandle({{ $item->id }})" class="btn btn-danger"><i class="fa fa-trash"></i> </button></td>
                                        </tr>
                                        {{-- PARA ROL DE ADMIN Y JEFE DEPARTAMENTAL (del departamento del presupuesto) --}}
                                        @if ( Auth::user()->rol_id === 1 OR (Auth::user()->rol_id === 2 && Auth::user()->departamento_id===$item->departamento_id) )
                                        </tr>
                                            <td colspan="3" class="text-center">
                                                <a href="{{ route('presupuestos.editEstado', $item->id) }}" class="btn btn-default">Modificar Estado</a>
                                            </td>
                                        <tr>    
                                        @endif
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $presupuestos->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
function eliminateHandle(id){
    let text = "Está seguro que desea eliminar el presupuesto?";
    if (confirm(text) == true) {
        try {
            let requestBody = { _token: '{{ csrf_token() }}' }
            fetch("/presupuestos/"+id, 
                { method: "DELETE", headers: new Headers( {"Content-Type": "application/json"} ),
                body: JSON.stringify( requestBody )
            })
            .then((response) => response.json())
            .then((data) => {
                if(data.status == "success"){
                    location.href = "{{ route('presupuestos.index') }}";
                }else if(data.message){
                    alert(data.message);
                }
            });
        } catch (error) {
            alert("Advertencia: Ocurrio un error intentado resolver la solicitud, por favor complete todos los campos o recargue de vuelta la pagina");
            console.log(error);
        }
    }
}

</script>
@endpush