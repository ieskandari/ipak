<?php
if (!function_exists('validate_duplicate_update'))
{
    function validate_duplicate_update($values,$plugin,$model,$fields,$primary_name,$id)
    {
        global $TR_db;
        $where=" where ";
        $vir="";
        $param=array();
        foreach($values as $key=>$value)
        {
            if(isset($fields[$key]))
            {
                if(!$fields[$key]->is_sys)
                {
                    $where=$where.$vir.$key."=:".$key;
                    $vir=" and ";
                    $param[":".$key]=$value;
                }
            }
        }
        $query="select * from ".$plugin."_".$model.$where;
        $data=$TR_db->pdo_json($query,$param);
        if(count($data)>0)
        {
            global $ViewData;
            $query="select * from ".$plugin."_".$model." where ".$primary_name."=:id";
            $ex=$TR_db->pdo_json($query,array(":id"=>$id));
            if(count($ex)>0)
            {
                  if($ex[0][$primary_name]!=$data[0][$primary_name])
                  {
                    $ViewData["FormErrors"][]=_T("duplicate-insert");
                    return 0;
                  }
            }
            $ViewData["FormWarnings"][]=_T("update-warning");
            return 0;
        }
      return 1;
    }
    add_logic("logic_update","validate_duplicate_update");
}