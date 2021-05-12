<?php
$role_model = new model(array(
    "name" => "role", "title" => "مدیریت نقش ها", "db_model" => true,"icon"=>"fa fa-universal-access", "fields" => array(
        new field(
            array(
                "name" => "role_id", "type" => "bigint", "is_primary" => true
            )
        ),
        new field(
            array(
                "name" => "name", "title" => "عنوان","nullable"=>false
            )
        ),
        new field(array(
            "name" => "permission", "title" => "دسترسی","type"=>"text","in_table"=>false,"in_form"=>false,"is_sys"=>1
        ))
    )
));
