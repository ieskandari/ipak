<?php
$tickets_fields = array(
    new field(
        array(
            "name" => "id", "type" => "bigint", "is_primary" => true
        )
    ),
    new field(
        array(
            "name" => "title", "title" => "عنوان", "size" => 200,  "nullable" => false, "is_filter" => true, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    ),
    new field(
        array(
            "name" => "body", "title" => "توضیحات", "type" => "text" , "nullable" => true, "is_filter" => true, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    ),
    new field(
        array(
            "name" => "register_date", "title" => "تاریخ ثبت", "type" => "datetime" , "is_sys" => true , "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    ),
    new field(
        array(
            "name" => "user_id", "title" => "کاربر ثبت کننده ", "type" => "bigint", "nullable" => false, "in_form" => true, "is_filter" => true, "fk" => array(
                "model" => "admin/user", "key" => "user_id", "title" => "username,name,lname"
            )
        )
    ),
    new field(
        array(
            "name" => "state_id", "title" => "وضعیت", "type" => "int", "nullable" => true,"default" => 1, "is_filter" => true, "fk" => array(
                "model" => "board/state", "key" => "id", "title" => "title"
            )
        )
    ),
    new field(
        array(
            "name" => "emergency_id", "title" => "اورژانسی", "type" => "bigint", "nullable" => true, "default" => 2 , "is_filter" => true, "fk" => array(
                "model" => "board/status", "key" => "id", "title" => "title"
            )
        )
    ),
    new field(
        array(
            "name" => "roles_id", "title" => "بولتن", "type" => "bigint", "nullable" => false, "is_filter" => true, "fk" => array(
                "model" => "board/roles", "key" => "id", "title" => "title"
            )
        )
    ),
    new field(
        array(
            "name" => "close_date", "title" => "تاریخ اتمام", "type" => "datetime" ,  "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    ),
    new field(
        array(
            "name" => "deadline", "title" => "مهلت اتمام", "type" => "datetime" ,  "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    ),
    new field(
        array(
            "name" => "parent_id", "title" => "والد", "type" => "bigint", "nullable" => true, "is_filter" => true, "fk" => array(
                "model" => "board/tickets", "key" => "id", "title" => "title"
            )
        )
    ),
    new field(
        array(
            "name" => "duration", "title" => "زمان صرف شده", "size" => 13 , "type" => "int"  , "nullable" => true,  "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    ),
    new field(
        array(
            "name" => "color", "title" => "رنگ", "size" => 20, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    ),
    new field(
        array(
            "name" => "link", "title" => "لینک", "size" => 300, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    ),
    new field(
        array(
            "name" => "upload", "title" => "آپلود", "size" => 500, "attr" => array("col-class" => "col-xs-12 col-sm-6 col-md-6 col-lg-4")
        )
    )
);
$tickets_model = new model(array("name" => "tickets", "title" => "تیکت", "db_model" => true, "icon" => "fa fa-newspaper-o", "fields" => $tickets_fields));
