<?php

namespace kekxcel\Controllers;

use Db;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;



class IndexController extends Controller
{

    private static $table = 'import';

    public function index()
    {
        if (isset($_POST['export'])) {
            $this->exportDataToExcel(self::$table);
        } elseif (isset($_FILES['import_excel']) && $_FILES["import_excel"]["name"] != '') {
            $this->importExcelData();
        }

        $this->getTableData(self::$table);
        $this->view->render('/Views/index.tpl.php', $this->pageData);
    }

    // Полученные данных из БД
    public function getTableData($table)
    {
        $colums = self::getColums($table);
        $colums = array_slice($colums, 1);
        $rows = \R::getAll("SELECT `number`, `full_name`, `date`, `adress`, `passport`, `childs`, `salary` FROM $table");

        $this->pageData['fields'] = $colums;
        $this->pageData['rows'] = $rows;
    }

    public function exportDataToExcel($table)
    {
        $file = new Spreadsheet();
        $active_sheet = $file->getActiveSheet();

        // Список полей таблицы
        $colums = self::getColums(self::$table);

        $alphabet = range('A', 'Z');
        // Смещение индексов на 1
        $alphabet = array_combine(range(1, count($alphabet)), $alphabet);

        for ($i = 1; $i < count($colums); $i++) {
            $active_sheet->setCellValue($alphabet[$i] . '1', $colums[$i]);
        }

        $count = 2;
        $rows = \R::getAll("SELECT `number`, `full_name`, `date`, `adress`, `passport`, `childs`, `salary` FROM $table");


        foreach ($rows as $row) {
            $cell_offset = 1;

            foreach ($row as $item) {
                $active_sheet->setCellValue($alphabet[$cell_offset++] . $count, $item);
            }

            $count += 1;
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, 'Xlsx');

        $file_name = time() . '.' . strtolower('Xlsx');

        $writer->save($file_name);
        $this->setHeaders($file_name);

        readfile($file_name);
        unlink($file_name);

        exit;
    }

    public function importExcelData()
    {
        $allowed_extension = ['xls', 'xlsx'];
        $file_name = $_FILES['import_excel']['name'];
        $file_array = explode(".", $file_name);
        $file_extension = end($file_array);

        if (in_array($file_extension, $allowed_extension)) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

            $spreadSheet = $reader->load($_FILES['import_excel']['tmp_name']);
            $excelSheet = $spreadSheet->getActiveSheet();
            $spreadSheetAry = $excelSheet->toArray();
            $columsName = $spreadSheetAry[0];

            // $columsName = array_filter($columsName, function($elem) {
            //     return $elem;
            // });

            $temp = [];
            for ($i = 0; $i < count($spreadSheetAry); $i++) {
                $temp[] = array_diff($spreadSheetAry[$i], array(''));
            }

            $spreadSheetAry = $temp;

            // $columsName = array_values($columsName);
            // $temp = $columsName;

            // for ($loop = 0; $loop < count($columsName); $loop++) {
            //     if ($columsName[$loop] == "" || $columsName[$loop] == "null") {
            //         unset($temp[$loop]);
            //     }
            // }

            // $columsName = $temp;
            // $columsName = array_values($columsName);
     
            print_r($spreadSheetAry);
        
        }

        //     \R::wipe(self::$table);

        //     for ($i = 1; $i <= count($spreadSheetAry); $i++) {
        //         if (isset($spreadSheetAry[$i][1])) {
        //             $import = \R::dispense(self::$table);
        //             $number = $spreadSheetAry[$i][0];
        //             $fullName = $spreadSheetAry[$i][1];
        //             $date = $spreadSheetAry[$i][2];
        //             $adress = $spreadSheetAry[$i][3];
        //             $passport = $spreadSheetAry[$i][4];
        //             $childs = $spreadSheetAry[$i][5];
        //             $salary = $spreadSheetAry[$i][6];

        //             $import->number = $number;
        //             $import->fullName = $fullName;
        //             $import->date = date("Y:m:d", strtotime($date));
        //             $import->adress = $adress;
        //             $import->passport = $passport;
        //             $import->childs = $childs;
        //             $import->salary = $salary;
        //             \R::store($import);
        //         }
        //     }
        // } else {
        //     $this->pageData['message'] = ' Error';
        // }
    }

    private function setHeaders($file_name)
    {
        return [
            header('Content-Type: application/x-www-form-urlencoded'),
            header('Content-Transfer-Encoding: Binary'),
            header("Content-disposition: attachment; filename=\"" . $file_name . "\"")
        ];
    }

    private static function getColums($tableName)
    {
        return array_keys(\R::inspect($tableName));
    }
}
