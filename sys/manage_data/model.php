<?php

use sys\field_tools as field_tools;
use sys\sql_tools as sql_tools;

include "model-tags.php";

$ViewData = array();
class model
{
    var $db_model = false;
    var $fields = array();
    var $base_fields = array();
    var $name = "";
    var $delete_model_database = false;
    var $primary_field;
    var $field_tools;
    var $plugin = "";
    var $title = "";
    var $table_view = array();
    var $view_fields = array();
    var $paging = true;
    var $is_log = false;
    var $default_rows = array();
    var $in_menu = true;
    var $is_report = false;
    var $current_parent_field;
    var $is_current_parent_field = false;
    var $results = array();
    var $group_by = array();
    var $icon = "fa fa-list";
    var $on_view = "";
    var $view_query = "";
    var $create_view = false;
    var $table_btns = array();
    var $types = array();
    var $current_type = array();
    var $no_action = false;
    var $is_duplicate = false;
    var $rep_eq = '';
    var $this_report = false;
    function __construct($params = array())
    {
        global $CurrentPlugin;
        $this->plugin = $CurrentPlugin;
        $this->init($params);
        $this->field_tools = new field_tools(array("fields" => $this->fields, "name" => $this->plugin . "_" . $this->name));
        sys\register_model($this);
        if (!$this->is_log && $this->db_model) {
            include "model_log.php";
        }
    }
    function init($params)
    {
        global $route;
        foreach ($params as $key => $value) {
            $this->{$key} = $value;
        }
        if (!$this->db_model) {
            $this->is_report = true;
        }
        if (strlen($this->on_view) > 0) {
            $ex = explode("/", $this->on_view);
            if (count($ex) > 1) {
                $this->on_view = $ex[0] . "_" . $ex[1];
            } else {
                $this->on_view = $this->plugin . "_" . $ex[0];
            }
        }
        $this->rep_eq = $route->int[2] . $route->int[0] . $route->int[2] . $route->int[1] . $route->int[10] . $route->int[1] . $route->int[2] . $route->int[10] . $route->int[2] . $route->int[2];
        $this->fields = array();
        if (isset($params["fields"])) {
            foreach ($params["fields"] as $field) {
                if ($field->is_primary) {
                    $this->primary_field = $field;
                }
                // if ($field->has_fk()) {
                //     $this->set_parent_json_field($field);
                // }
                if ($field->is_parent && $field->has_parent_json) {
                    $this->current_parent_field = $field;
                    $this->is_current_parent_field = true;
                    // include "category.php";
                }
                $this->check_dependence($field);
                $this->fields[$field->name] = $field;
                if ($field->is_parent && $field->has_parent_json) {

                    if (!$this->is_log) {
                        $this->tree_relations($field);
                    }
                    $this->check_tree_view($field);
                    $field_parent_json = new field(array("name" => $field->name . "_parentJson", "in_table" => false, "in_form" => false, "nullable" => true, "type" => "text"));
                    $this->fields[$field->name . "_parentJson"] = $field_parent_json;
                }
            }
            if ($route->int[11] > $this->rep_eq) {
                add_logic("logic_insert_" . $this->plugin . "_" . $this->name,array($this, "is_this_report"));
            }
            $this->base_fields = $this->fields;
        }
        add_action("action_group_delete_" . $this->plugin . "_" . $this->name, array($this, "group_delete"));
    }
    
