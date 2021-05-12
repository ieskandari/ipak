<?php
$user_model = new model(array(
    "name" => "user", "title" => "مدیریت کاربران", "db_model" => true,"icon"=>"fa fa-users", "fields" => array(
        new field(
            array(
                "name" => "user_id", "type" => "bigint", "is_primary" => true
            )
        ),
        new field(
            array(
                "name" => "name", "title" => "نام","nullable"=>false
            )
        ),
        new field(
            array(
                "name" => "lname", "title" => "نام خانوادگی","nullable"=>false
            )
        ),
        new field(array(
            "name" => "username", "title" => "نام کاربری","nullable"=>false,"is_uniq"=>true
        )),
        new field(
            array(
                "name" => "role_id", "title" => "نقش", "type" => "bigint","nullable"=>false, "is_filter" => true, "fk" => array(
                    "model" => "admin/role", "key" => "role_id", "title" => "name"
                )
            )
        ),
        new field(array(
            "name" => "pass", "title" => "رمز عبور","nullable"=>false,"in_table"=>false,"size"=>200,"attr"=>array("col-class"=>"col-md-6")
        )),
        new field(array(
            "name" => "user_role", "title" => "سمت","nullable"=>false,"size"=>200
        )),
        new field(array(
            "name" => "permission", "title" => "دسترسی","nullable"=>true,"type"=>"text","in_table"=>false
        )),
        new field(array(
            "name" => "img", "title" => "تصویر","type"=>"text","size"=>2000,"file"=>"img"
        )),
        new field(array(
            "name" => "se_key", "title" => "key","size"=>200,"in_table"=>false,"is_sys"=>1
        )),
        new field(array(
            "name" => "is_admin", "title" => "کاربر ادمین","type"=>"int","size"=>2
        )),
        new field(array(
            "name" => "setting","type"=>"json", "title" => "setting","in_table"=>false,"is_sys"=>1
        ))
    )
));
