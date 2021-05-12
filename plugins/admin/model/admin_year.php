<?php
$admin_year_fields = array(
    new field(
        array(
            "name" => "id", "type" => "int", "is_primary" => true
        )
    ),
    new field(
        array(
            "name" => "title", "title" => "عنوان", "nullable" => false
        )
    ),
    new field(
        array(
            "name" => "content", "content" => "مقدار", "nullable" => false
        )
    )
);
$admin_year_rows = array();
for($x=1400;$x<1410;$x++)
{
    $admin_year_rows[] = array("title" => $x,"content"=>$x);
}
$admin_year_model = new model(array("name" => "admin_year", "title" => "سال", "db_model" => true,"in_menu"=>false, "default_rows" => $admin_year_rows, "fields" => $admin_year_fields));
