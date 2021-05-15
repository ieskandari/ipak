<?php
$state_fields = array(
    new field(
        array(
            "name" => "id", "type" => "bigint", "is_primary" => true
        )
    ),
    new field(
        array(
            "name" => "title", "title" => "عنوان", "size" => 200, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    )
);
$state_model = new model(array("name" => "state", "title" => "وضعیت کار", "db_model" => true, "icon" => "fa fa-check-square", "fields" => $state_fields));
