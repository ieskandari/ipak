<?php
$query = "";
$model = $_GET["api_select"];
$field_key = $_GET["field_key"];
$just_model = $_GET["just_model"];
$just_plugin = $_GET["just_plugin"];
$has_parent_json = $_GET["has_parent_json"];
$has_parent_json_field = $_GET["has_parent_json_field"];
$key = "";
$tit = $_GET["field_name"];
$field_id = "";
if (isset($_GET["field_id"])) {
    $field_id = $_GET["field_id"];
}
$field_name = get_concat($tit);
$or_field_id = "";
if (isset($_GET["key"])) {
    $key = " where (" . $_GET["key"] . "=" . "'" . $_GET["key_value"] . "' and 1=1) ";
    if (isset($_GET["or_field_id"])) {
        $or_field_id = " or " . $field_id . "=" . $_GET["or_field_id"];
    }
}


$like = "";
if (isset($_GET["word"])) {
    $like = " where name like " . "'%" . $_GET["word"] . "%'";
}
$count = apply_filters("count_drop_down", 50);
$count = 100;
$query = "select * from(select " . $field_id . " as id," . $field_name . " as name from " . $model . $key . $or_field_id . ") as tpl" . $like . ' order by id  limit ' . $count;
$data_kham = $TR_db->pdo_json($query);
$data = array();
$ff_key = $field_key;
if ($has_parent_json == 1) {
    $ff_key = $has_parent_json_field;
}

   // $data[]=array("id"=>1000,"name"=>$just_plugin.'_'.$just_model." ".$field_key." ");
if (isset(sys\TR::$models[$just_plugin][$just_model])&&isset(sys\TR::$models[$just_plugin][$just_model]->fields[$ff_key])) {
    $index = 0;
    $field_model = sys\TR::$models[$just_plugin][$just_model]->fields[$ff_key];

    foreach ($data_kham as $key => $item) {
        if ($field_model->is_parent||$field_model->show_parent) {
            $my_row = array($field_model->name => $item["id"], $field_model->name . "_title" => $item["name"]);
            $get_name = get_field_data($my_row, $field_model);
            if (strlen($get_name) == 0) {
                $get_name = $item["name"];
            }
            $data[] = array("id" => $item["id"], "name" => $get_name);
        } else {
            $data[] = array("id" => $item["id"], "name" => $item["name"]);
        }
    }
} else {
    $index = 0;
    foreach ($data_kham as $key => $item) {
        $data[] = array("id" => $item["id"], "name" => $item["name"]);
    }
}
