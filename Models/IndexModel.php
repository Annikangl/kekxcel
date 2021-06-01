<?php

namespace kekxcel\Models;

class IndexModel extends Model
{
    
    public static function getTableData($table) {
        $rows = \R::getAll("SELECT `number`, `db_id`, `first_name`, `last_name`, `middle_name`,
                                    `birthdate`, `birth_place`, `adress`, `request_date`, `document_type`,`document_series`,
                                    `document_number`,`document_date`,`document_issue`,`phone`,`work_place`, `comment`
                            FROM $table ORDER BY number");
        
        return $rows;
    }

    public static function getTableDataBySearch($search) {
        $sql =  "
        SELECT * FROM exceldata 
            WHERE first_name LIKE '%".$search."%'
            OR last_name LIKE '%".$search."%' 
            OR middle_name LIKE '%".$search."%' 
            OR birthdate LIKE '%".$search."%' 
            OR document_series LIKE '%".$search."%'
            OR document_number LIKE '%".$search."%'
            ORDER BY number";

       return \R::getAssoc($sql);
    }

    public static function insertData($table,$insertData) {

        $table = \R::dispense($table);

        $id = $insertData['db_id'];
        $number = $insertData['number'];
        $db_id = $insertData['db_id'];
        $first_name = $insertData['first_name'];
        $last_name = $insertData['last_name'];
        $middle_name = $insertData['middle_name'];
        $birthdate = $insertData['birthdate'];
        $birth_place = $insertData['birth_place'];
        $adress = $insertData['adress'];
        $request_date = $insertData['request_date'];
        $document_type = $insertData['document_type'];
        $document_series = $insertData['document_series'];
        $document_number = $insertData['document_number'];
        $document_date = $insertData['document_date'];
        $document_issue = $insertData['document_issue'];
        $phone = $insertData['phone'];
        $work_place = $insertData['work_place'];
        $comment = $insertData['comment'];

        $inserting = \R::exec('INSERT INTO `exceldata` (id,number,db_id,first_name,last_name,middle_name,birthdate,birth_place,adress,request_date,document_type,document_series,
                                            document_number,document_date,document_issue,phone,work_place,comment) 
                                            VALUES (:id,:number,:db_id,:first_name,:last_name,:middle_name,
                                            :birthdate,:birth_place,:adress,:request_date,:document_type,:document_series,:document_number,:document_date,:document_issue,
                                            :phone,:work_place,:comment)
                                            ON DUPLICATE KEY UPDATE number = :number, db_id = :db_id, first_name = :first_name,last_name = :last_name,middle_name = :middle_name,
                                            birthdate = :birthdate,birth_place = :birth_place,adress = :adress,request_date = :request_date,document_type = :document_type,
                                            document_series = :document_series,document_number = :document_number,document_date = :document_date,document_issue = :document_issue,
                                            phone = :phone,work_place = :work_place,comment = :comment', [
                                                ':id' => $id,
                                                ':number' => $number,
                                                ':db_id' => $db_id,
                                                ':first_name' => $first_name,
                                                ':last_name' => $last_name,
                                                ':middle_name' => $middle_name,
                                                ':birthdate' => $birthdate,
                                                ':birth_place' => $birth_place,
                                                ':adress' => $adress,
                                                ':request_date' =>$request_date,
                                                ':document_type' => $document_type,
                                                ':document_series' => $document_series,
                                                ':document_number' => $document_number,
                                                ':document_date' => $document_date,
                                                ':document_issue' => $document_issue,
                                                ':phone' => $phone,
                                                ':work_place' => $work_place,
                                                ':comment' => $comment
                                            ]);

        return $inserting;
    }

    public static function updateFieldById($id, $value) {
        $id = intval($id);
        $table = \R::load('exceldata', $id);
        $table->comment = $value;
        $result =  \R::store($table);
        return $result;
    }

    public static function getColums($table) {
        return array_keys(\R::inspect($table));
    }

}