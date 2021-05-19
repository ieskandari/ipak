<?php
if (!isset($ViewData["ColClass"])) {
  $ViewData["ColClass"] = "col-xs-12 col-sm-3 col-md-2 col-lg-2";
}
$form_control = "form-control";

if (isset($ViewData["ValidateClass"])) {
  $form_control = $form_control . " " . $ViewData["ValidateClass"];
}
$ViewData["InputClass"] = $form_control;
$ViewData["Form-Control"] = $form_control;
$ViewData["LabelClass"] = "label-control";
$ViewData["TitleLabel"] = $field->get_title($ViewData["ModelName"]);
$ViewData["InputValue"] = "";
$ViewData["InputName"] = $field->name;
if(strlen($field->help)>0)
{
  $ViewData["InputHelp"]=$field->help;
}
else
{
  $ViewData["InputHelp"]="";
}
include "logics/number.php";
include "logics/date.php";
include "logics/filter.php";
include "logics/attr.php";
//
if (isset($_POST[$ViewData["InputName"]])) {
  $ViewData["InputValue"] = $_POST[$field->name];
}
do_action("before_filter_field_" . $ViewData["ModelName"] . "_" . $field->name);
switch ($field->type) {
  case "string": {
      include "input.php";
      break;
    }
  case "double": {
      if (strlen($ViewData["InputValue"]) == 0) {
        $ViewData["InputValue"] = 0;
      }
      include "double.php";
      break;
    }
  case "text":
  case "json": {
      if ($field->file == "img") {
        include "img.php";
      } else  if ($field->file == "gallery") {
        include "gallery.php";
      } else  if ($field->file == "block") {
       // $ViewData["ColClass"] = "col-xs-12 col-sm-12 col-md-12 col-lg-12";
        include "block.php";
      }else  if ($field->file == "mini-block") {
        //$ViewData["ColClass"] = "col-xs-12 col-sm-12 col-md-12 col-lg-12";
        include "mini-block.php";
      }  else {
        include "text.php";
      }
      break;
    }
  case "int":
  case "bigint": {
      if ($field->has_fk()) {
        if (isset($_POST[$ViewData["InputName"]]) && $_POST[$ViewData["InputName"]] > 0) {
          $ViewData["InputClass"] =  $form_control . " " . $ViewData["OtherClass"];
        } else {
          $ViewData["InputClass"] = $form_control;
        }
        include "select/select.php";
      } else {
        if ($is_range) {
          $ViewData["TitleLabel"] = "از" . " " . $field->get_title($ViewData["ModelName"]);
          $ViewData["InputName"] = "from_" . $field->name;
          if (isset($_POST[$ViewData["InputName"]])) {
            $ViewData["InputValue"] = $_POST[$ViewData["InputName"]];
            if (strlen($ViewData["InputValue"]) > 0) {
              $ViewData["InputClass"] =  $form_control . " " . $ViewData["OtherClass"];
            } else {
              $ViewData["InputClass"] = $form_control;
            }
          }
          include "number.php";
          $ViewData["TitleLabel"] = "تا" . " " . $field->get_title($ViewData["ModelName"]);
          $ViewData["InputName"] = "to_" . $field->name;
          if (isset($_POST[$ViewData["InputName"]])) {
            $ViewData["InputValue"] = $_POST[$ViewData["InputName"]];
            if (strlen($ViewData["InputValue"]) > 0) {
              $ViewData["InputClass"] =  $form_control . " " . $ViewData["OtherClass"];
            } else {
              $ViewData["InputClass"] = $form_control;
            }
          }
          include "number.php";
        } else {
          if (isset($ViewData["InputValue"]) && strlen($ViewData["InputValue"]) > 0) {
            $ViewData["InputClass"] =  $form_control . " " . $ViewData["OtherClass"];
          } else {
            $ViewData["InputClass"] = $form_control;
          }
          if (strlen($ViewData["InputValue"]) == 0) {
            $ViewData["InputValue"] = 0;
          }
          if ($ViewData["IsCurrency"]) {
            include "currency.php";
          } else {
            include "number.php";
          }
        }
      }
      break;
    }
  case "date":
  case "datetime": {
      if ($is_range) {
        $ViewData["TitleLabel"] = "از" . " " . $field->get_title($ViewData["ModelName"]);
        $ViewData["InputName"] = "from_" . $field->name;
        $ViewData["InputValue"] = sys\tools::to_shamsi(date('Y-m-d', strtotime(date("Y-m-d") . ' - 10 years')));
        if (isset($_POST[$ViewData["InputName"]])) {
          $ViewData["InputValue"] = $_POST[$ViewData["InputName"]];
          $ViewData["InputClass"] =  $form_control . " " . $ViewData["OtherClass"];
        }
        include "date.php";
        $ViewData["TitleLabel"] = "تا" . " " . $field->get_title($ViewData["ModelName"]);
        $ViewData["InputName"] = "to_" . $field->name;
        $ViewData["InputValue"] = sys\tools::to_shamsi(date('Y-m-d', strtotime(date("Y-m-d") . ' - 0 days')));
        if (isset($_POST[$ViewData["InputName"]])) {
          $ViewData["InputValue"] = $_POST[$ViewData["InputName"]];
          $ViewData["InputClass"] =  $form_control . " " . $ViewData["OtherClass"];
        }
        include "date.php";
      } else {
        $ViewData["InputValue"] = sys\tools::to_shamsi(date('Y-m-d', strtotime(date("Y-m-d") . ' - 0 days')));
        if (isset($_POST[$ViewData["InputName"]])) {
          $ViewData["InputValue"] = $_POST[$ViewData["InputName"]];
          $ViewData["InputClass"] =  $form_control . " " . $ViewData["OtherClass"];
        }
        include "date.php";
      }
      break;
    }
    case "multi-check": {
      include "multi-check/multi-check.php";
    }
}
do_action("after_filter_field_" . $ViewData["ModelName"] . "_" . $field->name);
