<?php
$values = array();
foreach ($fields as $field) {
    if (isset($_POST[$field->name])) {
        if ($field->type == "date" || $field->type == "datetime") {
            $values[$field->name] = sys\tools::to_miladi($_POST[$field->name]);
        } else {
            $values[$field->name] = $_POST[$field->name];
            if ($field->is_parent && $field->has_parent_json) {
                $values = $this->parentJson($field, $values);
            } else if ($field->is_parent && !$field->has_parent_json && $ViewData["Operation"] == "edit") {
                include "tree_submit.php";
            }
        }
    } 
    if($field->is_gallery)
    {
      $json=  get_gallery_json($field);
        if(strlen($json)>0)
        {
           $values[$field->name]=$json;
        }
    }
}
if ($ViewData["Operation"] == "add") {
    foreach ($this->fields as $field) {
        if ($field->type == "date" && $field->is_sys) {
            $values[$field->name] = date('Y-m-d');
        } else if ($field->type == "datetime" && $field->is_sys) {
            $values[$field->name] = date('Y-m-d H:i:s');
        }
    }
    $id = $this->insert($values);
    if ($id > 0) {
        set_user_setting($ViewData["ModelName"] . "_Form_EditId",$id);
        $ViewData["FormSuccess"][] = _T("insert-success");
        // unset($_POST);
    } else {
        $ViewData["FormErrors"][] = _T("submit-error");
    }
} else if ($ViewData["Operation"] == "edit") {
    $values[$ViewData["PrimaryField"]->name] = get_user_setting($ViewData["ModelName"] . "_Form_EditId");
   
    $id = $this->update($values);
    if ($id > 0) {
        $ViewData["FormSuccess"][] = _T("edit-success");
    } else {
        $ViewData["FormWarnings"][] = _T("submit-warning");
    }
    if(isset($ViewData["PageNoRedirect"])&&$ViewData["PageNoRedirect"])
    {
        
    }
      else
      {
          $name=$ViewData["JustModelName"];
        if(count($this->current_type)>0)
        {
            if(isset($this->current_type["name"]))
            {
               $name=$this->current_type["name"];
            }
        }
        Redirect(BaseUrl.$ViewData["PluginName"]."/".$name);
      }
}
