<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Sidebar extends Component
{
    public array $menuItems = [];

    public function mount()
    {
        $this->menuItems = [
            [
                'label' => 'Inicio',
                'icon' => 'home-4-fill',
                'route' => 'home',
            ],
            [
                'label' => 'Usuarios',
                'icon' => 'account-circle-line',
                'route' => 'login',
                'children' => [
                    ['label' => 'Lista', 'route' => 'login'],
                    ['label' => 'Crear', 'route' => 'login'],
                ],
            ],
            [
            'label' => 'Catálogo',
            'icon'  => 'archive-line',     
            'route' => '',
            'children' => [
                ['label' => 'Artículos', 'route' => 'articles.index'],  
                ['label' => 'Fracciones', 'route' => 'fractions.index'],
            ],
            ],
            [
                'label' => 'Reportes',
                'icon' => 'pages-line',
                'route' => 'login',
            ],
            [
                'label' => 'Seguridad',
                'icon' => 'shield-keyhole-fill',
                'route' => 'permissions',
                'children' => [
                    ['label' => 'Usuarios', 'route' => 'permissions'],
                    ['label' => 'Roles', 'route' => 'roles'],
                    ['label' => 'Permisos', 'route' => 'permissions'],
                ],
            ],
            [
                'label' => 'Mantenimiento',
                'icon' => 'settings-5-fill',
                'route' => 'applications',
                'children' => [
                    ['label' => 'Aplicaciones', 'route' => 'applications'],
                    ['label' => 'Módulos', 'route' => 'modules'],
                    ['label' => 'Áreas', 'route' => 'maintenance-areas'],

                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.components.sidebar');
    }
}
