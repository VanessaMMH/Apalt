<?php

namespace App\Imports;

use App\TomaPedidos;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use DateTime;
use Carbon\Carbon;

class TomaPedidosImport implements ToModel, WithStartRow
{
 /**
     * @return int
     */
    public function startRow(): int
    {
        return 5;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function transformDate($value, $format = 'Y-m-d')
{
    try {
        return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
    } catch (\ErrorException $e) {
        return \Carbon\Carbon::createFromFormat($format, $value);
    }
}
    public function model(array $row)
    {
        error_log(json_encode($row));
        $UNIX_DATE = ($row[1] - 25569) * 86400;
        echo gmdate("d-m-Y H:i:s", $UNIX_DATE);

        
        return new TomaPedidos([
            
            // 'fecha_creacion'    => DateTime::createFromFormat('d/m/Y H:i:s', $row[1])->format('Y-m-d h:i:s'), 
            'fecha_creacion'    =>  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1]),
            // 'fecha_creacion' =>$this->transformDate($row[1]),
            'numero_de_pedido' => $row[2],
            'codigo_de_cliente'=> $row[3],
            'nombre_de_cliente'=> $row[4],
            'direccion'=> $row[5],
            'distrito'=> $row[6],
            'ruta_de_campo'=> $row[7],
            'ruta_de_llamada'=> $row[8],
            'importe_de_venta'=> $row[9],
            'usuario_inicial'=> $row[10],
            'usuario_final'=> $row[11],
        ]);
    }
}
