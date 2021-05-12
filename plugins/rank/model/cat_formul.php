<?php
$cat_formul_fields = array(
    new field(
        array(
            "name" => "id", "type" => "bigint", "is_primary" => true
        )
    ),
    new field(
        array(
            "name" => "title", "title" => "عنوان", "size" => 200,"is_uniq"=>true, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    )
);
$cat_formul_model = new model(array("name" => "cat_formul", "title" => "دسته فرمول", "db_model" => true,"icon"=>"fa fa-calculator", "fields" => $cat_formul_fields));
