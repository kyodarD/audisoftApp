<?php

namespace App\Traits;

trait HasPermissionMiddleware
{
    public function applyPermissionMiddleware(string $seccion)
    {
        $this->middleware("can:ver $seccion")->only('index');
        $this->middleware("can:mostrar $seccion")->only('show');
        $this->middleware("can:crear $seccion")->only(['create', 'store']);
        $this->middleware("can:editar $seccion")->only(['edit', 'update', 'destroy']);
    }
}
