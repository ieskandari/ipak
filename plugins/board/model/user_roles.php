<?php
$user_roles_fields = array(
    new field(
        array(
            "name" => "id", "type" => "bigint", "is_primary" => true
        )
    ),
    new field(
        array(
            "name" => "role_id", "title" => "بولتن", "type" => "bigint", "nullable" => true, "is_filter" => true, "fk" => array(
                "model" => "board/roles", "key" => "id", "title" => "title"
            )
        )
    ),
    new field(
        array(
            "name" => "user_id", "title" => "کاربر ", "type" => "bigint", "nullable" => false, "in_form" => true, "is_filter" => true, "fk" => array(
                "model" => "admin/user", "key" => "user_id", "title" => "username,name,lname"
            )
        )
    )
);
$user_roles_model = new model(array("name" => "user_roles", "title" => "کاربران بولتن", "db_model" => true, "icon" => "fa fa-newspaper-o", "fields" => $user_roles_fields));
