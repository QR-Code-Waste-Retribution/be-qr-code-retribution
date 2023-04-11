<?php

namespace App\Utils;

use Maatwebsite\Excel\Facades\Excel;

class ExportExcel
{
    public static function export($model, $name)
    {
        return Excel::download($model, $name);
    }
}