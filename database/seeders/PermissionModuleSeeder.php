<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\CustomPermission;
use App\Models\PermissionModule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appCrm = Application::create(['name' => 'CRM', 'slug' => 'crm']);
        $appPrincipal = Application::create(['name' => 'App Principal', 'slug' => 'app']);

        $modules = [];

        for($i=0; $i<100; $i++ ){
            array_push($modules, ['name' => 'Modulo '.$i, 'slug' => 'modulo-'.$i, 'application_id' => $appPrincipal->id]);
        }

        foreach ($modules as $mod) {
            $module = PermissionModule::create($mod);

            CustomPermission::create([
                'name' => "{$mod['slug']}.accesar",
                'permission_module_id' => $module->id
            ]);

            CustomPermission::create([
                'name' => "{$mod['slug']}.crear",
                'permission_module_id' => $module->id
            ]);

            CustomPermission::create([
                'name' => "{$mod['slug']}.editar",
                'permission_module_id' => $module->id
            ]);

            CustomPermission::create([
                'name' => "{$mod['slug']}.mostrar",
                'permission_module_id' => $module->id
            ]);
            CustomPermission::create([
                'name' => "{$mod['slug']}.eliminar",
                'permission_module_id' => $module->id
            ]);
        }
    }
}
