<?php

namespace kekxcel\Controllers;

use Db;
use kekxcel\Models\IndexModel;
use kekxcel\Views\View;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;



class IndexController extends Controller
{

    private static $table = 'exceldata';

    public function __construct()
    {
        $this->model = new IndexModel();
        $this->view = new View();
    }

    

    public function index()
    {
        if (isset($_POST['export'])) {
            $this->exportDataToExcel();
        } elseif (isset($_FILES['import_excel']) && $_FILES["import_excel"]["name"] != '') {
            $this->importExcelData();
        } elseif (isset($_GET['query'])) {
            echo $this->getTableData(self::$table);
            return;
        }

        $this->view->render('/Views/index.tpl.php', $this->pageData);
    }

    // Полученные данных из БД
    public function getTableData($table) {
 
        $rows = IndexModel::getTableData($table);
        $response = '';

        foreach ($rows as $row) {
            $response .= '
            <tr class = table-row>
                <td>'.$row["number"].'</td>
                <td>'.$row["db_id"].'</td>
                <td>'.$row["first_name"].'</td>
                <td>'.$row["last_name"].'</td>
                <td>'.$row["middle_name"].'</td>
                <td>'.$row["birthdate"].'</td>
                <td>'.$row["birth_place"].'</td>
                <td>'.$row["adress"].'</td>
                <td>'.$row["request_date"].'</td>
                <td>'.$row["document_type"].'</td>
                <td>'.$row["document_series"].'</td>
                <td>'.$row["document_number"].'</td>
                <td>'.$row["document_date"].'</td>
                <td>'.$row["document_issue"].'</td>
                <td>'.$row["phone"].'</td>
                <td>'.$row["work_place"].'</td>
                <td class = table__content-comment>'.$row["comment"].'</td>
            </tr>
           ';
        }

        return $response;
    }

    public function exportDataToExcel() {

        $colums = json_decode(file_get_contents('php://input'));
        // Список полей таблицы
        $colums = array_combine(range(1, count($colums)),$colums);
        $subColums = array_slice($colums,10);
        $subColums = array_combine(range(1, count($subColums)), $subColums);
        $colums = array_diff($colums, $subColums);
        $fileExtension = 'xlsx';
        
        
      
        $file = new Spreadsheet();
        $active_sheet = $file->getActiveSheet();

        

        $alphabet = range('A', 'Z');
        $subAlphabet = range('J','Q');
        // Смещение индексов на 1
        $alphabet = array_combine(range(1, count($alphabet)), $alphabet);
        $subAlphabet = array_combine(range(1, count($subAlphabet)), $subAlphabet);

        for ($i = 1; $i <= 3; $i++) {
            array_push($subColums, $subColums[$i]);
            unset($subColums[$i]);
        }

        $subColums = array_values($subColums);
        $subColums = array_combine(range(1, count($subColums)), $subColums);

        // print_r($colums);
        // echo "\n";
        // print_r($subColums);
        // echo "\n";
        // print_r($subAlphabet);


        for ($i = 1; $i < count($colums); $i++) {
            
            if (preg_match('~Документ гражданской~',$colums[$i])) {
                $active_sheet->mergeCells('J1:N1');
              
            }
            
            $active_sheet->setCellValue($alphabet[$i] . '1', $colums[$i]);
        }

        for ($i = 1; $i <= count($subColums); $i++) {
            $active_sheet->setCellValue($subAlphabet[$i] . '2', $subColums[$i]);
        }

        $active_sheet->getColumnDimension('A')->setWidth(50);
        $active_sheet->getRowDimension(1)->setRowHeight(50);

        $count = 3;
        $rows = IndexModel::getTableData(self::$table);


        foreach ($rows as $row) {
            $cell_offset = 1;

            foreach ($row as $item) {
                $active_sheet->setCellValue($alphabet[$cell_offset++] . $count, $item);
                $active_sheet->getRowDimension($count)->setRowHeight(50);
            }
            $count += 1;
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, 'Xlsx');

        $file_name = time() . '.' . strtolower($fileExtension);

        $writer->save($file_name);
        $this->setHeaders($file_name);

        readfile($file_name);
        unlink($file_name);
    }

