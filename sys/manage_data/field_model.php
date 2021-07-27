<?php
class field
{
    var $name = "";
    var $type = "string";
    var $size = 50;
    var $is_primary = false;
    var $is_meta = false;
    var $default = null;
    var $nullable = true;
    var $title = "";
    var $fk = array();
    var $mfk = array();
    var $query = "";
    var $in_table = true;
    var $attr = array(); //col_class,input_class
    var $is_view = false;
    var $is_filter = false;
    var $is_form_filter = false;
    var $value = "";
    var $option = array();
    var $is_sys = false;
    var $is_uniq = false;
    var $has_error = false;
    var $errors = array();
    var $is_currency = false;
    var $is_parent = false;
    var $in_form = true;
    var $has_parent_json = false;
    var $editable = true;
    var $show_parent = false;
    var $params = array();
    var $identity = false;
    var $identity_new = false;
    var $file = "";
    var $is_gallery = false;
    var $link=array();
    var $shortcut=true;
    var $help="";
    function __construct($params = array())
    {
        $this->params = $params;
        foreach ($params as $key => $value) {
            $this->{$key} = $value;
        }
        if (isset($params["file"]) && $params["file"] == "gallery") {
            $this->is_gallery = true;
        }
        if (isset($params["type"])) {
            $this->type = $params["type"];
            if ($this->type == "int") {
                $this->size = 11;
            } else  if ($this->type == "bigint") {
                $this->size = 18;
            } else  if ($this->type == "bool") {
                $this->size = 1;
            }
        }
        if (isset($params["is_primary"])) {
            $this->is_primary = $params["is_primary"];
            $this->in_table = false;
        }
    }

    function has_fk()
    {
        if (count($this->fk) > 0) {
            return true;
        }
        return false;
    }
    function get_title($model)
    {
        return apply_filters($model . "_" . $this->name . "_title", $this->title);
    }
}
