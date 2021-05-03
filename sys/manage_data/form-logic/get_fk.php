<?php
$query = "select * from " . $ViewData["ModelName"] . " ";
$query = $query . " where " . $ViewData["PrimaryField"]->name . "=:id";

$Current_data = $TR_db->pdo_json($query, array(":id" => $_GET["edit_id"]));
if (count($Current_data) > 0) {
    foreach ($fields as $field) {
        if (isset($Current_data[0][$field->name])) {
            if ($field->type == "date" || $field->type == "datetime") {
                $_POST[$field->name] = sys\tools::to_shamsi($Current_data[0][$field->name]);
            } else {
                $_POST[$field->name] = $Current_data[0][$field->name];
            }
            if ($field->has_fk()) {
                if (isset($field->fk["dep"])) {
                    $model = $field->fk["model"];
                    $ex = explode("/", $model);
                    if (count($ex) > 1) {
                        $model = $ex[0] . "_" . $ex[1];
                    } else {
                        $model = $this->plugin . "_" . $model;
                    }
                    $query = "select * from " . $model . " where " . $field->fk["key"] . "=" . $Current_data[0][$field->name];
                    $row = $TR_db->pdo_json($query);

                    $flag = true;
                    $index = 0;
                    $dep = $field->fk["dep"];
                    if (count($row) > 0) {

                        while ($flag && $index < 21) {
                            $index++;
                            if ($index > 20) {
                                break;
                            }
                            $model = $dep["model"];
                            $ex = explode("/", $model);
                            if (count($ex) > 1) {
                                $model = $ex[0] . "_" . $ex[1];
                            } else {
                                $model = $this->plugin . "_" . $model;
                            }

                            $query = "select * from " . $model . " where " . $dep["key"] . "=" . $row[0][$dep["on_key"]];

                            $row = $TR_db->pdo_json($query);
                            if (count($row) > 0) {
                                $_POST[$model . "_" . $dep["key"] . "_" . $field->name] = $row[0][$dep["key"]];
                                echo $model . "_" . $dep["key"] . "_" . $field->name;
                                if (isset($dep["dep"])) {
                                    $dep = $dep["dep"];
                                } else {
                                    $flag = false;
                                    break;
                                }
                            } else {
                                $flag = false;
                                break;
                            }
                        }
                    }
                }
            }
        }
    }
}
