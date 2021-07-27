<?php
if (!function_exists('multi_check')) {
  function multi_check($dep, $ViewData)
  {
    global  $TR_tools, $TR_db;
    $p_q = "";
    $p_w = "";
    $parent = "";
    $model = str_replace('/', '_', $dep->mfk['model']);
    $key = $dep->mfk['key'];
    $title =  $dep->mfk['title'];
    if (isset($dep->mfk['parent'])) {
      $p_q = "," . $dep->mfk['parent'];
      $parent = $dep->mfk['parent'];
      $p_w = " where $parent = 0 or $parent is null ";
    }
    $tree = array();

    $query = " select $key,$title $p_q from $model $p_w ";
    $data = $TR_db->pdo_json($query);
    foreach ($data as $row) {
      if (isset($dep->mfk['parent'])) {
        $main_node = array("id" => $row[$key], "text" => $row[$title], "children" => make_child($row[$key], $dep));
      } else {
        $main_node = array("id" => $row[$key], "text" => $row[$title]);
      }
      $tree[] = $main_node;
    }
    
    $ViewData["MultiCheckTree" . $dep->name] = $TR_tools->json_encode($tree);
    include "view/view.php";
  }
}
if (!function_exists('make_child')) {
  function make_child($id, $dep)
  {
    global  $TR_tools, $TR_db;
    $p_q = "";
    $p_w = "";
    $parent = "";
    $model = str_replace('/', '_', $dep->mfk['model']);
    $key = $dep->mfk['key'];
    $title =  $dep->mfk['title'];
    if (isset($dep->mfk['parent'])) {
      $p_q = "," . $dep->mfk['parent'];
      $parent = $dep->mfk['parent'];
      $p_w = " where $parent = $id ";
    }
    $children = array();

    $query = " select $key,$title $p_q from $model $p_w ";

    $data = $TR_db->pdo_json($query);
    foreach ($data as $row) {
      $main_node = array("id" => $row[$key], "text" => $row[$title], "children" => make_child($row[$key], $dep));
      $children[] = $main_node;
    }
    return $children;
  }
}
//add_action("footer_scripts", function () use ($field, $ViewData) {});
multi_check($field, $ViewData);
