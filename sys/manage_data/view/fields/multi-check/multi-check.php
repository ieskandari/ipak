<?php
if (!function_exists('multi_check')) {
  function multi_check($dep, $ViewData)
  {
    global  $TR_tools, $TR_db;
    $p_q = "";
    $parent = "";
    $model = str_replace('/', '_', $dep->mfk['model']);
    $key = $dep->mfk['key'];
    $title =  $dep->mfk['title'];
    if (isset($dep->mfk['parent'])) {
      $p_q = "," . $dep->mfk['parent'];
      $parent = $dep->mfk['parent'];
    }
    $query = " select $key,$title $p_q from $model  ";
    $data = $TR_db->pdo_json($query);
    $tree = array();
    foreach ($data as $row) {
      if (isset($dep->mfk['parent'])) {
        $main_node = array("id" => $row[$key], "text" => $row[$title], "$parent" => $row[$parent]);
      } else {
        $main_node = array("id" => $row[$key], "text" => $row[$title]);
      }
      $tree[] = $main_node;
    }
    $ViewData["MultiCheckTree" . $dep->name] = $TR_tools->json_encode($tree);
    include "view/view.php";
  }
}
add_action("footer_scripts", function () use ($field, $ViewData) {
});
multi_check($field, $ViewData);
