<?php
$formul_fields = array(
    new field(
        array(
            "name" => "id", "type" => "bigint", "is_primary" => true
        )
    ),
    new field(
        array(
            "name" => "title", "title" => "عنوان", "size" => 200, "is_uniq" => false, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    ),
    new field(
        array(
            "name" => "cat_formul_id", "title" => "دسته فرمول", "type" => "bigint", "nullable" => false, "in_form" => true, "is_filter" => true, "fk" => array(
                "model" => "rank/cat_formul", "key" => "id", "title" => "title"
            )
        )
    ),
    new field(
        array(
            "name" => "formul", "title" => "فرمول", "size" => 1000, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    ),
);
$formul_model = new model(array("name" => "formul", "title" => "فرمول", "db_model" => true, "icon" => "fa fa-calculator", "fields" => $formul_fields));
