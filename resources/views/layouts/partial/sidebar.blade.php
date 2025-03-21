<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('/home') }}" class="brand-link">
        <img src="{{ asset('backend/dist/img/logo_audysoft.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Audysoftw</span>
    </a>
    <div class="sidebar">
        @php
            $user = auth()->user();
            $isCliente = $user->hasRole('cliente'); // Verifica si es cliente
            $isSuperAdmin = $user->hasRole('Super Admin'); // Verifica si es Super Admin
        @endphp
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- Panel de Control -->
                <li class="nav-item">
                    <a href="{{ url('/home') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Panel De Control</p>
                    </a>
                </li>

                <!-- Mostrar solo si el usuario es Super Admin -->
                @if($isSuperAdmin)
                    @include('layouts.partials.sidebar-full')
                @else
                    <!-- Mostrar solo la opción de Compras para el rol cliente -->
                    @if($isCliente)
                        <li class="nav-item">
                            <a href="{{ route('compras.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>Compras</p>
                            </a>
                        </li>
                    @else
                        <!-- Si el usuario NO es cliente, mostrar las demás opciones -->
                        @can('Slider.index')
                        <li class="nav-item">
                            <a href="{{ route('sliders.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-sliders-h"></i>
                                <p>Sliders</p>
                            </a>
                        </li>
                        @endcan
                        
                        <!-- Acceso -->
                        @if($user->canAny(['users.index', 'roles.index', 'permissions.index', 'empleados.index']))
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-lock"></i>
                                <p>Acceso<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('users.index')
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-user"></i>
                                        <p>Usuarios</p>
                                    </a>
                                </li>
                                @endcan
                                
                                <!-- Nuevo item para empleados -->
                                @can('empleados.index')
                                <li class="nav-item">
                                    <a href="{{ route('empleados.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>Empleados</p>
                                    </a>
                                </li>
                                @endcan

                                @can('roles.index')
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-tasks"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                                @endcan
                                @can('permissions.index')
                                <li class="nav-item">
                                    <a href="{{ route('permissions.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-key"></i>
                                        <p>Permisos</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endif

                        <!-- Inventario -->
                        @if($user->canAny(['categorias.index', 'productos.index', 'proveedores.index', 'clientes.index', 'ventas.index']))
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-box"></i> <!-- Ícono para Inventario -->
                                <p>Inventario<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('categorias.index')
                                <li class="nav-item">
                                    <a href="{{ route('categorias.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-tags"></i>
                                        <p>Categorías</p>
                                    </a>
                                </li>
                                @endcan
                                @can('proveedores.index')
                                <li class="nav-item">
                                    <a href="{{ route('proveedores.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-truck"></i>
                                        <p>Proveedores</p>
                                    </a>
                                </li>
                                @endcan
                                @can('clientes.index')
                                <li class="nav-item">
                                    <a href="{{ route('clientes.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>Clientes</p>
                                    </a>
                                </li>
                                @endcan
                                @can('productos.index')
                                <li class="nav-item">
                                    <a href="{{ route('productos.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-box"></i>
                                        <p>Productos</p>
                                    </a>
                                </li>
                                @endcan
                                @can('compras.index')
                                <li class="nav-item">
                                    <a href="{{ route('compras.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-shopping-cart"></i>
                                        <p>Compras</p>
                                    </a>
                                </li>
                                @endcan
                                @can('ventas.index')
                                <li class="nav-item">
                                    <a href="{{ route('ventas.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-shopping-cart"></i>
                                        <p>Ventas</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endif
                    @endif
                @endif
            </ul>
        </nav>
    </div>
</aside>
