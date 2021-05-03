<?php
$secret_fields = array(
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
$secret_model = new model(array("name" => "secret", "title" => "فیلد محرمانه", "db_model" => true,"icon"=>"fa fa-cubes", "fields" => $secret_fields));
