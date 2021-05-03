<?php
$admin_month_fields = array(
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
            "name" => "day_count", "title" => "تعداد روز", "type" => "int", "nullable" => false
        )
    ),
    new field(
        array(
            "name" => "content", "title" => " مقدار", "type" => "int", "nullable" => false
        )
    )

);
$admin_month_rows = array();
$admin_month_rows[] = array("title" => "فروردین", "content" => 1, "day_count" => 31);
$admin_month_rows[] = array("title" => "اردیبهشت", "content" => 2, "day_count" => 31);
$admin_month_rows[] = array("title" => "خرداد", "content" => 3, "day_count" => 31);
$admin_month_rows[] = array("title" => "تیر", "content" => 4, "day_count" => 31);
$admin_month_rows[] = array("title" => "مرداد", "content" => 5, "day_count" => 31);
$admin_month_rows[] = array("title" => "شهریور", "content" => 6, "day_count" => 31);
$admin_month_rows[] = array("title" => "مهر", "content" => 7, "day_count" => 30);
$admin_month_rows[] = array("title" => "آبان", "content" => 8, "day_count" => 30);
$admin_month_rows[] = array("title" => "آذر", "content" => 9, "day_count" => 30);
$admin_month_rows[] = array("title" => "دی", "content" => 10, "day_count" => 30);
$admin_month_rows[] = array("title" => "بهمن", "content" => 11, "day_count" => 30);
$admin_month_rows[] = array("title" => "اسفند", "content" => 12, "day_count" => 30);

$admin_month_model = new model(array("name" => "admin_month", "title" => "ماه","in_menu"=>false, "db_model" => true, "fields" => $admin_month_fields, "default_rows" => $admin_month_rows));
