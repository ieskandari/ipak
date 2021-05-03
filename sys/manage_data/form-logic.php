<?php
$ViewData["FormErrors"] = array();
$ViewData["FormSuccess"] = array();
$ViewData["FormWarnings"] = array();
$ViewData["FormMessages"] = array();
global $TR_db;
$is_post = false;
if ($ViewData["Operation"] == "add") {
    set_user_setting($ViewData["ModelName"] . "_Form_EditId", "");
}
if (isset($_GET["edit_id"])) {
    set_user_setting($ViewData["ModelName"] . "_Form_EditId", $_GET["edit_id"]);
}
$ViewData["EditId"] = get_user_setting($ViewData["ModelName"] . "_Form_EditId");
if (strlen($ViewData["EditId"]) == 0) {
    $ViewData["EditId"] = 0;
}
foreach ($fields as $field) {
    if (isset($_POST[$field->name])&&(!$field->identity)) {
        $is_post = true;
        $post = $_POST[$field->name];
        include "form-logic/validate.php";
        do_action("form_validate_field_".$ViewData["ModelName"]."_".$field->name,$post,$field);
    }
    else if($field->identity&&isset($_POST[$field->name]))
    {
        $post = $_POST[$field->name];
    }
}

if ($is_post && count($ViewData["FormErrors"])==0) {
    include "form-submit.php";
}

if (isset($_GET["edit_id"])) {
    include "form-logic/get_fk.php";
}
$this->get_group_by_form();
