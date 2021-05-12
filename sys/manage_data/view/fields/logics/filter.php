<?php
$is_range = false;
$str_valid = "";
$ViewData["Is_form_filter"]=$field->is_form_filter;
if (!$field->is_form_filter) {

    if (isset($field->attr["col-class"])) {
        $ViewData["ColClass"] = $field->attr["col-class"];
    }
    if (isset($field->attr["input-class"])) {
        $ViewData["InputClass"] = $field->attr["class"];
    }
    if (isset($field->attr["label-class"])) {
        $ViewData["LabelClass"] = $field->attr["label-class"];
    }
} else {
    if ($field->type == "int" || $field->type == "bigint" || $field->type == "date" || $field->type == "datetime") {
        $is_range = true;
    }
}
$ViewData["OnValid"] = $str_valid;
