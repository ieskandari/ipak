<?php
$post_fields = array(
    new field(
        array(
            "name" => "id", "type" => "bigint", "is_primary" => true
        )
    ),
    new field(
        array(
            "name" => "title", "title" => "عنوان", "size" => 1000, "is_uniq" => true, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-9")
        )
    ),
    new field(
        array(
            "name" => "category", "title" => "دسته بندی", "type" => "multi-check", "mfk" => array(
                "model" => "ipcommerce/category", "key" => "id", "title" => "title", "parent" => "parent_id"
            ), "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-3")
        )
    ),

    new field(
        array(
            "name" => "description", "title" => "متن", "type" => "text", "file" => "block", "in_table" => false,  "nullable" => true,  "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-9")
        )
    ),
    new field(
        array(
            "name" => "tags", "title" => "برچسب", "type" => "multi-check", "mfk" => array(
                "model" => "ipcommerce/tags", "key" => "id", "title" => "title"
            ), "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-3")
        )
    ),
    new field(
        array(
            "name" => "post_type", "title" => "نوع", "in_form" => false, "in_table" => false, "defualt" => "post", "size" => 500,  "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    ),
    new field(
        array(
            "name" => "slug", "title" => "نامک", "size" => 1000, "is_uniq" => true, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    ),
    new field(array(
        "name" => "img", "title" => "تصویر", "in_table" => false, "type" => "json", "size" => 2000, "file" => "gallery", "attr" => array("col-class" => "col-xs-12 col-sm-12 col-md-12 col-lg-12")
    )),

);
$post_model = new model(array("name" => "post", "title" => "نوشته ها", "db_model" => true, "icon" => "fa fa-sticky-note-o", "fields" => $post_fields));
