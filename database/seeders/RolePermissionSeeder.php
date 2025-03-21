<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Crear permisos si no existen
        $permissions = [
            'roles.index', 'roles.create', 'roles.edit', 'roles.destroy',
            'users.index', 'users.create', 'users.edit', 'users.destroy',
            'ventas.index', 'productos.index', 'categorias.index', 'clientes.index',
            'compras.index',
            'ver_compras', // Permiso específico para cliente
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Crear roles si no existen
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']); // Asegúrate de crear el rol Super Admin
        $admin = Role::firstOrCreate(['name' => 'Administrador', 'guard_name' => 'web']);
        $vendedor = Role::firstOrCreate(['name' => 'Vendedor', 'guard_name' => 'web']);
        $cliente = Role::firstOrCreate(['name' => 'cliente', 'guard_name' => 'web']); // Rol cliente

        // Asignar todos los permisos al Super Admin
        $superAdmin->syncPermissions(Permission::all());

        // Asignar todos los permisos al Administrador
        $admin->syncPermissions(Permission::all());

        // Asignar permisos específicos al Vendedor
        $vendedor->syncPermissions(['ventas.index', 'productos.index']);

        // Asignar el permiso 'ver_compras' al cliente
        $cliente->givePermissionTo('ver_compras');

        echo "✅ Roles y permisos asignados correctamente.\n";
    }
}