    public function importExcelData() {
        $allowed_extension = ['xls', 'xlsx'];
        $file_name = $_FILES['import_excel']['name'];
        $file_array = explode(".", $file_name);
        $file_extension = end($file_array);

        if (in_array($file_extension, $allowed_extension)) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

            $spreadSheet = $reader->load($_FILES['import_excel']['tmp_name']);
            $excelSheet = $spreadSheet->getActiveSheet();
            $spreadSheetAry = $excelSheet->toArray();

            $temp = [];
            for ($i = 0; $i < count($spreadSheetAry); $i++) {
                $temp[] = array_diff($spreadSheetAry[$i], array(''));
            }

            $spreadSheetAry = $temp;

            $colums = $spreadSheetAry[0];
            $subColums = $spreadSheetAry[1];
            $allColums = array_merge($colums,$subColums);

            $insertData = [];

            // print_r($colums) ."\n";
            // print_r($subColums) . "\n";
            // print_r($spreadSheetAry);

            
            for ($i = 2; $i <= count($spreadSheetAry); $i++) {
                if (isset($spreadSheetAry[$i][2]) && $spreadSheetAry[$i] != '') {
                    
                    $insertData['number'] = $spreadSheetAry[$i][0];
                    $insertData['db_id'] = $spreadSheetAry[$i][1];
                    $insertData['first_name'] = $spreadSheetAry[$i][2];
                    $insertData['last_name'] = $spreadSheetAry[$i][3];
                    $insertData['middle_name'] = $spreadSheetAry[$i][4];
                    $insertData['birthdate'] = $spreadSheetAry[$i][5];
                    $insertData['birth_place'] = $spreadSheetAry[$i][6];
                    $insertData['adress'] = $spreadSheetAry[$i][7];
                    $insertData['request_date'] = $spreadSheetAry[$i][8];
                    $insertData['document_type'] = $spreadSheetAry[$i][9];
                    $insertData['document_series'] = $spreadSheetAry[$i][10];
                    $insertData['document_number']= $spreadSheetAry[$i][11];
                    $insertData['document_date'] = $spreadSheetAry[$i][12];
                    $insertData['document_issue'] = $spreadSheetAry[$i][13];
                    $insertData['phone'] = $spreadSheetAry[$i][14];
                    $insertData['work_place'] = $spreadSheetAry[$i][15];
                    $insertData['comment'] = $spreadSheetAry[$i][16];

                    var_dump(IndexModel::insertData(self::$table, $insertData));
                }
            }
        } else {
            $this->pageData['message'] = ' Error type of file';
        }
    }

    public function searchData() {
        $table = self::$table;
        $search = $_POST['query'];
        $sql =  "
        SELECT * FROM exceldata 
            WHERE first_name LIKE '%".$search."%'
            OR last_name LIKE '%".$search."%' 
            OR middle_name LIKE '%".$search."%' 
            OR birthdate LIKE '%".$search."%' 
            OR document_series LIKE '%".$search."%'
       ";

        $response = '';
        $rows = \R::getAssoc($sql);

        foreach ($rows as $row) {
            $response .= '
            <tr>
                <td>' . $row["number"] . '</td>
                <td>' . $row["db_id"] . '</td>
                <td>' . $row["first_name"] . '</td>
                <td>' . $row["last_name"] . '</td>
                <td>' . $row["middle_name"] . '</td>
                <td>' . $row["birthdate"] . '</td>
                <td>' . $row["birth_place"] . '</td>
                <td>' . $row["adress"] . '</td>
                <td>' . $row["request_date"] . '</td>
                <td>' . $row["document_type"] . '</td>
                <td>' . $row["document_series"] . '</td>
                <td>' . $row["document_number"] . '</td>
                <td>' . $row["document_date"] . '</td>
                <td>' . $row["document_issue"] . '</td>
                <td>' . $row["phone"] . '</td>
                <td>' . $row["work_place"] . '</td>
                <td class = `table__content-comment`>' . $row["comment"] . '</td>
            </tr>
           ';
        }

        echo $response;
    }

    private function setHeaders($file_name) {
        return [
            header('Content-Type: application/x-www-form-urlencoded'),
            header('Content-Transfer-Encoding: Binary'),
            header("Content-disposition: attachment; filename=\"" . $file_name . "\"")
        ];
    }

    
}
