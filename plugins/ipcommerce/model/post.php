<?php
$post_fields = array(
    new field(
        array(
            "name" => "id", "type" => "bigint", "is_primary" => true
        )
    ),
    new field(
        array(
            "name" => "title", "title" => "عنوان نوشته", "size" => 1000, "is_uniq" => true, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    ),
    new field(
        array(
            "name" => "description", "title" => "متن نوشته", "type" => "text",  "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    ),
    new field(
        array(
            "name" => "post_type", "title" => "نوع نوشته", "in_form" => false, "in_table" => false, "size" => 500,  "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    ),
    new field(
        array(
            "name" => "slug", "title" => "نامک", "size" => 1000, "is_uniq" => true, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    )
    
);
$post_model = new model(array("name" => "post", "title" => "نوشته", "db_model" => true, "icon" => "fa fa-tags", "fields" => $post_fields));
