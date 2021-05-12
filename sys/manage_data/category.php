<?php
return;
$model_cat=$field->fk["model"];
$ex=explode("/",$model_cat);
if(count($ex)>1)
{
    $model_cat=$ex[0]."_".$ex[1];
}
if(!$this->is_log)
{
    eval('$fun_category_before_update_' .$model_cat . '=function($values, $plugin,$model, $fields, $key,$key_id){
        global $TR_db;
        $vals1 = $hesab->parentJson($hesab->fields["category_id"], array("category_id" => $category_hesab[0]["id"]));
          $query="update ".$this->plugin."_".$this->name." set ".$this->current_parent_field->name."=\'\'";
    }; 
    add_action("before_update_'.$model_cat.'",$fun_category_before_update_' .$model_cat . ',1);');
}

