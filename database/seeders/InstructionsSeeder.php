<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstructionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructionsInsertion =array([
            'title' => 'CUSTOMER INSTRUCTIONS / INSTRUCCIONES DE EL CLIENTE',
            'instruction' => 'Main Label Only/ Solo Marca',
        ],
        [
            'title' => 'CUSTOMER INSTRUCTIONS / INSTRUCCIONES DE EL CLIENTE',
            'instruction' => 'Main Label W/Size/Marca Con Talla',
        ],
        [
            'title' => 'SIZE TICKET / TALLA POR SEPARADO',
            'instruction' => 'Customer Provide/Cliente Provee',
        ],
        [
            'title' => 'SIZE TICKET / TALLA POR SEPARADO',
            'instruction' => 'Bluestar Provide / Bluestar Provee',
        ],
        [
            'title' => 'SIZE TICKET / TALLA POR SEPARADO',
            'instruction' => 'Middle Placement /Preparado',
        ],
        [
            'title' => 'SIZE TICKET / TALLA POR SEPARADO',
            'instruction' => 'On The Side / A Un Lado',
        ],
        [
            'title' => 'SIZE TICKET / TALLA POR SEPARADO',
            'instruction' => 'Care Label /Etiqueta De Contenidos',
        ],
        [
            'title' => 'HANG TAG /CARTON',
            'instruction' => 'String / Liston',
        ],
        [
            'title' => 'HANG TAG /CARTON',
            'instruction' => 'Plastic / Plastico',
        ],
        [
            'title' => 'HANG TAG /CARTON',
            'instruction' => 'Metal',
        ],
        [
            'title' => 'BAGGING / EMBOLSAR',
            'instruction' => 'Customer Provide Bags / Cliente Provee Bolsa',
        ],
        [
            'title' => 'BAGGING / EMBOLSAR',
            'instruction' => 'Bluestar Provee Bolsas',
        ],
        [
            'title' => 'BAGGING / EMBOLSAR',
            'instruction' => 'By Each Pc /Individual',
        ],
        [
            'title' => 'BAGGING / EMBOLSAR',
            'instruction' => 'Brake Down 6 By Pack / Paquete De 6 Piezas',
        ],
        [
            'title' => 'BAGGING / EMBOLSAR',
            'instruction' => 'Both Options /Ambas Opciones ',
        ],
        [
            'title' => 'HANGERS /GANCHOS',
            'instruction' => 'Customer Provide Hanger',
        ],
        [
            'title' => 'HANGERS /GANCHOS',
            'instruction' => 'Bluestar Provee Ganchos',
        ],
        [
            'title' => 'SIZE LABEL ON BAG / STIKER DE TALLA EN LA BOLSA',
            'instruction' => 'Customer Provide Size Sticker Label',
        ],
        [
            'title' => 'SIZE LABEL ON BAG / STIKER DE TALLA EN LA BOLSA',
            'instruction' => 'Bluestar Provee Stikers De Tallas',
        ],
        [
            'title' => 'PACKING / EMPAQUE',
            'instruction' => 'Repacking/ Reempacado',
        ],
        [
            'title' => 'PACKING / EMPAQUE',
            'instruction' => 'Same Box / Misma Caja',
        ],
        [
            'title' => 'PACKING / EMPAQUE',
            'instruction' => 'Full Tape Boxes',
        ],
        [
            'title' => 'SHIPPING METHOD / OPCIONES DE ENVIO',
            'instruction' => 'Loose Boxes /Cajas Sueltas',
        ],
        [
            'title' => 'SHIPPING METHOD / OPCIONES DE ENVIO',
            'instruction' => 'Pallets',
        ],
        [
            'title' => 'SHIPPING METHOD / OPCIONES DE ENVIO',
            'instruction' => 'UPS',
        ],
        [
            'title' => 'SHIPPING METHOD / OPCIONES DE ENVIO',
            'instruction' => 'Pick-Up By Customer/ Cliente Recoje',
        ],
        [
            'title' => 'SHIPPING METHOD / OPCIONES DE ENVIO',
            'instruction' => 'Other Company Pick-Up',
        ]);
        DB::table('instructions')->insert($instructionsInsertion);
    }
}
