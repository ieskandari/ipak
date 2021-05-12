<?php
 if (!$field->nullable) {
    if (strlen($post) == 0) {
        $field->has_error = true;
        $ViewData["FormErrors"][] = $field->title . " : " . " " . _T("null-error");
    }
}