<?php
if ($field->is_uniq&&strlen(trim($post))>0) {
    $post = trim($post);

    $query = "select * from " . $ViewData["ModelName"] . " where " . $field->name . "=:username";
    if ($ViewData["EditId"] > 0) {
        $query = $query . " and " . $ViewData["PrimaryField"]->name . "<>" . $ViewData["EditId"];
    }
    $ex = $TR_db->pdo_json($query, array(":username" => $post));
    if (count($ex) > 0) {
        $field->has_error = true;
        $ViewData["FormErrors"][] = $field->title . " : " . " " . _T("uniq-error");
    }
}