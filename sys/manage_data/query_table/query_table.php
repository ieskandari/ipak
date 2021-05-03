<?php
class query_table
{
    var $plugin = "";
    var $name = "";
    var $results = array();
    var $view_fields = array();
    var $page = 1;
    var $FullName = "";
    var $paging = true;
    var $clear = 0;
    var $primary_field = array();
    var $setting = array();
    var $export = false;
    var $group_by = array();
    var $is_group_by = false;
    var $on_view = "";
    var $view_query = "";
    var $current_typr=array();
    function __construct($params = array())
    {
        foreach ($params as $key => $value) {
            $this->{$key} = $value;
        }
        $this->FullName = $this->plugin . "_" . $this->name;
        if ($this->export) {
            $this->paging = false;
        }
    }

    function run_query()
    {
        global $ViewData, $TR_db;
        $query = " from(select ";
        $left_join = "";
        $fields = $this->view_fields;
        $query = $query . "tb." . $this->primary_field->name . " as primary__key__id,'" . $this->primary_field->name . "' as primary__key__id_title";
        $vir = ",";
        foreach ($fields as $field) {

            if ($field->has_fk()) {
                $model = $field->fk["model"];
                $ex = explode("/", $field->fk["model"]);
                if (count($ex) > 1) {
                    $model = $ex[0] . "_" . $ex[1];
                } else {
                    $model = $this->plugin . "_" . $ex[0];
                }
                $concat = "'" . " " . "'";
                $title = "";
                if (isset($field->fk["concat"])) {
                    $concat = "'" . $field->fk["concat"] . "'";
                }
                $ex_title = explode(",", $field->fk["title"]);
                $vi = "";
                $co = "concat(";

                foreach ($ex_title as $item) {
                    $co = $co . $vi . "tb_fk_" . $model . "_" . $field->name . "." . $item;
                    $vi = "," . $concat . ",";
                }
                $co = $co . ")";
                $title = $co;
                $query = $query . $vir  . $title . "  as " . $field->name . "_title";
                if ($field->has_parent_json) {
                    $query = $query . $vir  . "tb." . $field->name . "_parentJson" . "  as " . $field->name . "_parentJson";
                }
                if (isset($field->fk["dep"])) {
                    $query = $query . $this->query_field_filter_has_fk($field->fk["dep"], $field->name);
                }
                $left_join = $left_join . " left join " . $model . " as " . "tb_fk_" . $model . "_" . $field->name . " on " . "tb." . $field->name . "=tb_fk_" . $model . "_" . $field->name . "." . $field->fk["key"];
                $query = $query . "," . "tb." . $field->name;
                if (isset($field->fk["dep"])) {
                    $left_join = $left_join . $this->query_join_filter_has_fk($field->fk["dep"], "tb_fk_" . $model . "_" . $field->name, $field->name);
                }
            } else if (strlen($field->query) > 0) {
                $query = $query . $vir . "(" . $field->query . ") as " . $field->name;
            } else {
                $name_field = "tb." . $field->name;
                $query = $query . $vir . $name_field;
            }
            $vir = ",";
        }
        $from_table = $this->plugin . "_" . $this->name;
        if (strlen($this->on_view) > 0) {
            $from_table = $this->on_view;
        }
        if (strlen($this->view_query) > 0) {
            $from_table = " (" . $this->view_query . ") ";
        }
        $query = $query . " from " . $from_table . " as tb" . $left_join . ") as tb_all where 1=1 ";
         $query=apply_filters("custom_select_query_".$this->plugin."_".$this->name,$query,$this->current_type);
        $query = $query . $this->get_qroup_by();
        $query = $query . $this->query_search_field();
        $query = $query . $this->query_filter();

        $queryCount = "select count(*) as cnt " . $query;

        $RowCnt = $TR_db->pdo_json($queryCount);
        if (is_array($RowCnt) && count($RowCnt) > 0) {
            $ViewData["TableDataCount"] = $RowCnt[0]["cnt"];
        } else {
            $ViewData["TableDataCount"] = 0;
        }

        $query = $query . $this->query_sort();
        $this->get_results($query);
        // echo $query;
        if ($this->paging) {
            $query = $query . $this->query_paging();
        }

        $query = "select * " . $query;
        $datas = $TR_db->pdo_json($query);
        if (is_array($datas)) {
            $ViewData["TableData"] = $TR_db->pdo_json($query);
        } else {
            $ViewData["TableData"] = array();
        }
    }
    function get_qroup_by()
    {

        if (!$this->is_group_by) {
            return "";
        }
        $query_group_by = " and 1=0 ";
        $index = 0;
        foreach ($this->group_by["fields"] as $item) {
            if (isset($item["value"])) {
                if ($index == 0) {
                    $query_group_by = " ";
                    $index = 1;
                }
                $query_group_by = $query_group_by . ' and ' . $item["field"] . "='" . $item["value"] . "'";
            }
        }

        return $query_group_by;
    }
    function get_results($query)
    {
        global $ViewData, $TR_db;
        $query = " " . $query;
        $query_kham = $query;
        $ViewData["Results"] = array("fields" => array(), "footer" => array());
        if (isset($this->results["fields"])) {
            if (count($this->results["fields"]) > 0) {
                $vir = "";
                $qu = "";
                foreach ($this->results["fields"] as $key => $item) {
                    $qu = $qu . $vir . $item . " as " . $key;
                    $vir = ",";
                }
                $query = "select " . $qu . " " . $query;

                $data = $TR_db->pdo_json($query);
                if (is_array($data) && count($data) > 0) {
                    foreach ($this->results["fields"] as $key => $item) {
                        $ViewData["Results"]["fields"][$key] = $data[0][$key];
                    }
                }
            }
        }
        $query = $query_kham;
        if (isset($this->results["footer"])) {
            $vir = "";
            $qu = "";
            $index = 0;
            foreach ($this->results["footer"] as $item) {
                $qu = $qu . $vir . $item["query"] . " as col_" . $index;
                $vir = ",";
                $index++;
            }
            $query = "select " . $qu . " " . $query;

            $data = $TR_db->pdo_json($query);
            $index = 0;
            if (is_array($data) && count($data) > 0) {
                foreach ($this->results["footer"] as $item) {
                    $ViewData["Results"]["footer"][] = array("tag" => $item["tag"], "label" => $item["label"], "result" => $data[0]["col_" . $index]);
                    $index++;
                }
            }
        }
    }
    function query_field_filter_has_fk($dep, $field_name)
    {
        $query = "";
        $model = $dep["model"];
        $ex = explode("/", $dep["model"]);
        if (count($ex) > 1) {
            $model = $ex[0] . "_" . $ex[1];
        } else {
            $model = $this->plugin . "_" . $ex[0];
        }
        $concat = "'" . " " . "'";
        $title = "";
        if (isset($dep["concat"])) {
            $concat = "'" . $dep["concat"] . "'";
        }
        $ex_title = explode(",", $dep["title"]);
        $vi = "";
        $co = "concat(";

        foreach ($ex_title as $item) {
            $co = $co . $vi . "tb_fk_" . $model . "_" . $field_name . "." . $item;
            $vi = "," . $concat . ",";
        }
        $co = $co . ")";
        $title = $co;
        $query = $query . ","  . $title . "  as " . $model . "_" . $dep["key"] . "_" . $field_name . "_title";

        $query = $query . "," . "tb_fk_" . $model . "_" . $field_name . "." . $dep["key"] . " as " . $model . "_" . $dep["key"] . "_" . $field_name;
        if (isset($dep["dep"])) {
            $query = $query . $this->query_field_filter_has_fk($dep["dep"], $field_name);
        }
        return $query;
    }
    function query_join_filter_has_fk($dep, $key_id, $field_name)
    {
        $query = "";
        $model = $dep["model"];
        $ex = explode("/", $dep["model"]);
        if (count($ex) > 1) {
            $model = $ex[0] . "_" . $ex[1];
        } else {
            $model = $this->plugin . "_" . $ex[0];
        }
        $query_key = "=tb_fk_" . $model . "_" . $field_name . "." . $dep["key"];

        $query = $query . " left join " . $model . " as " . "tb_fk_" . $model . "_" . $field_name . " on " . $key_id . "." . $dep["on_key"] . $query_key;

        if (isset($dep["dep"])) {
            $query = $query . $this->query_join_filter_has_fk($dep["dep"], "tb_fk_" . $model . "_" . $field_name, $field_name);
        }
        return $query;
    }
    function set_setting($key, $value = "")
    {
        $this->setting[$key] = $value;
        // echo $key.'\n';
        set_user_setting($this->FullName . "_table", $this->setting);
    }
    function Check_Get($key, $def = "")
    {
        if (isset($_GET["clear"]) && $_GET["clear"] == 1) {
            $this->clear();
            return $def;
        }
        if (isset($_GET[$key]) || isset($_POST[$key])) {
            $value = "";
            if (isset($_GET[$key])) {
                $value = $_GET[$key];
            } else {
                $value = $_POST[$key];
            }
            $this->set_setting($key, $value);
        }
        $value = $this->get_setting($key);

        if (strlen($value) > 0) {
            return $value;
        } else {
            $value = $def;
        }
        return $value;
    }
    function get_setting($key)
    {
        $value = get_user_setting($this->FullName . "_table");

        if (is_array($value)) {
            $this->setting = $value;
            if (isset($value[$key])) {
                return $value[$key];
            }
        }
        return "";
    }
    function query_paging()
    {
        if ($this->is_group_by) {
            return "";
        }
        global $ViewData;
        $pagesize = $this->Check_Get("pagesize", 10);
        $this->page = $this->Check_Get("page", 1);
        $ViewData["TableDataPageSize"] = $pagesize;
        $ViewData["TableDataPage"] = $this->page;
        $SumPage = ($this->page - 1) * $pagesize;
        $query = " limit " . $SumPage . "," . $pagesize;
        $mod = $ViewData["TableDataCount"] % $ViewData["TableDataPageSize"];

        $TotalPage = round($ViewData["TableDataCount"] / $ViewData["TableDataPageSize"]);

        if ($mod > 0) {
            // $TotalPage++;
        }
        $ViewData["TableDataTotalPage"] = $TotalPage;
        return $query;
    }
    function query_search_field()
    {
        global $TR_tools;
        if ($this->is_group_by) {
            return "";
        }
        global $ViewData;
        $ViewData["HeaderDataSearchValue"] = array();
        $values = array();
        foreach ($this->view_fields as $field) {
            $values[$field->name] = $this->Check_Get("search_" . $field->name, "");
        }
       
        $query = "";
        foreach ($values as $key => $value) {
            if (strlen($value) > 0) {
                if ($TR_tools->contains("$$", $value)) {
                    $vali = $value;
                    $vali = str_replace("$$", "", $vali);
                    $vali = str_replace("x", $key, $vali);
                    $vali = str_replace("X", $key, $vali);
                    $query = $query . " and " . $vali . " ";
                } else {
                    if(isset($this->view_fields[$key])&&($this->view_fields[$key]->type=="int" || $this->view_fields[$key]->type=="bigint"))
                    {
                        $query = $query . " and " . $key . " = '" . $value . "' ";
                    }
                    else
                    {
                        
                        $query = $query . " and " . $key . " like '%" . $value . "%' ";
                    }             
                }
                $ViewData["HeaderDataSearchValue"][$key] = $value;
            }
        }
        return $query;
    }
    function query_filter()
    {
        if ($this->is_group_by) {
            return "";
        }
        global $ViewData;
        $query = "";
        $posted = array();
        foreach ($this->view_fields as $field) {


            $value = $this->Check_Get("from_" . $field->name, "");
            $posted["from_" . $field->name] = "";
            if (strlen($value) > 0) {
                $first = $value;
                if ($field->type == "date" || $field->type == "datetime") {
                    $value = sys\tools::to_miladi($value);
                    if ($field->type == "datetime") {
                        $value = $value . " 00:00:00";
                    }
                }
                $query = $query . " and " . $field->name . ">=" . "'" . $value . "'";

                $_POST["from_" . $field->name] = $first;
            }


            $value = $this->Check_Get("to_" . $field->name, "");
            $posted["to_" . $field->name] = "";
            if (strlen($value) > 0) {
                $first = $value;
                if ($field->type == "date" || $field->type == "datetime") {
                    $value = sys\tools::to_miladi($value);
                    if ($field->type == "datetime") {
                        $value = $value . " 23:59:59";
                    }
                }
                $query = $query . " and " . $field->name . "<=" . "'" . $value . "'";
                $_POST["to_" . $field->name] = $first;
            }

            $value = $this->Check_Get($field->name, "");
            $posted[$field->name] = "";
            if ($field->has_fk()) {
                if (strlen($value) > 0) {
                    if ($value != 0) {
                        $val = $field->name;
                        if ($field->has_parent_json) {
                            $val = "json_extract(" . $field->name . "_parentJson, '$.id_" . $value . "')";
                        }
                        $query = $query . " and " . $val . "=" . "'" . $value . "'";
                        $_POST[$field->name] = $value;
                    }
                }
                if (isset($field->fk["dep"])) {
                    $query = $query .  $this->filter_has_fk($field->fk["dep"], $field->name);
                }
            } else {
                if (strlen($value) > 0) {
                    // $query = $query . " and " . $field->name . "=" . "'" . $value . "'";
                    // $_POST[$field->name] = $value;
                }
            }
        }
        return $query;
    }
    function filter_has_fk($dep, $id)
    {
        $query = "";
        $plugin = $this->plugin;
        $name = $plugin . "_" . $dep["model"];
        $ex = explode("/", $dep["model"]);
        if (count($ex) > 1) {
            $name = $ex[0] . "_" . $ex[1];
        }
        $item = $name . "_" . $dep["key"] . "_" . $id;
        $value = $this->Check_Get($item, "");
        if (strlen($value) > 0 && $value != 0) {
            $query = $query . " and " . $item . "=" . "'" . $value . "'";
            $_POST[$item] = $value;
        }
        if (isset($dep["dep"])) {
            $query = $query .  $this->filter_has_fk($dep["dep"], $id);
        }
        return $query;
    }
    function query_sort()
    {
        global $ViewData;
        $ViewData["HeaderDataSortValue"] = array();
        $values = array();
        $def = array();
        foreach ($this->view_fields as $field) {
            if (isset($_GET["sort_" . $field->name])) {
                $values[$field->name] = $this->Check_Get("sort_" . $field->name, "");
            } else {
                $val = $this->Check_Get("sort_" . $field->name, "");
                if (strlen($val) > 0) {
                    $def = array($field->name => $val);
                }
            }
        }
        $query = " order by primary__key__id desc";
        if (count($values) > 0) {
            foreach ($this->view_fields as $field) {
                $this->set_setting("sort_" . $field->name, "");
            }
        }
        foreach ($values as $key => $value) {
            if (strlen($value) > 0) {
                $query =  " order by " . $key . "  " . $value . ",primary__key__id " . $value;
                $ViewData["HeaderDataSortValue"][$key] = $value;
                $this->set_setting("sort_" . $key, $value);
            }
        }
        if (count($values) == 0) {
            foreach ($def as $key => $value) {
                if (strlen($value) > 0) {
                    $query =  " order by " . $key . "  " . $value . ",primary__key__id " . $value;
                    $ViewData["HeaderDataSortValue"][$key] = $value;

                    $this->set_setting("sort_" . $key, $value);
                }
            }
        }

        return $query;
    }

    function clear()
    {
        if ($this->clear == 1) {
            return;
        }
        $this->clear = 1;
        reset_user_setting($this->FullName . "_table");
    }
}
