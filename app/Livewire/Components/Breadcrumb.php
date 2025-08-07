<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Breadcrumb extends Component
{
    public array $breadcrumbs = [];
    public string $currentRoute;

    public function mount()
    {
        $this->currentRoute = Route::currentRouteName() ?: '';
        $this->generateBreadcrumbs();
    }

    private function generateBreadcrumbs(): void
    {
        // Empezamos siempre con “Inicio”
        $this->breadcrumbs[] = [
            'title'  => 'Inicio',
            'url'    => route('home'),
            'active' => false,
        ];

        $parts     = explode('.', $this->currentRoute);
        $accumPath = '';

        foreach ($parts as $i => $part) {
            // Omitimos segmentos vacíos e “index”
            if ($part === '' || $part === 'index') {
                continue;
            }

            // Construimos la ruta acumulada
            $accumPath = $accumPath === '' ? $part : "{$accumPath}.{$part}";

            // Traducimos el título
            $title = $this->getCustomTitle($part);

            // ¿Es este el último segmento?
            $isLast = $i === array_key_last($parts);

            // Si no es el último y no es create/edit/show,
            // generamos un enlace a la ruta .index
            if (! $isLast && ! in_array($part, ['create', 'edit', 'show'], true)) {
                $routeName = "{$part}.index";
            } else {
                // En create/show/edit usamos la ruta acumulada
                $routeName = $accumPath;
            }

            try {
                $url = route($routeName);
            } catch (\Exception $e) {
                $url = '#';
            }

            $this->breadcrumbs[] = [
                'title'  => $title,
                'url'    => $url,
                'active' => $isLast,
            ];
        }
    }

    private function getCustomTitle(string $routePart): string
    {
        $map = [
            'security'   => 'Seguridad',
            'permissions'=> 'Permisos',
            'roles'      => 'Roles',
            'users'      => 'Usuarios',
            'catalog'    => 'Catálogo',
            'articles'   => 'Artículos',
            'fractions'  => 'Fracciones',
            'maintenance-areas' => 'mantenimiento-areas',
            'create'     => 'Crear',
            'edit'       => 'Editar',
            'show'       => 'Ver',
        ];

        return $map[$routePart] ?? ucfirst($routePart);
    }

    public function render()
    {
        return view('livewire.components.breadcrumb');
    }
}
