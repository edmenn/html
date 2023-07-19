<header class="main-header">
    <!-- Logo -->
    <a href="/" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>G</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>GESTAPP</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <div class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </div>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout">
                            <i class="fa fa-sign-out"></i>
                            <span class="hidden-xs">Cerrar Sesión</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</header>

<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('images/user.png') }}" class="img-circle" alt="Administración - GESTAPP" />
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->nombre.' '.Auth::user()->apellido }}</p>
                <div class="info-online"><i class="fa fa-circle text-success"></i> Conectado</div>
            </div>
        </div>
        <!-- BEGIN sidebar menu: ROL ADMIN -->
        <ul class="sidebar-menu">
            <li class="header">MENÚ</li>
            <li class="@if (Request::url() == route('dashboard')) active @endif">
                <a href="/"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            <li class="header">Proyectos</li>
            <li class="@if (Request::url() == route('presupuestos.index')) active @endif">
                <a href="{{ route('presupuestos.index') }}"><i class="fa fa-list-alt"></i> <span>Presupuestos</span></a>
            </li>
            @if (Auth::user()->rol_id == 1) 
                @include('layouts.menu.admin')
            @endif
        </ul>
        <!-- END sidebar menu: ROL ADMIN -->        
    </section>
</aside>