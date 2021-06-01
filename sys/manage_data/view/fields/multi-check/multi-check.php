<?php
class multi_check
{
  function fill_checks()
  {
    global $ViewData, $TR_tools, $TR_db;
    $query = " select * from ipcommerce_category  ";
    $data = $TR_db->pdo_json($query);
    $tree = array();
    foreach ($data as $key_plugin => $plugin) {
      $children = array();
      //if (count($plugin) > 0) {
      //    $children[] = array("id" => $plugin['slug'] . "_" . $plugin['id'], "text" => $plugin['title'], "children" => array());
      //}
      $main_node = array("id" => $key_plugin, "text" => $plugin['title'], "parent_id" => $plugin['parent_id'], "children" => $children);

      $tree[] = $main_node;
    }

    $ViewData["MultiCheckTree"] = $TR_tools->json_encode($tree);
    include "view/view.php";
  }
}
$multi_check = new multi_check;
$multi_check->fill_checks();
//add_action("ipcommerce_category", array($multi_check, "fill_checks"));
