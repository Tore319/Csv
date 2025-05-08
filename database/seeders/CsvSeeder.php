<?php

namespace Database\Seeders;

use App\Models\Csv;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CsvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv1 = new Csv();
        $csv1->hash = 'dee004a8ac7d653e1e581513d0f8227833404e8a';
        $csv1->csv = 'DEE004A8AC7D653E';
        $csv1->DNI = '20947867L';
        $csv1->nombre = 'Juanjo';
        $csv1->apellidos = 'Torres Roig';
        $csv1->correo = 'juanjo@gmail.com';
        $csv1->archivo = 'csv/ghP5Rdj8vw4ktn3G7IBPcKhgXcUj2hdOSVD66YVL.pdf';
        $csv1->save();
    }
}
