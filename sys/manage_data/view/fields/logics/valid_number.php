<?php
$required="required";
if($field->is_form_filter)
{
    $required="";
}
    $str = "";
    if (!$field->nullable&&!$field->is_form_filter) {
        $str = $field->get_title($ViewData["ModelName"]) . " " . "نباید خالی بماند";
        $str_valid = $required.'  oninvalid="this.setCustomValidity(\'' . $str . '\')"';
    }
    if (isset($field->attr["min"]) && isset($field->attr["max"])) {
        $str = $field->get_title($ViewData["ModelName"]) . " " . "باید بزرگتر از" . " " . $field->attr["min"] . " " . "و کوچکتر از" . " " . $field->attr["max"] . " " . "باشد";
        $str_valid = $required.'  oninvalid="this.setCustomValidity(\'' . $str . '\')"';
    } else if (isset($field->attr["min"])) {
        $str = $field->get_title($ViewData["ModelName"]) . " " . "باید بزرگتر از" . " " . $field->attr["min"] . " " . "باشد";
        $str_valid = $required.'  oninvalid="this.setCustomValidity(\'' . $str . '\')"';
    } else if (isset($field->attr["max"])) {
        $str = $field->get_title($ViewData["ModelName"]) . " " . "باید کوچکتر از" . " " . $field->attr["max"] . " " . "باشد";
        $str_valid = $required.'  oninvalid="this.setCustomValidity(\'' . $str . '\')"';
    }