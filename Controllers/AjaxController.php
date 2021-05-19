<?php

namespace kekxcel\Controllers;


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Db;
use Spatie\SimpleExcel\SimpleExcelReader;

class AjaxController extends Controller
{

    // public function displayExcelData()
    // {
    //     if ($_FILES["import_excel"]["name"] != '') {
    //         $allowed_extension = array('xls', 'xlsx');
    //         $file_array = explode(".", $_FILES['import_excel']['name']);
    //         $file_extension = end($file_array);
    //         if (in_array($file_extension, $allowed_extension)) {
    //             $reader = IOFactory::createReader('Xlsx');
    //             $spreadsheet = $reader->load($_FILES['import_excel']['tmp_name']);
    //             $writer = IOFactory::createWriter($spreadsheet, 'Html');
    //             $response = $writer->save('php://output');
    //         } else {
    //             $response = '<div class="alert alert-danger">Only .xls or .xlsx file allowed</div>';
    //         }
    //     } else {
    //         $response = '<div class="alert alert-danger">Please Select File</div>';
    //     }

    //     return $response;
    // }

    

}
