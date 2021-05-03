<?php
global $TR_db;
if (!function_exists('select_dependenc')) {
    function select_dependenc($dep, $prev_models = array())
    {
        global $TR_db, $ViewData;
        $where = "  ";
        $model = "";
        $just_model = "";
        $just_plugin = "";
        $tit = "";
        $key = "";
        $label = "";
        $name = "";
        $prev_model = "";
        $prev_model_name = "";
        $field_id = "";
        $field_name = "";
        $field_key_name='';
        $has_parent_json=0;
        $has_parent_json_field='';
        $title = "";
        if (count($prev_models) > 0) {
            $prev_model = $prev_models[count($prev_models) - 1]["name"];
            $prev_model_name = $prev_models[count($prev_models) - 1]["model"];
            $field_id = $prev_models[count($prev_models) - 1]["field_id"];
            $field_name = $prev_models[count($prev_models) - 1]["field_name"];
        }
        $plugin = $ViewData["PluginName"];
        if (is_array($dep)) {
            $model = $dep["model"];
            $tit = $dep["title"];
            $key = $dep["key"];
            $field_key_name=$dep["key"];
            $ex = explode("/", $model);
            $just_model=$dep["model"];
            if (count($ex) > 1) {
                $model = $ex[0] . "_" . $ex[1];
                $just_plugin=$ex[0] ;
                $just_model=$ex[1];
            } else {
                $model = $plugin . "_" . $model;
            }
            $label = $dep["label"];
            $name = $model . "_" . $dep["key"];

            $prev_models[] = array("name" => $name, "model" => $model, "key" => $key, "on_key" => $dep["on_key"], "field_id" => $key, "field_name" => $tit);
            if (isset($dep["dep"])) {
                $where = " where 1=0";
                $TempViewData = $ViewData;
                select_dependenc($dep["dep"], $prev_models);
                $ViewData = $TempViewData;
            }
        } else {
            $model = $dep->fk["model"];
            $tit = $dep->fk["title"];
            $key = $dep->fk["key"];
            $field_key_name="";
           if($dep->is_parent)
           {
            $field_key_name=$dep->name;  
           }
            $just_model=$model;
            if($dep->has_parent_json)
            {
                $has_parent_json=1;
                $has_parent_json_field=$dep->fk["parent_field"];
            }
            $ex = explode("/", $model);
            if (count($ex) > 1) {
                $just_plugin=$ex[0] ;
                $just_model=$ex[1];
                $model = $ex[0] . "_" . $ex[1];
            } else {
                $model = $plugin . "_" . $model;
            }
            if($dep->show_parent)
            {
                $just_plugin=$ViewData["PluginName"] ;
                $just_model=$ViewData["JustModelName"] ;
                $field_key_name=$dep->name;  
            }
            $label = $dep->title;
            $name = $dep->name;

            $prev_models[] = array("name" => $name, "model" => $model, "key" => $key, "on_key" => "", "field_id" => $key, "field_name" => $tit);
            if (isset($dep->fk["dep"])) {
                $where = " where 1=0 ";
                $TempViewData = $ViewData;
                select_dependenc($dep->fk["dep"], $prev_models);
                $ViewData = $TempViewData;
            }
        }

        $concat = "'" . " " . "'";

        $ex_title = explode(",", $tit);
        $vi = "";
        $co = "concat(";

        foreach ($ex_title as $item) {
            $co = $co . $vi . "" . $item;
            $vi = "," . $concat . ",";
        }
        $co = $co . ")";
        $title = $co;
        $count = apply_filters("count_drop_down", 50);

        if (!is_array($dep) && $dep->is_parent) {
            $count = 10;
        }

 
  



        $temp_name = $name;

        $on_key = "";
        $first_model_key = "";
        $first_model = "";
        if (count($prev_models) > 0 && $temp_name != $prev_models[0]["name"]) {
            $first_model_key = $prev_models[0]["name"];
            $first_model = $prev_models[0]["model"];
            $temp_name = $temp_name . "_" . $prev_models[0]["name"];
            if (strlen($prev_model) > 0 && $prev_model != $prev_models[0]["name"]) {
                $prev_model = $prev_model . "_" . $prev_models[0]["name"];
            }
        }
        if (count($prev_models) > 0) {
            $on_key = $prev_models[count($prev_models) - 1]["on_key"];
        }
        $reset = '';
        $vir = '';
        $change = '';
        foreach ($prev_models as $item) {
            if ($item["model"] != $model) {
                $m = '' . $item["model"] . '_' . $item["key"] . '_' . $first_model_key;
                if ($item["model"] == $first_model) {
                    $m = '' . $first_model_key;
                }

                $reset = $reset . '$(\'#' . $m . '\').html(\'<option value=\"0\">خالی</option>\');';
            }
        }

        //  echo ' <div>'.$prev_model_name.":".$on_key."</div>";
        $script_name = 'select_change_' . $temp_name;
        $ViewData["InputName"] =  $temp_name;
        $ViewData["TitleLabel"] =  $label;
        if (isset($_POST[$ViewData["InputName"]]) && $_POST[$ViewData["InputName"]] > 0) {
            $ViewData["InputClass"] =  $ViewData["Form-Control"] . " " . $ViewData["OtherClass"];
        } else {
            $ViewData["InputClass"] = $ViewData["Form-Control"];
        }
        $var_model = '';
       $union="";
        if (isset($_POST[$ViewData["InputName"]])) {
            $ViewData["InputValue"] = $_POST[$ViewData["InputName"]];
            $union=" union all select ".$key." as id ,".$title." as name from ".$model." where  ".$key."="."'".$ViewData["InputValue"]."'";
            $change = '$(\'#' . $ViewData["InputName"] . '\').change();';
            $var_model = 'var ' . $ViewData["InputName"] . '=' . $_POST[$ViewData["InputName"]] . ';';
        } else {
            $var_model = 'var ' . $ViewData["InputName"] . '=0;';
        }
        if(!is_array($dep))
        {
            if(isset($dep->fk["where"]))
            {
                $where=$where." where 1=1 ".$dep->fk["where"];
            }                
        }
        $query = "select * from (select * from(select " . $key . " as id," . $title . " as name from " . $model . $where . ') as tb order by tb.id desc limit ' . $count.") as tb_tb ".$union;
       //  echo $query;
        $data = $TR_db->pdo_json($query);
        $init_id = 'init_select_' . $first_model_key . '';
        $set_init_id = 'init_select_' . $first_model_key . '=1;';
        if (strlen($on_key) > 0) {
            $ViewData["Attr"] =     $ViewData["Attr"] . ' model-name="' . $model . '" has-parent-json="'.$has_parent_json.'" has-parent-json-field="'.$has_parent_json_field.'" field-key="'.$field_key_name.'" just-model="'.$just_model.'" just-plugin="'.$just_plugin.'" field-id="' . $key . '" field-name="' . $tit . '" onclick="dropdown_on_click($(this));" onchange="' . $script_name . '($(this));"';
            eval('$fun_script_' . $temp_name . '=function(){
                echo "<script>
             
                ' . $var_model . '
                if($(\'#' . $ViewData["InputName"] . '\').children(\'option\').length>1)
                {
                    ' . $change . '
                }
                ' . $set_init_id . '
                     function ' . $script_name . '(obj){
                        dropdown_option_changed(obj);
                        if(start_select_init_dropdown==0)
                        {
                            dropdown_option_changed_flag=0; 
                            //console.log(\'s4:\'+dropdown_option_changed_flag);               
                            start_select_init_dropdown=1;
                        }
                        $.ajax({
                            type: \'POST\',
                            url: \'?api_select=' . $prev_model_name . '&key=' . $on_key . '&has_parent_json_field=' . $has_parent_json_field . '&has_parent_json=' . $has_parent_json . '&field_key=' . $field_key_name . '&just_plugin=' . $just_plugin . '&just_model=' . $just_model . '&or_field_id=\'+' . $prev_model . '+\'&key_value=\'+obj.val()+\'&field_id=' . $field_id . '&field_name=' . $field_name . '\',
                            data: {},
                            contentType: \'application/json; charset=utf-8\',
                            dataType: \'json\',
                            success: function (msg) {     
                                var jss = msg;
                                ' . $reset . '
                                var flag=0;
                                jss.forEach(function (item, index) {
                                 if(item.id==' . $prev_model . ')
                                 {
                                    start_select_init_dropdown=0;
                                    flag=1;
                                 }
                                   $(\'#' . $prev_model . '\').append(\'<option title=\"\'+item.name+\'\" value=\"\'+item.id+\'\">\'+item.name+\'</option>\');
                               });
                                 if(' . $prev_model . '>0 && flag==1)
                                 {
                                    $(\'#' . $prev_model . '\').val(' . $prev_model . ');
                                   
                                    $(\'#' . $prev_model . '\').change();   
                                    dropdown_option_changed_flag=0;      
                                    start_select_init_dropdown=1;                    
                                    ' . $prev_model . '=0;
                                 }
                             
                            },
                            error: function (error) {
                                //Message
                                console.error(error.responseText);
                            }
                        });
                     }
                </script>";
            };
            add_action("footer_scripts",$fun_script_' . $temp_name . ');');
        } else {
            $ViewData["Attr"] =     $ViewData["Attr"] . ' model-name="' . $model . '"  has-parent-json="'.$has_parent_json.'" has-parent-json-field="'.$has_parent_json_field.'" field-key="'.$field_key_name.'" just-model="'.$just_model.'" just-plugin="'.$just_plugin.'" field-id="' . $key . '"  field-name="' . $tit . '" onclick="dropdown_on_click($(this));" onchange="dropdown_option_changed($(this))"';

            eval('$fun_script_' . $temp_name . '=function(){
                echo "<script>
                ' . $var_model . '
                </script>";
            };
            add_action("footer_scripts",$fun_script_' . $temp_name . ');');
        }
        if(!is_array($dep))
        {
            $model_permission=get_plugin_model($dep->fk["model"]);
            if(get_permission($model_permission))
            {
                if(isset($dep->fk["main_model"]))
                {
             
                    $ViewData["SelectPluginModelName"]=$dep->fk["main_model"];
                }
                else
                {
                    $ViewData["SelectPluginModelName"]=$dep->fk["model"];
                }
               
            }
     
    
        }
        include "input-select-autocomplete.php";
    }
}

eval('$fun_script_init_select_' . $field->name . '=function(){
    echo "<script>
         var init_select_' . $field->name . '=0;
    </script>";
};
add_action("footer_scripts",$fun_script_init_select_' . $field->name . ',1);');
select_dependenc($field);