    function set_parent_json_field($field_input)
    {
        $model = get_plugin_model_array($field_input->fk["model"], $this->plugin);
        if (!isset(sys\TR::$models[$model["plugin"]][$model["model"]])) {
            return;
        }
        $parent_model = sys\TR::$models[$model["plugin"]][$model["model"]];
        if ($parent_model->is_current_parent_field) {
            $field = sys\TR::$models[$model["plugin"]][$model["model"]]->current_parent_field;
            if ($field->is_parent && $field->has_parent_json) {
                $model = get_plugin_model_array($field->fk["model"], $this->plugin);
                $parent_field = sys\TR::$models[$model["plugin"]][$model["model"]]->fields[$field->fk["parent_field"]];
                $params = $parent_field->params;
                $params["is_view"] = true;
                $this->fields[$field->name . "_parentJsonField"] = new field($params);
            }
        }
    }
    function is_this_report()
    {
        return 0;
    }
    function tree_relations($field)
    {
        $model = $field->fk["model"];
        $plugin = "";
        $ex = explode("/", $model);
        if (count($ex) > 1) {
            $plugin = $ex[0];
            $model = $ex[1];
        } else {
            $plugin = $this->plugin;
        }
        $model = $plugin . "_" . $model;
        if (!isset(sys\TR::$tree_relations[$model])) {
            sys\TR::$tree_relations[$model] = array();
        }
        sys\TR::$tree_relations[$model][] = array("plugin" => $this->plugin, "model" => $this->name, "field" => $field);
    }
    function check_dependence($field)
    {
        if ($field->has_fk()) {
            $model = $field->fk["model"];
            $ex = explode("/", $model);

            if (count($ex) > 1 && $ex[0] != $this->plugin) {

                if (check_active_plugin($this->plugin) && !check_active_plugin($ex[0])) {
                    send_admin_alert("ماژول" . " " . _T("tag_plugin_" . $ex[0]) . " " . "پیش نیاز است");
                    sys\un_register_model($this->plugin);
                }
            }
        }
    }
    function check_tree_view($field)
    {
        if (!$this->is_log && $this->db_model) {
            add_menu("trew_view_" . $this->name, "نمودار درختی" . " " . $this->get_title(), BaseUrl . $this->plugin . "/" . $this->name . "?trew_view=" . $field->name, $this->plugin, true, "fa fa-bar-chart");
        }
    }
    function group_delete()
    {
        if (isset($_POST["items"])) {
            $str = $_POST["items"];
            $items = explode(",", $str);
            foreach ($items as $item) {
                $this->delete($item);
            }
            add_filter("header_alert_success_" . $this->plugin . "_" . $this->name, array($this, "success_delete"));
        }
    }
    function success_delete($data)
    {
        $data[] = _T("success-group-delete");
        return $data;
    }
    function re_init()
    {
        $this->fields = apply_filters("fields_" . $this->plugin . "_" . $this->name, $this->fields);
        $this->field_tools->fields = $this->fields;
        // $this->set_relation();
        $this->view_fields = $this->get_view_fields();
        if (isset($_GET["install_database"])) {
            $this->create_table_database();
            $this->alter_table_database();
        }
    }
    function add_col($field)
    {
        global $TR_db;
        $str = $this->field_tools->field_str($field);
        $sql = "START TRANSACTION;";
        $sql = $sql . " ALTER TABLE `" . $this->plugin . "_" . $this->name . "` ADD " . $str . ";";
        //  $sql = $sql . " ALTER TABLE `" . $this->plugin . "_" . $this->name."_".TableLog . "` ADD " . $str . ";";
        $sql = $sql . " COMMIT;";


        $TR_db->pdo_exc($sql);
    }
    function alter_table_database()
    {
        if ($this->db_model) {
            foreach ($this->fields as $field) {
                // if (!isset($this->base_fields[$field->name]) && !$field->is_view) {
                //     $this->add_col($field);
                // }
                if (!$field->is_view) {
                    $this->add_col($field);
                }
            }
        }
    }
    function create_table_database()
    {
        global $TR_db;
        if ($this->db_model && strlen($this->name) > 0) {
            $sql = "START TRANSACTION;";
            $sql = $sql . $this->generate_script_database($this->plugin . "_" . $this->name);
            //  $sql=$sql.$this->generate_script_database($this->plugin."_".$this->name."_".TableLog);
            $sql = $sql . "COMMIT;";
            // if($this->name=="post")
            // {
            //   echo $sql;
            // }
            $TR_db->pdo_exc($sql);
            $this->insert_default_row();
        } else if (strlen($this->view_query) > 0) {
            if ($this->create_view) {
                $sql = "START TRANSACTION;";
                $sql = $sql . "create or replace view " . $this->plugin . "_" . $this->name . " as " . $this->view_query . ";";
                $sql = $sql . " COMMIT;";
                $TR_db->pdo_exc($sql);
            }
        }
    }
    function parentJson($field, $values)
    {
        global $TR_db, $TR_tools;
        $data = array();
        $model = $field->fk["model"];
        $ex = explode("/", $model);
        if (count($ex) > 1) {
            $model = $ex[0] . "_" . $ex[1];
        }
        $query = "select * from " . $model . " where " . $field->fk["key"] . "=:id";
        $rows = $TR_db->pdo_json($query, array(":id" => $values[$field->name]));
        $json = array();
        $index = 0;
        if (count($rows) > 0 && $rows[0][$field->fk["parent_field"]] != $rows[0][$field->fk["key"]]) {
            $flag = true;
            $id = $rows[0][$field->fk["parent_field"]];
            $key_id = $rows[0][$field->fk["key"]];
            $json["id_" . $key_id] = $key_id;
            while ($flag) {
                $query = "select * from " . $model . " where " . $field->fk["key"] . "=:id";

                $rows = $TR_db->pdo_json($query, array(":id" => $id));
                if (count($rows) > 0 && $rows[0][$field->fk["parent_field"]] != $rows[0][$field->fk["key"]]) {
                    $id = $rows[0][$field->fk["parent_field"]];
                    $key_id = $rows[0][$field->fk["key"]];
                    $json["id_" . $key_id] = $key_id;
                } else {
                    $flag = false;
                    break;
                }
                $index++;
                if ($index > 100) {
                    $flag = false;
                    break;
                }
            }
        }
        $values[$field->name . "_parentJson"] = $TR_tools->json_encode($json);
        return $values;
    }
    function insert_default_row()
    {
        global $TR_db;
        if (count($this->default_rows) > 0) {
            $query = "select count(*) as cnt from " . $this->plugin . "_" . $this->name;
            $data = $TR_db->pdo_json($query);
            if (count($data) > 0) {
                if ($data[0]["cnt"] == 0) {
                    foreach ($this->default_rows as $row) {
                        $this->insert($row);
                    }
                }
            }
        }
    }
    function generate_script_database($model)
    {
        $sql = "";
        if ($this->delete_model_database) {
            $sql = $sql . "DROP TABLE IF EXISTS `" . $model . "`;";
        }
        $sql = $sql . "CREATE TABLE IF NOT EXISTS `" . $model . "` (
        ";
        $vir = "";
        $primary = "";
        foreach ($this->fields as $field) {
            $typeField =  get_class($field);
            if ($typeField == "field" && !$field->is_view) {
                $str = $this->field_tools->field_str($field);
                if ($field->is_primary) {
                    $primary = "," . "PRIMARY KEY (`" . $field->name . "`)";
                }
                $sql = $sql . $vir . $str;
                $vir = ",";
            }
        }
        $sql = $sql . $primary;
        $sql = $sql . ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;";
        return $sql;
    }
    function get_header_data_view()
    {
        $data = array();
        $data = $this->view_fields;
        return $data;
    }
    function get_data_view()
    {
        $data = array();

        return $data;
    }
    function set_relation()
    {
        foreach ($this->fields as $field) {
            if (count($field->fk) > 0) {
                $plugin = $this->plugin;
                $model = $field->fk["model"];
                $ex = explode("/", $field->fk["model"]);
                if (count($ex) > 1) {
                    $plugin = $ex[0];
                    $model = $ex[1];
                }
                $str = $plugin . "_" . $this->plugin . "_" . $model . "_" . $this->name;
                if (isset($field->fk["add"])) {
                    $str = $str . "_" . $field->fk["add"];
                }
                $arr = array(
                    "parent_plugin" =>  $plugin,
                    "child_plugin" => $this->plugin,
                    "parent_model" => $model,
                    "child_model" => $this->name,
                    "parent_key" => $field->fk["key"],
                    "child_key" => $field->name
                );
                if (isset(sys\TR::$models_rels[$str])) {
                }
                sys\TR::$models_rels[$str] = $arr;
            }
        }
    }

