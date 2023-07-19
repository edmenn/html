<li class="header">Financiero</li>
<li class="@if (Request::url() == route('ordenes_compra.index')) active @endif">
    <a href="{{ route('ordenes_compra.index') }}"><i class="fa fa-list-ul"></i> <span>Órdenes de compra</span></a>
</li>
<li class="header">Reportes</li>
<li class="@if (Request::url() == route('reportes.presupuesto')) active @endif">
    <a href="{{ route('reportes.presupuesto') }}"><i class="fa fa-list"></i> <span>Presupuesto</span></a>
</li>
<li class="@if (Request::url() == route('reportes.gasto')) active @endif">
    <a href="{{ route('reportes.gasto') }}"><i class="fa fa-list"></i> <span>Gasto</span></a>
</li>
<li class="@if (Request::url() == route('reportes.presupuestoRestante')) active @endif">
    <a href="{{ route('reportes.presupuestoRestante') }}"><i class="fa fa-list"></i> <span>Presupuesto Restante</span></a>
</li>
<li class="header">Gestión</li>
<li class="@if (Request::url() == route('proveedores.index')) active @endif">
    <a href="{{ route('proveedores.index') }}"><i class="fa fa-industry"></i> <span>Proveedores</span></a>
</li>
<li class="@if (Request::url() == route('localidades.index')) active @endif">
    <a href="{{ route('localidades.index') }}"><i class="fa fa-building"></i> <span>Localidades</span></a>
</li>
<li class="@if (Request::url() == route('departamentos.index')) active @endif">
    <a href="{{ route('departamentos.index') }}"><i class="fa fa-users"></i> <span>Departamentos</span></a>
</li>
<li class="@if (Request::url() == route('users.index')) active @endif">
    <a href="{{ route('users.index') }}"><i class="fa fa-user"></i> <span>Usuarios</span></a>
</li>