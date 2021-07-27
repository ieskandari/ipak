<?php
namespace sys;
class field_tools
{
    var $fields=array();
    var $name="";
    function __construct($params=array())
    {
        if(isset($params["fields"]))
        {
          $this->fields=$params["fields"];
        }
        if(isset($params["name"]))
        {
          $this->name=$params["name"];
        }
    }
    function field_str($field)
    {
        $str = "";
        if ($field->type == "string") {
            $str = "`" . $field->name . "` varchar(" . $field->size . ") COLLATE utf8_persian_ci";
        } else if ($field->type == "int") {
            $str = "`" . $field->name . "` int(" . $field->size . ")";
        }  else if ($field->type == "double") {
            $str = "`" . $field->name . "` double";
        }
        else if ($field->type == "bigint") {
            $str = "`" . $field->name . "` bigint(" . $field->size . ")";
        } else if ($field->type == "bool") {
            $str = "`" . $field->name . "` int(1)";
        } 
        else if ($field->type == "date") {
            $str = "`" . $field->name . "` date";
        } else if ($field->type == "datetime") {
            $str = "`" . $field->name . "` datetime";
        }
        else if ($field->type == "text") {
            $str = "`" . $field->name . "` text";
        }
        else if ($field->type == "json") {
            $str = "`" . $field->name . "` json";
        }
        if ($field->is_primary) {
            $str = $str . " NOT NULL AUTO_INCREMENT";
        } else if (!$field->nullable) {
            $str = $str . " NOT NULL";
        } 
        if (isset($field->default)) {
            $str = $str . " DEFAULT '" . $field->default . "'";
        }
        
        return $str;
    }
    function get_fields_update($values,$is_param=false)
    {
        $str = "";
        $vir="";
        $params=array();
        foreach ($this->fields as $field) {
            $typeField =  get_class($field);
            if ($typeField == "field") {  
                if(isset($values[$field->name])&&!$field->is_primary)
                {
                    $params[":".$field->name]=$values[$field->name];
                    $str = $str.$vir.$field->name."=:".$field->name;
                    $vir=",";
                }              
            }
        }
        if($is_param)
        {
          return  $params;
        }
        return $str;
    }
    function get_field_name_insert($values)
    {
        $str = "";
        $vir="";
        foreach ($this->fields as $field) {
            $typeField =  get_class($field);
            if ($typeField == "field") {  
                if(isset($values[$field->name])&&!$field->is_primary)
                {
                    $str = $str.$vir.$field->name;
                    $vir=",";
                }              
            }
        }
        return $str;
    }
    function get_field_value_insert($values,$is_param=false)
    {
        $str = "";
        $vir="";
        $params=array();
        $values=apply_filters("filter_value_insert_".$this->name,$values);
        foreach ($this->fields as $field) {
            $typeField =  get_class($field);
            if ($typeField == "field") {
                 if(isset($values[$field->name])&&!$field->is_primary)
                 {
                    $params[":".$field->name]=$values[$field->name];
                    $str = $str.$vir.":".$field->name;
                    $vir=",";
                 }
            }
        }
        if($is_param)
        {
          return  $params;
        }
        return $str;
    }
}