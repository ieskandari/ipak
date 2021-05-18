<?php
$tags_fields = array(
    new field(
        array(
            "name" => "id", "type" => "bigint", "is_primary" => true
        )
    ),
    new field(
        array(
            "name" => "title", "title" => "عنوان برچسب", "size" => 500,"is_uniq"=>true, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    )
);
$tags_model = new model(array("name" => "tags", "title" => "برچسب ها", "db_model" => true,"icon"=>"fa fa-tags", "fields" => $tags_fields));
