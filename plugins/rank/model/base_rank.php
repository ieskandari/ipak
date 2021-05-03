<?php
$base_rank_fields = array(
    new field(
        array(
            "name" => "id", "type" => "bigint", "is_primary" => true
        )
    ),
    new field(
        array(
            "name" => "user_id", "title" => "کاربر ", "type" => "bigint", "nullable" => false, "in_form" => true, "is_filter" => true, "fk" => array(
                "model" => "admin/user", "key" => "user_id", "title" => "username,name,lname"
            )
        )
    ),
    new field(
        array(
            "name" => "year_id", "title" => "سال", "type" => "bigint", "nullable" => false, "in_form" => true, "is_filter" => true, "fk" => array(
                "model" => "rank/year", "key" => "id", "title" => "title"
            )
        )
    ),
    new field(
        array(
            "name" => "secret_id", "title" => "فیلد محرمانه", "type" => "bigint", "nullable" => false, "in_form" => true, "is_filter" => true, "fk" => array(
                "model" => "rank/secret", "key" => "id", "title" => "title"
            )
        )
    ),
    new field(
        array(
            "name" => "mablagh", "title" => "مقدار","type"=>"bigint","nullable"=>false,"is_currency"=>true, "size" => 18,"attr"=>array("min"=>0)
        )
    )
);
$base_rank_model = new model(array("name" => "base_rank", "title" => "اطلاعات محرمانه", "db_model" => true,"icon"=>"fa fa-cubes", "fields" => $base_rank_fields));
