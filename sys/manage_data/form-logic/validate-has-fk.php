<?php
   if ($field->has_fk()) {
    if ($post == 0&&!$field->nullable) {
        $field->has_error = true;
        $ViewData["FormErrors"][] = $field->title . " : " . " " . _T("null-error");
    }
}