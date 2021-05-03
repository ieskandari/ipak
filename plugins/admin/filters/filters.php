<?php

namespace sys;

class filters
{
    function validate_date($data)
    {
        if (validateDate($data)) {
            $_firstDate = date("Y-m-d", strtotime($data));
            $_firstTime = date("H:i:s", strtotime($data));
            if ($_firstTime == "00:00:00") {
                $_firstTime = '';
            }
            $data = tools::to_shamsi($_firstDate) . ' ' . $_firstTime;
        } else if (validateDate($data, 'Y-m-d')) {
            $_firstDate = date("Y-m-d", strtotime($data));
            $data = tools::to_shamsi($_firstDate);
        }
        return $data;
    }
    function currency($data, $field)
    {
        if (is_numeric($data) && $field->is_currency) {
            $data = number_format($data);
        }
        return $data;
    }
    function show_parent($data, $field, $id = 0, $key = "",$export=false)
    {
        global $TR_db;

        if ($field->show_parent && $field->has_fk()) {
            $model_main = $field->fk["model"];
            $ex = explode("/", $model_main);
            if (count($ex) > 1) {
                $model_main = $ex[0] . "_" . $ex[1];
                $query="select * from ".$model_main." where ".$key."='".$id."'";
                
                if(isset(Tr::$models[$ex[0]][$ex[1]]->fields[$field->fk["show_parent_field"]]))
                {
                    $parent_field=Tr::$models[$ex[0]][$ex[1]]->fields[$field->fk["show_parent_field"]];
                    $rows=$TR_db->pdo_json($query);
                    if(count($rows)==0)
                    {
                       return $data;
                    }
                    $title=$rows[0][$field->fk["title"]];
           
                    $model=$parent_field->fk["model"];
                    $ex1=explode("/",$model);
                    $model=$ex1[0]."_".$ex1[1];
                    $query ="select * from ".$model." where ".$parent_field->fk["key"]."='".$rows[0][$parent_field->name]."'";
                   // echo $query;
                    $rows=$TR_db->pdo_json($query);
                     $data=$rows[0][$parent_field->fk["title"]]." - ". $title;
                }

               return $data;
            }
        }
        return $data;
    }
    function parent($data, $field, $id = 0, $key = "",$export=false)
    {
        global $TR_db;

        if ($field->is_parent && $field->has_fk()&&!$export) {
            $model = $field->fk["model"];
            $ex = explode("/", $model);
            if (count($ex) > 1) {
                $model = $ex[0] . "_" . $ex[1];
                $key_parent=$field->name;
                if(isset($field->fk["parent_field"]))
                {
                  $key_parent=$field->fk["parent_field"];
                }
          
                return $this->get_parent($model, $field->fk["title"],$key_parent, $field->fk["key"], $id, 1);
            }
        }
        return $data;
    }
    function get_parent($model, $title, $name, $key, $key_id, $start = 0)
    {
        global $TR_db;
        $query = "select * from " . $model . " where " .  $key . "='" . $key_id . "'";
       
        $rows = $TR_db->pdo_json($query);
        if (count($rows) == 0) {
            return '';
        }
        if($rows[0][$name]==$rows[0][$key])
        {
         return '';
        }
        $tits = '';
        $ex = explode(",", $title);
        if (count($ex) > 1) {
            for ($i = 0; $i < count($ex); $i++) {
                $tits = $tits . $rows[0][$ex[$i]];
            }
        } else {
            $tits = $rows[0][$title];
        }
        if ($rows[0][$name] > 0) {
            if ($start == 0) {
                return $this->get_parent($model, $title, $name, $key, $rows[0][$name], 1);
            } else {
                return $this->get_parent($model, $title, $name, $key, $rows[0][$name], 1) . " - " . $tits;
            }
        }
        if ($start == 0) {
            return '';
        }
        return $tits;
    }
}
$filter = new filters;
add_filter("filter_data", array($filter, "validate_date"));
add_filter("filter_data", array($filter, "currency"));
add_filter("filter_data", array($filter, "parent"));
add_filter("filter_data", array($filter, "show_parent"));
