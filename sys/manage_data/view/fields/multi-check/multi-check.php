<?php
class multi_check
{
  function fill_checks()
  {
    global $ViewData, $TR_tools,$TR_db;
    $query = " select * from ipcommerce_category where parent_id = 0  ";
    $data = $TR_db->pdo_json($query);
    if (count($data) > 0) {
      $ViewData["MultiCheckValue"] = $data[0]["title"];
    }
    $tree = array();
    foreach ($data as $key_plugin => $plugin) {
      $children = array();
      if (count($plugin) > 0) {
          $children[] = array("id" => $plugin['slug'] . "_" . $plugin['id'], "text" => $plugin['title'], "children" => array());
      }
      $main_node = array("id" => $key_plugin, "text" => $plugin['title'] , "children" => $children);

      $tree[] = $main_node;
    }

    $ViewData["MultiCheckTree"] = $TR_tools->json_encode($tree);
    include "view/view.php";
  }
}
$multi_check = new multi_check;
$multi_check->fill_checks();
//add_action("ipcommerce_category", array($multi_check, "fill_checks"));
