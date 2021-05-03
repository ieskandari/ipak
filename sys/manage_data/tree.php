<?php
$ViewData["PageTitle"] = apply_filters("filter_pagetitle","نمودار درختی"." ". PluginTitle . apply_filters("filter_pagetitle_sep", " | ") . $this->title);

$ViewData["TitleTree"]="نمودار درختی"." ".$this->title;
$field=$this->fields[$field_id];
$model=$field->fk["model"];
$ex=explode("/",$model);
$model=$ex[0]."_".$ex[1];
$other_model=sys\TR::$models[$ex[0]][$ex[1]];
$other_model_field=$other_model->fields[$field->fk["parent_field"]];
$query="select ".$this->primary_field->name." as id,".$field->name." as parent_id,".get_concat($field->fk["tree_title"])." as title from ".$this->plugin."_".$this->name;

$ViewData["ChildData"]=$TR_tools->json_encode($TR_db->pdo_json($query));
$query="select ".$other_model->primary_field->name." as id,".$other_model_field->name." as parent_id,".get_concat($field->fk["title"])." as title from ".$other_model->plugin."_".$other_model->name;
$ViewData["ParentData"]=$TR_tools->json_encode($TR_db->pdo_json($query));
include "view/tree.php";