<?php
if (isset(sys\TR::$tree_relations[$this->plugin . "_" . $this->name])) {
    $value = get_user_setting($ViewData["ModelName"] . "_Form_EditId");
    $query="update ".$ViewData["ModelName"]." set ".$field->name."='".$_POST[$field->name]."' where ".$this->primary_field->name."=".$value;
    $result=$TR_db->pdo_exc($query);
  //  echo $query;
    foreach (sys\TR::$tree_relations[$this->plugin . "_" . $this->name] as $item) {
        $query = "select * from " . $item["plugin"] . "_" . $item["model"] . " where json_extract(" . $item["field"]->name . "_parentJson, '$.id_" . $value . "')='" . $value . "'";
       //echo $query;
        $data_json = $TR_db->pdo_json($query);
     // var_dump($data_json);
      //  var_dump($data_json);
      if(is_array($data_json))
      {
        $model = sys\TR::$models[$item["plugin"]][$item["model"]];
        foreach ($data_json as $kala) {
            $vals1 = $model->parentJson($item["field"], array($item["field"]->name => $kala[$item["field"]->name]));
            $query = "update " . $item["plugin"] . "_" . $item["model"] . " set " . $item["field"]->name . "_parentJson" . "='" . $vals1[$item["field"]->name . "_parentJson"] . "' where " . $model->primary_field->name . "='" . $kala[$model->primary_field->name] . "'";
            $TR_db->pdo_exc($query);
        }
      }
 
    }
}
