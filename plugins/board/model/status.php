<?php
$status_fields = array(
    new field(
        array(
            "name" => "id", "type" => "bigint", "is_primary" => true
        )
    ),
    new field(
        array(
            "name" => "title", "title" => "عنوان وضعیت", "size" => 200, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    )
);
$post_status_row=array();
$post_status_row[]=array("title"=>"فعال");
$post_status_row[]=array("title"=>"غیرفعال");
$status_model = new model(array("name" => "status", "title" => "وضعیت", "db_model" => true,"is_menu"=>false,"default_rows"=>$post_status_row, "icon" => "fa fa-check-square", "fields" => $status_fields));
