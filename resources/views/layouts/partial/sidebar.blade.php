@php
    // No es estrictamente necesario refrescar al usuario con ->fresh();
    // pero si quieres asegurarte de tener los roles/permisos cargados, puedes dejarlo.
    $usuario = auth()->user();
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('/home') }}" class="brand-link">
        <img src="{{ asset('backend/dist/img/logo_audysoft.png') }}"
             alt="Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Audysoftw</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                {{-- Dashboard --}}
                @can('ver dashboard')
                    <li class="nav-item">
                        <a href="{{ url('/home') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>Panel De Control</p>
                        </a>
                    </li>
                @endcan

                {{-- Sliders --}}
                <!-- @can('ver sliders')
                    <li class="nav-item">
                        <a href="{{ route('sliders.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-sliders-h"></i>
                            <p>Sliders</p>
                        </a>
                    </li>
                @endcan -->

                {{-- Acceso --}}
                @canany(['ver usuarios', 'ver roles', 'ver permisos', 'ver empleados'])
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-lock"></i>
                            <p>Acceso<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('ver usuarios')
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-user"></i>
                                        <p>Usuarios</p>
                                    </a>
                                </li>
                            @endcan

                            @can('ver empleados')
                                <li class="nav-item">
                                    <a href="{{ route('empleados.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>Empleados</p>
                                    </a>
                                </li>
                            @endcan

                            @can('ver roles')
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-tasks"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                            @endcan

                            <!-- @can('ver permisos')
                                <li class="nav-item">
                                    <a href="{{ route('permissions.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-key"></i>
                                        <p>Permisos</p>
                                    </a>
                                </li>
                            @endcan -->
                        </ul>
                    </li>
                @endcanany

                {{-- Inventario --}}
                @canany(['ver categorias', 'ver productos', 'ver proveedores', 'ver clientes', 'ver ventas', 'ver compras'])
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Inventario<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('ver categorias')
                                <li class="nav-item">
                                    <a href="{{ route('categorias.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-tags"></i>
                                        <p>Categorías</p>
                                    </a>
                                </li>
                            @endcan

                            @can('ver proveedores')
                                <li class="nav-item">
                                    <a href="{{ route('proveedores.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-truck"></i>
                                        <p>Proveedores</p>
                                    </a>
                                </li>
                            @endcan

                            @can('ver clientes')
                                <li class="nav-item">
                                    <a href="{{ route('clientes.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>Clientes</p>
                                    </a>
                                </li>
                            @endcan

                            @can('ver productos')
                                <li class="nav-item">
                                    <a href="{{ route('productos.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-box"></i>
                                        <p>Productos</p>
                                    </a>
                                </li>
                            @endcan

                            @can('ver compras')
                                <li class="nav-item">
                                    <a href="{{ route('compras.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-shopping-cart"></i>
                                        <p>Compras</p>
                                    </a>
                                </li>
                            @endcan

                            @can('ver ventas')
                                <li class="nav-item">
                                    <a href="{{ route('ventas.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-shopping-cart"></i>
                                        <p>Ventas</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

            </ul>
        </nav>
    </div>
</aside>
