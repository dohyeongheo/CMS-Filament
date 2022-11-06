<?php

namespace App\Http\Controllers\API;

use App\Exports\ContentsExport;
use App\Exports\ContentsPublishedExport;
use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use League\Csv\Reader;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as BaseExcel;
use Symfony\Component\HttpFoundation\Response;

class CsvController extends Controller
{
    public function exportCsv()
    {
        // $CsvData = Excel::raw(new ContentsExport, BaseExcel::CSV);
        $CsvData = Excel::raw(new ContentsPublishedExport, BaseExcel::CSV);


        return response($CsvData)
            ->header('Content-Type', 'text/plain');
    }
}
