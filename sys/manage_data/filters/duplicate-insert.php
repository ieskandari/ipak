<?php
if (!function_exists('validate_duplicate_insert'))
{
    function validate_duplicate_insert($values,$plugin,$model,$fields)
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
        if(is_array($data))
        {
            if(count($data)>0)
            {
                global $ViewData;
                $ViewData["FormErrors"][]=_T("duplicate-insert");
                return 0;
            }
        }
      return 1;
    }
    add_logic("logic_insert","validate_duplicate_insert");
}


