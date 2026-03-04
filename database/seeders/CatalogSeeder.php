<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Models\Project;
use App\Models\Unit;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // AREAS
        // =========================
        $areas = [
            'LAB. ESTIMULACION',
            'LAB. FLUIDOS',
            'UHSE',
            'TI',
            'MANTENIMIENTO',
            'LOGISTICA',
            'GESTION VEHICULAR',
            'ESTIMACIONES',
            'CONTRATO',
            'MARKETING',
            'COORDINACION',
            'CONTABILIDAD',
            'OPERACIONES',
            'MATERIAL QUIMICO',
            'TESTING',
            'TUBERIA FLEXIBLE'
        ];

        foreach ($areas as $area) {
            Area::updateOrCreate([
                'nombre' => $area
            ]);
        }

        // =========================
        // PROYECTOS
        // =========================
        $projects = [
            'MARINA',
            'TERRESTRE',
            'FLUIDOS',
            'GENERAL'
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate([
                'nombre' => $project
            ]);
        }

        // =========================
        // UNIDADES
        // =========================
        $units = [
            'SERVICIOS','EQUIPO','MOVIMIENTO LOCAL','MOVIMIENTO INTERNO',
            'MOVIMIENTO LATERAL','FLETE EN FALSO','ESTADIA','MES','DIAS',
            'M3','SACOS','CUBETAS','TAMBOR','TOTEM','TONELADAS','KG',
            'CAJAS','LITROS','JORNADA','MEDIA JORNADA','HORAS','FLETE',
            'PAQ.','PIEZA','METRO','M2','LOTE','RENTA DIARIA','GALONES'
        ];

        foreach ($units as $unit) {
            Unit::updateOrCreate([
                'nombre' => $unit
            ]);
        }
    }
}