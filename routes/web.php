<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->middleware('guest');
Route::get('/login', \App\Livewire\Auth\LoginForm::class)->middleware('guest')->name('login');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/inicio', \App\Livewire\Home\Home::class)->name('home');

    Route::prefix('catalogos')->group(function () {

        // Catálogo → Artículos
        Route::get('articulos', \App\Livewire\Catalog\Articles\ArticleIndex::class)->name('articles.index');
        Route::get('articulos/crear', \App\Livewire\Catalog\Articles\ArticleForm::class)->name('articles.create');
        Route::get('articulos/{id}/editar', \App\Livewire\Catalog\Articles\ArticleForm::class)->name('articles.edit')->defaults('mode', 'edit');
        Route::get('articulos/{id}/mostrar', \App\Livewire\Catalog\Articles\ArticleForm::class)->name('articles.show')->defaults('mode', 'show');

    });

        // Catálogo → Fracciones
        Route::get('fracciones', \App\Livewire\Catalog\Fractions\FractionIndex::class)->name('fractions.index');
        Route::get('fracciones/crear', \App\Livewire\Catalog\Fractions\FractionForm::class)->name('fractions.create');
        Route::get('fracciones/{id}/editar', \App\Livewire\Catalog\Fractions\FractionForm::class)->name('fractions.edit')->defaults('mode', 'edit');
        Route::get('fracciones/{id}/mostrar', \App\Livewire\Catalog\Fractions\FractionForm::class)->name('fractions.show')->defaults('mode', 'show');


    Route::prefix('seguridad')->group(function () {

        /* Permissions Route*/
        Route::get('permisos', App\Livewire\Security\Permissions\PermissionsIndex::class)->name('permissions');
        Route::get('permisos/crear', App\Livewire\Security\Permissions\PermissionFormComponent::class)->name('permissions.create');
        Route::get('permisos/{id}/editar', App\Livewire\Security\Permissions\PermissionFormComponent::class)->name('permissions.edit')->defaults('mode', 'edit');
        Route::get('permisos/{id}/mostrar', App\Livewire\Security\Permissions\PermissionFormComponent::class)->name('permissions.show')->defaults('mode', 'show');

        /* Roles Route*/
        Route::get('roles', \App\Livewire\Security\Roles\RolesIndex::class)->name('roles');
        Route::get('roles/crear', \App\Livewire\Security\Roles\RoleFormComponent::class)->name('roles.create');
        Route::get('roles/{id}/editar', \App\Livewire\Security\Roles\RoleFormComponent::class)->name('roles.edit')->defaults('mode', 'edit');
        Route::get('roles/{id}/mostrar', \App\Livewire\Security\Roles\RoleFormComponent::class)->name('roles.show')->defaults('mode', 'show');
    });

    Route::prefix('mantenimiento')->group(function () {

            /*Applications Routes*/
            Route::get('aplicaciones', \App\Livewire\Maintenance\Catalogs\ApplicationsIndex::class)->name('applications');
            Route::get('aplicaciones/crear', \App\Livewire\Maintenance\Catalogs\ApplicationFormComponent::class)->name('applications.create');
            Route::get('aplicaciones/{id}/editar', \App\Livewire\Maintenance\Catalogs\ApplicationFormComponent::class)->name('applications.edit')->defaults('mode', 'edit');
            Route::get('aplicaciones/{id}/mostrar', \App\Livewire\Maintenance\Catalogs\ApplicationFormComponent::class)->name('applications.show')->defaults('mode', 'show');

            Route::get('modulos', \App\Livewire\Maintenance\Catalogs\ModulesIndex::class)->name('modules');
            Route::get('modulos/crear', \App\Livewire\Maintenance\Catalogs\ModuleFormComponent::class)->name('modules.create');
            Route::get('modulos/{id}/editar', \App\Livewire\Maintenance\Catalogs\ModuleFormComponent::class)->name('modules.edit')->defaults('mode', 'edit');
            Route::get('modulos/{id}/mostrar', \App\Livewire\Maintenance\Catalogs\ModuleFormComponent::class)->name('modules.show')->defaults('mode', 'show');


            Route::get('mantenimiento-areas', \App\Livewire\Maintenance\Catalogs\Areas\AreaIndex::class)->name('maintenance-areas');
            Route::get('mantenimiento-areas/crear', \App\Livewire\Maintenance\Catalogs\Areas\AreaForm::class)->name('maintenance-areas.create');
            Route::get('mantenimiento-areas/{id}/editar', \App\Livewire\Maintenance\Catalogs\Areas\AreaForm::class)->name('maintenance-areas.edit')->defaults('mode', 'edit');
            Route::get('mantenimiento-areas/{id}/mostrar', \App\Livewire\Maintenance\Catalogs\Areas\AreaForm::class)->name('maintenance-areas.show')->defaults('mode', 'show');       
         });
        
});


