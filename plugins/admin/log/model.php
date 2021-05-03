<?php
$type_log_row=array();
$type_log_row[]=array("title"=>"ویرایش");
$type_log_row[]=array("title"=>"حذف");
$user_model = new model(array(
    "name" => "log_type", "title" => "مدیریت نوع لاگ","is_log"=>true, "db_model" => true,"default_rows"=>$type_log_row, "fields" => array(
        new field(
            array(
                "name" => "id", "type" => "int", "is_primary" => true
            )
        ),
        new field(
            array(
                "name" => "title", "title" => "نوع لاگ"
            )
        )
    )
));
