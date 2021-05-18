<?php
$category_fields = array(
    new field(
        array(
            "name" => "id", "type" => "bigint", "is_primary" => true
        )
    ),
    new field(
        array(
            "name" => "title", "title" => "عنوان دسته بندی", "size" => 1000, "is_uniq" => true, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    ),
    new field(
        array(
            "name" => "parent_id", "title" => "والد", "type" => "bigint", "nullable" => true, "is_filter" => true, "fk" => array(
                "model" => "ipcommerce/category", "key" => "id", "title" => "title"
            )
        )
    ),
    new field(
        array(
            "name" => "slug", "title" => "نامک", "size" => 1000, "is_uniq" => true, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    )
);
$category_model = new model(array("name" => "category", "title" => "دسته بندی", "db_model" => true, "icon" => "fa fa-list-alt", "fields" => $category_fields));
