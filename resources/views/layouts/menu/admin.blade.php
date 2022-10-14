<li class="header">Gestión</li>
<li class="@if (Request::url() == route('proveedores.index')) active @endif">
    <a href="{{ route('proveedores.index') }}"><i class="fa fa-industry"></i> <span>Proveedores</span></a>
</li>
<li class="@if (Request::url() == route('localidades.index')) active @endif">
    <a href="{{ route('localidades.index') }}"><i class="fa fa-building"></i> <span>Localidades</span></a>
</li>
<li class="@if (Request::url() == route('users.index')) active @endif">
    <a href="{{ route('users.index') }}"><i class="fa fa-user"></i> <span>Usuarios</span></a>
</li>