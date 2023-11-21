<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesSeeder extends Seeder
{
    const CATEGORIA_PERMISSIONS = [
        'categoria.show',
        'categoria.create',
        'categoria.update',
        'categoria.details',
        'categoria.delete',
    ];

    const SUB_CATEGORIA_PERMISSIONS = [
        'subcategoria.show',
        'subcategoria.create',
        'subcategoria.update',
        'subcategoria.delete',
    ];

    const UNIDAD_PERMISSIONS = [
        'unidad.show',
        'unidad.create',
        'unidad.update',
        'unidad.delete',
    ];

    const ALMACEN_PERMISSIONS = [
        'almacen.show',
        'almacen.create',
        'almacen.update',
        'almacen.delete',
        'almacen.surtir',
    ];

    const CAJA_PERMISSIONS = [
        'caja.show',
        'caja.create',
        'caja.update',
        'caja.delete',
        'caja.abrir',
        'caja.cerrar',
    ];

    const PRODUCTO_PERMISSIONS = [
        'producto.show',
        'producto.create',
        'producto.update',
        'producto.delete',
    ];

    const ARTICULO_PERMISSIONS = [
        'articulo.show',
        'articulo.create',
        'articulo.update',
        'articulo.delete',
        'articulo.updateImage',
        'articulo.updateStock',
    ];

    const CORTES_PERMISSIONS = [
        'corte.show',
        'corte.create',
        'corte.update',
        'corte.delete'
    ];

    const EXISTENCIAS_PERMISSIONS = [
        'existencia.show',
        'existencia.create',
        'existencia.update',
        'existencia.delete',
    ];

    const ROTACIONES_PERMISSIONS = [
        'rotacion.show',
        'rotacion.create',
        'rotacion.update',
        'rotacion.delete',
    ];

    const VENTA_PERMISSIONS = [
        'venta.show',
        'venta.create',
        'venta.update',
        'venta.delete',
        'venta.delete',
    ];
    const REFUND_PERMISSIONS = [
        'refund.show_any',
        'refund.show',
        'refund.create',
        'refund.update',
        'refund.delete',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        //

        $this->createPermissions(...$this->allPermissions());

        $this->createRole('Administrador')->givePermissionTo([
            ...$this->allPermissions()
        ]);
        $this->createRole('Desarrollador')->givePermissionTo([
            ...$this->allPermissions()
        ]);

        $this->createRole('Empleado')->givePermissionTo([
            ...$this->allPermissions()
        ]);
    }

    private function createPermission(string $name): Permission
    {
        return Permission::create(['name' => $name]);
    }

    private function createPermissions(string ...$names): void
    {
        foreach ($names as $name) {
            $this->createPermission($name);
        }
    }

    private function createRole(string $name): Role
    {
        return Role::create(['name' => $name]);
    }

    private function allPermissions(): array
    {
        return [
            ...self::CATEGORIA_PERMISSIONS,
            ...self::SUB_CATEGORIA_PERMISSIONS,
            ...self::UNIDAD_PERMISSIONS,
            ...self::ALMACEN_PERMISSIONS,
            ...self::CAJA_PERMISSIONS,
            ...self::PRODUCTO_PERMISSIONS,
            ...self::ARTICULO_PERMISSIONS,
            ...self::ROTACIONES_PERMISSIONS
        ];
    }
}
