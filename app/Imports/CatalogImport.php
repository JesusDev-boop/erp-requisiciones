<?php

namespace App\Imports;

use App\Models\Supplier;
use App\Models\Area;
use App\Models\Project;
use App\Models\Unit;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CatalogImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows->skip(1) as $row) {

            // SUPPLIER
            if (!empty($row[1])) {
                Supplier::updateOrCreate(
                    ['rfc' => trim($row[2])],
                    [
                        'nombre' => trim($row[1]),
                        'razon_social' => trim($row[1]),
                        'contacto' => trim($row[3]),
                        'direccion' => trim($row[4]),
                        'activo' => 1
                    ]
                );
            }

            // AREA
            if (!empty($row[6])) {
                Area::firstOrCreate([
                    'nombre' => trim($row[6])
                ]);
            }

            // PROJECT
            if (!empty($row[7])) {
                Project::firstOrCreate([
                    'nombre' => trim($row[7])
                ]);
            }

            // UNIT
            if (!empty($row[10])) {
                Unit::firstOrCreate([
                    'nombre' => trim($row[10])
                ]);
            }
        }
    }
}