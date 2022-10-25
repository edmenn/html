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
        <div class="box">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">Órdenes de compra</h3>
                </div>
                <div class="pull-right">
                    <a href="{{ route('ordenes_compra.create') }}" class="btn btn-primary">Agregar orden de compra</a>
                </div>
            </div>
            <div class="box-body table-responsive">
                <table id="tabla" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Concepto</th>
                            <th>Proveedor</th>
                            <th>Fecha factura</th>
                            <th>Número de factura</th>
                            <th>Monto</th>
                            <th>IVA</th>
                            <th>Monto</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ordenes_compra as $item)    
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->concepto }}</td>
                            <td>{{ $item->proveedor->nombre_fantasia }}</td>
                            <td>{{ date('d/m/Y', strtotime($item->fecha_factura)) }}</td>
                            <td>{{ $item->numero_factura }}</td>
                            <td>{{ number_format($item->monto,0,',','.') }}</td>
                            <td>{{ $item->iva . '%' }}</td>
                            <td>{{ number_format($item->monto_iva,0,',','.') }}</td>
                            <td>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td><a href="{{ route('ordenes_compra.edit', $item->id) }}" class="btn btn-warning"><i class="fa fa-pencil"></i> </a></td>
                                        <td><button onclick="eliminateHandle({{ $item->id }})" class="btn btn-danger"><i class="fa fa-trash"></i> </button></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><a href="{{ route('documentos.ordenes_compra.index', $item->id) }}" class="btn btn-primary">Documentos</a></td>
                                    </tr>
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
    let text = "Está seguro que desea eliminar el registro?";
    if (confirm(text) == true) {
        try {
            let requestBody = { _token: '{{ csrf_token() }}' }
            fetch("/ordenes_compra/"+id, 
                { method: "DELETE", headers: new Headers( {"Content-Type": "application/json"} ),
                body: JSON.stringify( requestBody )
            })
            .then((response) => response.json())
            .then((data) => {
                if(data.status == "success"){
                    location.href = "{{ route('ordenes_compra.index') }}";
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