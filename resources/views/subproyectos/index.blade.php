@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Subproyectos</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 
                Proyectos
            </a></li>
            <li class="active">Subproyectos</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">Listado de subproyectos del proyecto 
                        <a href="{{ route('presupuestos.proyectos.index', $proyecto->presupuesto->id) }}">{{ $proyecto->nombre }}</a>
                    </h3>
                </div>
                <div class="pull-right">
                    <a href="{{ route('proyectos.subproyectos.create', $proyecto->id) }}" class="btn btn-primary">Agregar subproyecto</a>
                </div>
            </div>
            <div class="box-body table-responsive">
                <table id="tabla" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Código</th>
                            <th>Costo</th>
                            <th>Estado</th>
                            <th>Contratado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subproyectos as $item)    
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->descripcion }}</td>
                            <td>{{ $item->codigo }}</td>
                            <td>{{ number_format($item->costo,0,',','.') }}</td>
                            <td>{{ $item->estado->nombre }}</td>
                            <td>{{ number_format($item->contratado,0,',','.') }}</td>
                            <td>
                                <table>
                                    <tbody><tr>
                                        <td class="text-center"><a href="{{ route('proyectos.subproyectos.edit', [$proyecto->id, $item->id]) }}" class="btn btn-warning"><i class="fa fa-pencil"></i> </a></td>
                                        <td class="text-center"><button onclick="eliminateHandle({{ $item->id }})" class="btn btn-danger"><i class="fa fa-trash"></i> </button></td>
                                    </tr>
                                    {{-- PARA ROL DE ADMIN Y JEFE DEPARTAMENTAL --}}
                                    @if (in_array(Auth::user()->rol_id, [1,2]))
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <a href="{{ route('proyectos.subproyectos.editEstado', [$proyecto->id, $item->id]) }}" class="btn btn-default">Modificar Estado</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <a href="{{ route('cancelacionessubproyectos.index', $item->id) }}" class="btn btn-warning">Montos cancelados</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <a href="{{ route('comentariossubproyectos.index', $item->id) }}" class="btn btn-info">Comentarios</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <a href="{{ route('documentossubproyectos.index', $item->id) }}" class="btn btn-primary">Documentos</a>
                                        </td>
                                    </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
function eliminateHandle(id){
    let text = "Está seguro que desea eliminar el subproyecto?";
    if (confirm(text) == true) {
        try {
            let requestBody = { _token: '{{ csrf_token() }}' }
            fetch("/proyectos/{{ $proyecto->id }}/subproyectos/"+id, 
                { method: "DELETE", headers: new Headers( {"Content-Type": "application/json"} ),
                body: JSON.stringify( requestBody )
            })
            .then((response) => response.json())
            .then((data) => {
                if(data.status == "success"){
                    location.href = "{{ route('proyectos.subproyectos.index', $proyecto->id) }}";
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
document.addEventListener('DOMContentLoaded', function () {
    let table = new DataTable('#tabla', {
        language: {
            "decimal":        ",",
            "emptyTable":     "No hay datos disponibles en la tabla",
            "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
            "infoFiltered":   "(filtrado de _MAX_ registros totales)",
            "infoPostFix":    "",
            "thousands":      ".",
            "lengthMenu":     "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing":     "",
            "search":         "Buscar:",
            "zeroRecords":    "No se encontraron registros coincidentes",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": activar para orden ascendente",
                "sortDescending": ": activar para orden descendente"
            }
        }
    });
});
</script>
@endpush