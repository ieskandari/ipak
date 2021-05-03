<?php
 if ($field->type == "string" || $field->type == "text" || $field->type == "int" || $field->type == "bigint") {
    if (strlen($post) > $field->size&&$field->file!="block") {
        $field->has_error = true;
        $ViewData["FormErrors"][] = $field->title . " : " . " " . _T("size-error");
    }
}