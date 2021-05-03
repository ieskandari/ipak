<?php
$data = array();
$data["is_group"] = $_POST["is_group"];
$data["title"] = $_POST["title"];
$data["address"] = $_POST["address"];
$data["desc"] = $_POST["desc"];
$data["logo"] = $_POST["logo"];

global $TR_db, $TR_tools;
$title = $ViewData["PluginName"] . "_" . $ViewData["JustModelName"] . "_" . "print_" . $data["is_group"];
set_option($title,$ViewData["PluginName"],$data);
