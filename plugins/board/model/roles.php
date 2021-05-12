<?php
$roles_fields = array(
    new field(
        array(
            "name" => "id", "type" => "bigint", "is_primary" => true
        )
    ),
    new field(
        array(
            "name" => "title", "title" => "عنوان", "size" => 200,"is_uniq"=>true, "nullable" => false, "is_filter" => true, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    ),
    new field(
        array(
            "name" => "parent_id", "title" => "والد", "type" => "bigint", "nullable" => true, "is_filter" => true, "fk" => array(
                "model" => "board/roles", "key" => "id", "title" => "title"
            )
        )
    ),
    new field(
        array(
            "name" => "status_id", "title" => "وضعیت", "type" => "bigint", "default" => 1 , "nullable" => false, "is_filter" => true, "fk" => array(
                "model" => "board/status", "key" => "id", "title" => "title"
            )
        )
    ),
    new field(
        array(
            "name" => "color", "title" => "رنگ", "size" => 20, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    )
);
$roles_model = new model(array("name" => "roles", "title" => "بولتن", "db_model" => true, "icon" => "fa fa-cubes", "fields" => $roles_fields));
