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
        $csv1->hash = 'bdb814873f3db7afcedbc0bf9f889105a1cac081';
        $csv1->csv = 'BDB814873F3DB7AF';
        $csv1->DNI = '20947867L';
        $csv1->nombre = 'Juanjo';
        $csv1->apellidos = 'Torres Roig';
        $csv1->correo = 'juanjo@gmail.com';
        $csv1->archivo = 'csv/WfLY13DdKrTicRdx3T956uXCQ2SrcNUUUuNBIepN.pdf';
        $csv1->save();
    }
}
