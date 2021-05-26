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

        // $table->number = $insertData['number'];
        // $table->db_id = $insertData['db_id'];
        // $table->first_name = $insertData['first_name'];
        // $table->last_name = $insertData['last_name'];
        // $table->middle_name = $insertData['middle_name'];
        // $table->birthdate = $insertData['birthdate'];
        // $table->birth_place = $insertData['birth_place'];
        // $table->adress = $insertData['adress'];
        // $table->request_date = $insertData['request_date'];
        // $table->document_type = $insertData['document_type'];
        // $table->document_series = $insertData['document_series'];
        // $table->document_number = $insertData['document_number'];
        // $table->document_date = $insertData['document_date'];
        // $table->document_issue = $insertData['document_issue'];
        // $table->phone = $insertData['phone'];
        // $table->work_place = $insertData['work_place'];
        // $table->comment = $insertData['comment'];

        // \R::store($table);
        
    }

    public static function getColums($table) {
        return array_keys(\R::inspect($table));
    }

}