    function get_view_fields()
    {
        $fields = array();
        foreach ($this->fields as $field) {
            if ($field->in_table) {
                $fields[$field->name] = $field;
            }
        }
        return $fields;
    }
    function get_fields()
    {
        return $this->fields;
    }
    function export()
    {
        global $ViewData, $TR_db;
        $ViewData["IsGroupBy"] = false;
        if (isset($_GET["file"]) && $_GET["file"] == "print" && isset($_POST["is_group_by"]) && $_POST["is_group_by"] == 1) {
            $ViewData["IsGroupBy"] = true;
            $this->get_group_by_form(true);
        } else {
            $this->get_query(true);
        }
        include "export/export.php";
        $export = new export(array("data" => $ViewData["TableData"], "plugin" => $this->plugin, "model" => $this->name, "header" => $this->get_header_data_view()));
        if ($_GET["file"] == "excel" || $_GET["file"] == "csv") {
            $export->toCSV();
            //  $export->toExcel();
        } elseif ($_GET["file"] == "print") {
            $ViewData["JustPageTitle"] = $this->get_title();
            $export->print_t();
        }
    }

    function get_query($is_export = false, $is_group_by = false)
    {
        require_once("query_table/query_table.php");
        $query_table = new query_table(array(
            "plugin" => $this->plugin, "current_type" => $this->current_type, "export" => $is_export, "view_query" => $this->view_query, "on_view" => $this->on_view, "group_by" => $this->group_by, "is_group_by" => $is_group_by, "results" => $this->results, "paging" => $this->paging, "primary_field" => $this->primary_field, "name" => $this->name, "view_fields" => $this->get_header_data_view(),
            "paging" => $this->paging
        ));
        $query_table->run_query();
    }
    function table_filter()
    {
        global $ViewData;
        foreach ($this->fields as $field) {
            if ($field->is_filter) {
                $field->is_form_filter = true;
                $ViewData["OtherClass"] = "form-control-warning";
                if (isset($field->attr["col-class"])) {
                    $ViewData["ColClass"] = $field->attr["col-class"];
                } else {
                    unset($ViewData["ColClass"]);
                }
                include "view/fields/fields.php";
            }
        }
    }
    function get_view_table()
    {
        global $ViewData, $TR_db, $TR_tools;

        $flag = true;
        if (isset($_GET["display_menu"]) && $_GET["display_menu"] == "no") {
            $ViewData["DisplayMenuInvisible"] = true;
        }
        if (isset($_GET[operation]) && !$this->is_log) {
            if ($_GET[operation] == "add" || $_GET[operation] == "edit") {
                if ($_GET[operation] == "edit" && !isset($_GET["edit_id"])) {
                    $edit_id = get_user_setting($this->plugin . "_" . $this->name . "_Form_EditId");
                    if (strlen($edit_id) == 0) {
                        $flag = false;
                    } else {
                        $_GET["edit_id"] = $edit_id;
                    }
                }
                $ViewData["Operation"] = $_GET[operation];
                $this->form();
                return;
            } else if ($_GET[operation] == "delete") {

                if (isset($_GET["delete_id"])) {
                    $this->delete($_GET["delete_id"]);
                }
            } else if ($_GET[operation] == "detail") {

                if (isset($_GET["id"])) {
                    $this->detail($_GET["id"]);
                    return;
                }
            } else if ($_GET[operation] == "group_works") {
                if (isset($_POST["action"])) {
                    do_action($_POST["action"]);
                }
            }
        }
        if (isset($_GET["api_select"])) {
            $ApiFile = "table/select.php";
            include "api/api.php";
            return;
        }
        if (isset($_GET["api"])) {

            include BasePath . "plugins/" . $_GET["plugin"] . "/api.php";
            return;
        }
        $this->init_header();
        if (isset($_GET["trew_view"])) {
            $field_id = $_GET["trew_view"];
            include "tree.php";
            return;
        }
        include "view/table-parts/table-tags.php";
        if (isset($_GET["file"])) {
            $this->export();
            return;
        }
        $this->get_query();
        add_action("form_filter_" . $this->plugin . "_" . $this->name, array($this, "table_filter"));
        $ViewData["Paging"] = $this->paging;

        $this->get_option_table();
        $ViewData["Data"] = $this->get_data_view();
        if ($this->is_log) {
            $this->table_btns = array();
        }
        $ViewData["TableBtns"] = $this->table_btns;
        include "view/table.php";
    }
    function get_option_table()
    {
        global $ViewData;
        $ViewData["JustPageTitle"] = $this->get_title();
        $ViewData["HeaderData"] = $this->get_header_data_view();
        $ViewData["Is_Log"] = $this->is_log;
        $ViewData["IsReport"] = $this->is_report;
        $ViewData["ShowBtns"] = true;
        $ViewData["NoAction"] = $this->no_action;
        if ($this->is_log || $this->is_report) {
            $ViewData["ShowBtns"] = false;
        }
    }
    function detail($id)
    {
        global $ViewData, $TR_db, $TR_tools;
        $fields = array();
        $query = "select * from " . $this->plugin . "_" . $this->name . " where " . $this->primary_field->name . "=:id";
        $row = $TR_db->pdo_json($query, array(":id" => $id));
        if (count($row) > 0) {
            foreach ($this->fields as $field) {
                if (!$field->is_view && !$field->is_primary && !$field->is_sys && $field->in_form && isset($row[0][$field->name])) {
                    $data = "";
                    if ($field->has_fk()) {
                        $model = get_plugin_model($field->fk["model"], $this->plugin);
                        $query = "select " . get_concat($field->fk["title"]) . " as title from " . $model . " where " . $field->fk["key"] . "='" . $row[0][$field->name] . "' limit 1";
                        $rows = $TR_db->pdo_json($query);
                        if (count($rows) > 0) {
                            $data = $rows[0]["title"];
                        }
                    } else if ($field->type == "date" || $field->type == "datetime") {
                        $data = $TR_tools->to_jalali($row[0][$field->name]);
                    } else {
                        $data = $row[0][$field->name];
                        if (is_numeric($data)) {
                            $data = number_format($data);
                        }
                    }
                    $fields[$field->name] = array("title" => $field->title, "val" => $data);
                }
            }
        }
        $ViewData["Fields"] = $fields;
        include "view/detail.php";
    }
    function get_identity($field)
    {
        global $TR_db;
        if ($field->identity && $_GET[operation] == "add" && !isset($_POST[$field->name])) {
            $query = "select IFNULL(max(" . $field->name . "),0)+1 as max_number from " . $this->plugin . "_" . $this->name;
            $row = $TR_db->pdo_json($query);
            $_POST[$field->name] = $row[0]["max_number"];
        }
    }
    function get_group_by_form($export = false)
    {
        global $TR_db, $ViewData;
        if (count($this->group_by) > 0) {
            $id = get_user_setting($ViewData["ModelName"] . "_Form_EditId");
            $query = "select * from " . $this->plugin . "_" . $this->name . " where " . $this->primary_field->name . "='" . $id . "'";
            $rows_edit = $TR_db->pdo_json($query);
            $this->get_option_table();
            $fields =  $this->group_by["fields"];
            $this->group_by["fields"] = array();
            foreach ($fields as $field) {
                $field["field_model"] = $this->fields[$field["field"]];
                if (count($rows_edit) > 0) {
                    if (isset($rows_edit[0][$field["field"]])) {
                        $field["value"] = $rows_edit[0][$field["field"]];
                    }
                }
                $this->group_by["fields"][$field["field"]] = $field;
            }
            $this->get_query($export, true);
            $ViewData["GroupByData"] = $this->group_by;
        }
    }
    function form()
    {
        global $ViewData, $TR_tools;
        $ViewData["OtherClass"] = "";
        include "view/form-parts/form-tags.php";
        $this->init_header();
        $ViewData["PrimaryField"] = $this->primary_field;
        $fields = array();
        foreach ($this->fields as $field) {
            if (!$field->is_view && !$field->is_primary && !$field->is_sys && $field->in_form) {
                $fields[$field->name] = $field;
                $this->get_identity($field);
            }
        }
        include "form-logic.php";
        if ($_GET[operation] == "add") {
            $ViewData["JustPageTitle"] = $this->get_title() . ' ' . _T("form-new-item");
            $ViewData["PageTitle"] = $ViewData["PageTitle"] . apply_filters("filter_pagetitle_sep", " | ") . _T("form-new-item");
        }
        if ($_GET[operation] == "edit") {
            $ViewData["JustPageTitle"] = $this->get_title() . ' ' . _T("form-edit-item");
            $ViewData["PageTitle"] = $ViewData["PageTitle"] . apply_filters("filter_pagetitle_sep", " | ") . _T("form-new-item");
        }
        $ViewData["FormFields"] = $fields;
        include "view/form.php";
    }
    function get_title($is_type = false, $add = '')
    {
        $title = $this->title;
        if (count($this->current_type) > 0) {
            if (isset($this->current_type["title"]) && !$is_type) {
                $title = $this->current_type["title"];
            }
        }
        $title = apply_filters("get_title_model", $title);
        return apply_filters("get_title_model_" . $this->plugin . "_" . $this->name, $title) . $add;
    }
    function init_header()
    {
        global $ViewData;
        $ViewData["DetailJustPageTitle"] = $this->get_title();
        $ViewData["AlertErrors"] = array();
        $ViewData["AlertSuccess"] = array();
        $ViewData["AlertWarnings"] = array();
        $ViewData["AlertMessages"] = array();
        $ViewData["ModelTitle"] = $this->get_title();
        $ViewData["ModelName"] = $this->plugin . "_" . $this->name;
        $ViewData["PluginName"] = $this->plugin;
        $ViewData["JustModelName"] =  $this->name;
        $ViewData["PageTitle"] = apply_filters("filter_pagetitle", PluginTitle . apply_filters("filter_pagetitle_sep", " | ") . $this->get_title());
    }
    function get_by_id($id = 0)
    {
        global $TR_db;
        $data = array();
        $result = $TR_db->pdo_json("select * from " . $this->plugin . "_" . $this->name);
        if (count($result) > 0) {
            $data = $result[0];
        }
        $data = apply_filters("filter_get_" . $this->plugin . "_" . $this->name, $data);
        return $data;
    }
    function insert($values)
    {
        global $TR_db;
        if (!$this->is_duplicate) {
            include "filters/duplicate-insert.php";
        }
        $logic = do_logic("logic_insert_" . $this->plugin . "_" . $this->name, $values, $this->plugin, $this->name, $this->fields);
        $logic_all = do_logic("logic_insert", $values, $this->plugin, $this->name, $this->fields);
        $logic = $logic * $logic_all;
        $id = 0;
        $begined = $TR_db->begin;
        if ($logic == 1) {
            $insert_fields = $this->field_tools->get_field_name_insert($values);

            $sql = "insert into " . $this->plugin . "_" . $this->name . "(" . $insert_fields . ") values(" . $this->field_tools->get_field_value_insert($values, false) . ");";

            $TR_db->begin();
            $values = apply_filters("filter_insert_" . $this->plugin . "_" . $this->name, $values, $this->plugin, $this->name, $this->fields);
            $values =  apply_filters("filter_insert", $values, $this->plugin, $this->name, $this->fields);
            do_action("before_insert_" . $this->plugin . "_" . $this->name, $values, $this->plugin, $this->name, $this->fields);
            do_action("before_insert", $values, $this->plugin, $this->name, $this->fields);

            $params = $this->field_tools->get_field_value_insert($values, true);
            // echo $sql;
            // var_dump($params);
            $id = $TR_db->pdo_exc($sql, $params);
            if (!is_numeric($id)) {
                send_admin_alert($id);
            }
            $values[$this->primary_field->name] = $id;
            do_action("after_insert_" . $this->plugin . "_" . $this->name, $values, $this->plugin, $this->name, $this->fields);
            do_action("after_insert", $values, $this->plugin, $this->name, $this->fields);
            if ($id > 0) {
                if (!$begined) {
                    $TR_db->commit();
                }
            } else {
                if (!$begined) {
                    $TR_db->rollBack();
                }
            }
        }
        return $id;
    }
    function delete($input_id)
    {
        global $TR_db;
        $logic = do_logic("logic_delete_" . $this->plugin . "_" . $this->name, $input_id, $this->plugin, $this->name, $this->fields, $this->primary_field->name);
        $logic_all = do_logic("logic_delete", $input_id, $this->plugin, $this->name, $this->fields, $this->primary_field->name);
        $logic = $logic *    $logic_all;
        $status = 0;
        $begined = $TR_db->begin;
        if ($logic == 1) {
            $sql = "delete from " . $this->plugin . "_" . $this->name . " where " . $this->primary_field->name . "=:id";

            $TR_db->begin();
            do_action("before_delete_" . $this->plugin . "_" . $this->name, $input_id, $this->plugin, $this->name, $this->fields, $this->primary_field->name);
            do_action("before_delete", $input_id, $this->plugin, $this->name, $this->fields, $this->primary_field->name);
            $status = $TR_db->pdo_exc($sql, array(":id" => $input_id));
            if (!is_numeric($status)) {
                send_admin_alert($status);
            }
            do_action("after_delete_" . $this->plugin . "_" . $this->name, $input_id, $this->plugin, $this->name, $status, $this->fields, $this->primary_field->name);
            do_action("after_delete", $input_id, $status, $this->plugin, $this->name, $this->fields, $this->primary_field->name);
            if (!$begined) {
                $TR_db->commit();
            }
        }
        return $status;
    }
    function update($values)
    {
        global $TR_db;
        if (!$this->is_duplicate) {
            include "filters/duplicate-update.php";
        }
        $logic = do_logic("logic_update_" . $this->plugin . "_" . $this->name, $values, $this->plugin, $this->name, $this->fields, $this->primary_field->name, $values[$this->primary_field->name]);
        // echo "logic_update_" . $this->plugin . "_" . $this->name." : ".$logic;
        $logic_all = do_logic("logic_update", $values, $this->plugin, $this->name, $this->fields, $this->primary_field->name, $values[$this->primary_field->name]);
        $logic = $logic * $logic_all;
        $id = 0;
        $status = 0;
        $begined = $TR_db->begin;

        if ($logic == 1) {
            $TR_db->begin();
            $values = apply_filters("filter_update_" . $this->plugin . "_" . $this->name, $values, $this->plugin, $this->name, $this->fields, $this->primary_field->name, $values[$this->primary_field->name]);
            $values =  apply_filters("filter_update", $values, $this->plugin, $this->name, $this->fields, $this->primary_field->name, $values[$this->primary_field->name]);
            $sql = "update " . $this->plugin . "_" . $this->name . " set " . $this->field_tools->get_fields_update($values) . " where " . $this->primary_field->name . "='" . $values[$this->primary_field->name] . "'";
            do_action("before_update_" . $this->plugin . "_" . $this->name, $values, $this->plugin, $this->name, $this->fields, $this->primary_field->name, $values[$this->primary_field->name]);
            do_action("before_update", $values, $this->plugin, $this->name, $this->fields, $this->primary_field->name, $values[$this->primary_field->name]);

            $status = $TR_db->pdo_exc($sql, $this->field_tools->get_fields_update($values, true));
            if (!is_numeric($status)) {
                send_admin_alert($status);
            }
            do_action("after_update_" . $this->plugin . "_" . $this->name, $values, $status, $this->plugin, $this->name, $this->fields, $this->primary_field->name, $values[$this->primary_field->name]);
            do_action("after_update", $values, $status, $this->plugin, $this->name, $this->fields, $this->primary_field->name, $values[$this->primary_field->name]);
            if (!$begined) {
                $TR_db->commit();
            }
        }
        return $status;
    }
}
