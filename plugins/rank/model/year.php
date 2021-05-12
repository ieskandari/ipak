<?php
$year_fields = array(
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
$year_model = new model(array("name" => "year", "title" => "سال", "db_model" => true,"icon"=>"fa fa-calendar", "fields" => $year_fields));
