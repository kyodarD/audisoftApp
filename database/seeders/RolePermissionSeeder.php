<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Secciones del sistema
        $secciones = [
            'home',
            'sliders',
            'usuarios',
            'roles',
            'permisos',
            'categorias',
            'productos',
            'proveedores',
            'clientes',
            'ventas',
            'compras',
            'empleados',
        ];

        // Acciones comunes
        $acciones = ['ver', 'crear', 'editar', 'mostrar'];

        // Arreglo para gestionar permisos agrupados por sección
        $permisosPorSeccion = [];

        foreach ($secciones as $seccion) {
            foreach ($acciones as $accion) {
                $nombrePermiso = "{$accion} {$seccion}";

                $permiso = Permission::firstOrCreate([
                    'name' => $nombrePermiso,
                    'guard_name' => 'web',
                ]);

                $permisosPorSeccion[$seccion][] = $permiso->name;
            }
        }

        // Crear roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $cliente    = Role::firstOrCreate(['name' => 'cliente']);
        $vendedor   = Role::firstOrCreate(['name' => 'vendedor']);

        // Asignar todos los permisos al super admin
        $superAdmin->syncPermissions(Permission::all());

        // Asignar solo permisos relacionados con ventas al cliente
        $cliente->syncPermissions($permisosPorSeccion['ventas'] ?? []);

        // Asignar permisos relacionados con ventas y compras al vendedor
        $vendedor->syncPermissions(array_merge(
            $permisosPorSeccion['ventas'] ?? [],
            $permisosPorSeccion['compras'] ?? []
        ));

        $this->command->info('Roles y permisos (ver, crear, editar, mostrar) generados correctamente.');
    }
}
