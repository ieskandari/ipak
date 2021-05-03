<?php
$params["name"] = $params["name"] . "_" . TableLog;
$params["title"] = "لاگ و تغییرات" . " " . $params["title"];
$params["is_log"] = true;
$feilds = $params["fields"];
foreach ($feilds as $field) {
    if ($field->is_primary) {
        $field->type = "bigint";
        $field->size = 18;
        $feilds[$field->name] = $field;
    }
}
$feilds[] =  new field(
    array(
        "name" => "log_date", "title" => "تاریخ لاگ", "is_filter" => true, "type" => "datetime", "in_table" => true
    )
);
$feilds[] =  new field(
    array(
        "name" => "log_user_id", "title" => "کاربر", "is_filter" => true, "in_table" => true, "type" => "int", "fk" => array(
            "model" => "admin/user", "key" => "user_id", "title" => "name,lname"
        )
    )
);
$feilds[] =  new field(
    array(
        "name" => "log_type", "title" => "نوع تغییرات", "is_filter" => true, "in_table" => true, "type" => "int", "fk" => array(
            "model" => "admin/log_type", "key" => "id", "title" => "title"
        )
    )
);
$feilds[] =  new field(
    array(
        "name" => "description", "title" => "توضیح", "in_table" => true
    )
);
$params["fields"] = $feilds;
$params["default_rows"]=array();
$params["in_menu"]=false;
$model_log = new model(
    $params
);
if (!function_exists('before_update_model_log')) {
    function before_update_model_log($values,$plugin,$model,$feilds,$primary_name,$id)
    {
        global $TR_db;
        if(sys\TR::$models[$plugin][$model]->is_log)
        {
         return;
        }
          $query="insert into ".$plugin."_".$model."_".TableLog."(";
          $vir="";
          $from="";
          foreach($feilds as $field)
          {
              if(!$field->is_view&&!$field->is_primary)
              {
                $query=$query.$vir.$field->name;
                $from=$from.$vir.$field->name;
                $vir=",";
              }
          }
          $query=$query.",log_date,log_user_id,log_type,description";
          $user=get_user();
       
          $query=$query.") select ".$from.",'".date('Y-m-d H:i:s')."'".",'".$user["user_id"]."'".",'1','".$user["name"]." ".$user["lname"]."'"." from ".$plugin."_".$model." where ".$primary_name."=:id";
          $id=$TR_db->pdo_exc($query,array(":id"=>$id));

    }
    add_action("before_update","before_update_model_log");
}
if (!function_exists('before_delete_model_log')) {
    function before_delete_model_log($id,$plugin,$model,$feilds,$primary_name)
    {
        global $TR_db;
        if(sys\TR::$models[$plugin][$model]->is_log)
        {
         return;
        }
          $query="insert into ".$plugin."_".$model."_".TableLog."(";
          $vir="";
          $from="";
          foreach($feilds as $field)
          {
              if(!$field->is_view&&!$field->is_primary)
              {
                $query=$query.$vir.$field->name;
                $from=$from.$vir.$field->name;
                $vir=",";
              }
          }
          $query=$query.",log_date,log_user_id,log_type,description";
          $user=get_user();
          $query=$query.") select ".$from.",'".date('Y-m-d H:i:s')."'".",'".$user["user_id"]."'".",'2','".$user["name"]." ".$user["lname"]."'"." from ".$plugin."_".$model." where ".$primary_name."=:id";
      
          $id=$TR_db->pdo_exc($query,array(":id"=>$id));

    }
    add_action("before_delete","before_delete_model_log");
}
