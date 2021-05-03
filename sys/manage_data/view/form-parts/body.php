<?php do_action("before-body-form-view"); ?>
<?php include "alert.php";  ?>
<div class="row">
    <?php
    foreach ($ViewData["FormFields"] as $field) {
        $ViewData["IsCurrency"]=$field->is_currency; 
        $ViewData["ValidateClass"] = "";
        if ($field->has_error) {
            $ViewData["ValidateClass"] = "form-control-danger";
        }
        if (isset($field->attr["col-class"])) {
            $ViewData["ColClass"] = $field->attr["col-class"];
        } else {
            unset($ViewData["ColClass"]);
        }
        if(($ViewData["Operation"]=="add")||$field->editable)
        {
            do_action("before_".$ViewData["ModelName"]."_form_field_".$field->name,$field);
            include BasePath . "sys/manage_data/view/fields/fields.php";   
            do_action("after_".$ViewData["ModelName"]."_form_field_".$field->name,$field);
        }
    }
    ?>
</div>
<?php do_action("after-body-form-view"); ?>