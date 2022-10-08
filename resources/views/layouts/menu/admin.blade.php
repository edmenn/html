<li class="header">Gestión</li>
<li class="@if (Request::url() == route('proveedores.index')) active @endif">
    <a href="{{ route('proveedores.index') }}"><i class="fa fa-industry"></i> <span>Proveedores</span></a>
</li>
<li class="@if (Request::url() == route('puertos.index')) active @endif">
    <a href="{{ route('puertos.index') }}"><i class="fa fa-ship"></i> <span>Puertos</span></a>
</li>
<li class="@if (Request::url() == route('users.index')) active @endif">
    <a href="{{ route('users.index') }}"><i class="fa fa-user"></i> <span>Usuarios</span></a>
</li>