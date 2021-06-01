<?php

namespace kekxcel\Controllers;

use kekxcel\Models\IndexModel;

class AjaxController extends Controller
{

    public function __construct() {
        $this->model = new IndexModel();
    }

    // public function getTableData($table) {
 
    //     // self::setHeaders();
        
    //     $rows = IndexModel::getTableData('exceldata');
    //     $response = [];

    //     foreach ($rows as $row) {
    //         $response[] = $row;
           
    //     }
    //     echo json_encode($response);
        
    // }

    // private static function setHeaders() {
    //     return [
    //         header("Access-Control-Allow-Origin: *"),
    //         header("Content-Type: application/json; charset=UTF-8"),
    //         header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE"),
    //         header("Access-Control-Max-Age: 3600"),
    //         header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With")
    //     ];
    // }
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
