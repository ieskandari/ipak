<?php
function get_tag($key = "")
{
    if (isset(sys\TR::$tags[$key])) {
        return apply_filters($key, sys\TR::$tags[$key]);
    } else {
        return apply_filters($key, $key);
    }
}
function _T($key = "")
{
    return get_tag($key);
}
function set_tag($key = "", $value = "")
{
    sys\TR::$tags[$key] = $value;
}
function set_option($title, $plugin, $data = array())
{
    global $TR_tools, $TR_db;

    $query = "select * from settings where title=:title";
    $rows = $TR_db->pdo_json($query, array(":title" => $title));
    $val = $TR_tools->json_encode($data);
    if (count($rows) > 0) {
        $query = "update settings set val=:val where title=:title";
        $TR_db->begin();
        $TR_db->pdo_exc($query, array(":title" => $title, ":val" => $val));
        $TR_db->commit();
    } else {
        $query = "insert into settings(title,val,plugin) values(:title,:val,:plugin)";
        $TR_db->begin();
        $TR_db->pdo_exc($query, array(":title" => $title, ":val" => $val, "plugin" => $plugin));
        $TR_db->commit();
    }
}
function get_query_params($index = -1)
{
    if (isset(sys\TR::$params[$index])) {
        return sys\TR::$params[$index];
    }
    return sys\TR::$params;
}
function get_option($title, $plugin)
{
    global $TR_tools, $TR_db;
    $query = "select * from settings where title=:title and plugin=:plugin";
    $rows = $TR_db->pdo_json($query, array(":title" => $title, ":plugin" => $plugin));
    if (count($rows) > 0) {
        return $TR_tools->json_decode($rows[0]["val"]);
    }
    return array();
}
function get_url_img($src)
{
    return BaseUrl . "np-content/uploads/" . $src;
}
function find_value_file($input, $url, $reps = array())
{
    // $input is the word being supplied by the user
    $handle = @fopen($url, "r");
    if ($handle) {
        while (!feof($handle)) {
            $entry_array = explode("=", fgets($handle));
            if (trim($entry_array[0]) == $input) {
                $word = $entry_array[1];
                foreach ($reps as $rep) {
                    $word = str_replace($rep, '', $word);
                }
                return $word;
            }
        }
        fclose($handle);
    }
    return '';
}
function get_plugin_info($params = array())
{
    $plugin = "";
    $sub_plugin = "";
    $tag = "";
    $debug = 0;
    if (isset($params["plugin"])) {
        $plugin = $params["plugin"];
    }
    if (isset($params["sub_plugin"])) {
        $sub_plugin = $params["sub_plugin"];
    }
    if (isset($params["tag"])) {
        $tag = $params["tag"];
    }
    if (isset($params["debug"])) {
        $debug = $params["debug"];
    }
    if ($debug > 0) {
    }
    if (strlen($plugin) > 0 && strlen($sub_plugin) == 0) {
        if (isset(sys\TR::$plugins[$plugin])) {
            if (strlen($tag) > 0) {
                if (isset(sys\TR::$plugins[$plugin]["info"][$tag])) {
                    return sys\TR::$plugins[$plugin]["info"][$tag];
                } else {
                    return '';
                }
            }
            return sys\TR::$plugins[$plugin];
        }
        if (strlen($tag) > 0) {
            return '';
        }
        return array();
    }
    if (strlen($plugin) > 0 && strlen($sub_plugin) > 0) {
        if (isset(sys\TR::$plugins[$plugin]["sub_plugins"][$sub_plugin])) {

            if (strlen($tag) > 0) {

                if (isset(sys\TR::$plugins[$plugin]["sub_plugins"][$sub_plugin]["info"][$tag])) {
                    return sys\TR::$plugins[$plugin]["sub_plugins"][$sub_plugin]["info"][$tag];
                }
            }
            return sys\TR::$plugins[$plugin][$sub_plugin];
        }
        if (strlen($tag) > 0) {
            return '';
        }
        return array();
    }
    return sys\TR::$plugins;
}
function T($key = "", $value = "")
{
    set_tag($key, $value);
}
function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
function get_field_data($row, $field, $export = false, $plugin = "", $model = "")
{
    $data = "";
    if ($field->has_fk()) {
        if(isset($row[$field->name . "_title"]))
        {
            $data = $row[$field->name . "_title"];
        }

        $data = apply_filters("filter_data", $data, $field, $row[$field->name], $field->fk["key"], $export);
        if (strlen($plugin) > 0) {
            $data = apply_filters("filter_data_" . $plugin . "_" . $model . "_" . $field->name, $data, $field, $row[$field->name], $field->fk["key"], $export, $row);
        }
    } else {
        $data = $row[$field->name];
        $data = apply_filters("filter_data", $data, $field, $export);
        if (strlen($plugin) > 0) {
            $data = apply_filters("filter_data_" . $plugin . "_" . $model . "_" . $field->name, $data, $field, $export, $row);
        }
    }
    return $data;
}
function send_admin_alert($message, $type = "danger")
{
    $flag = true;
    foreach (sys\TR::$admin_alerts as $alert) {
        if ($alert["type"] == $type && $alert["message"] == $message) {
            $flag = false;
        }
    }
    if ($flag) {
        sys\TR::$admin_alerts[] = array("message" => $message, "type" => $type);
    }
}
function get_view_field($field)
{
    global $ViewData;
    $ViewData["OtherClass"] = "form-control-warning";
    if (isset($field->attr["col-class"])) {
        $ViewData["ColClass"] = $field->attr["col-class"];
    } else {
        unset($ViewData["ColClass"]);
    }
    include BasePath . "sys/manage_data/view/fields/fields.php";
}
function add_alert_admin($message, $type = "danger")
{
    send_admin_alert($message, $type);
}
function check_active_plugin($plugin)
{
    return sys\check_active_plugin($plugin);
}
function add_menu($tag, $title, $link, $plugin, $is_show = true, $icon = "fa fa-list")
{
    sys\TR::$menu[$plugin . "_" . $tag] = array("tag" => "admin/" . $tag, "title" => $title, "link" => $link, "plugin" => $plugin, "is_show" => $is_show, "icon" => $icon);
}
function add_permission($tag, $title, $plugin)
{
    sys\TR::$menu[$plugin . "_" . $tag] = array("tag" => "admin/" . $tag, "title" => $title, "link" => "", "plugin" => $plugin, "is_show" => false, "icon" => "");
}
function get_permission($key)
{
    if (isset(sys\TR::$permission[$key]) || is_admin()) {
        return true;
    }
    return false;
}
function register_model_type($plugin, $model, $tag)
{
    if (!isset($tag["name"])) {
        return;
    }
    if (!isset(sys\TR::$models_type[$plugin])) {
        sys\TR::$models_type[$plugin] = array($model => array($tag["name"] => $tag["name"]));
    }
    sys\TR::$models_type[$plugin][$model][$tag["name"]] = $tag;
    $title = $tag["name"];
    if (isset($tag["title"])) {
        $title = $tag["title"];
    }
    add_menu($plugin . "_" . $tag["name"], $title, BaseUrl . $plugin . "/" . $tag["name"], $plugin, true);
}
function get_model_type($tag)
{
    $model = array();
    foreach (sys\TR::$models_type as $key_plugin => $plugin) {
        foreach ($plugin as $key_model => $model) {
            foreach ($model as $type) {

                if (isset($type["name"]) && $type["name"] == $tag) {
                    sys\TR::$models[$key_plugin][$key_model]->current_type = $type;
                    return sys\TR::$models[$key_plugin][$key_model];
                }
            }
        }
    }

    return 0;
}
function get_gallery($json, $params = array())
{
    global $TR_tools;
    $size = "-max";
    $is_array = true;
    if (isset($params["size"])) {
        if ($params["size"] == "200" || $params["size"] == "300" || $params["size"] == "400" || $params["size"] == "500") {
            $size = "-" . $params["size"];
        }
        if ($params["size"] == "100") {
            $size = "-100";
        }
    }
    if (isset($params["is_array"])) {
        $is_array = $params["is_array"];
    }
    $gallery = array();
    $data = $TR_tools->json_decode($json);
    if (is_array($data)) {
        foreach ($data as $img) {
            $gallery[] = array("src" => BaseUrl . "np-content/uploads" . $size . "/" . $img);
        }
    }
    if (!$is_array) {
        if (count($gallery) > 0) {
            return $gallery[0];
        }
        return "";
    }
    return $gallery;
}
function get_gallery_json($field)
{
    global $TR_tools;
    if ($field->is_gallery) {
        $gallery = array();
        foreach ($_POST as $key => $item) {
            $numb = str_replace($field->name . "_", '', $key);
            if (is_numeric($numb) && !isset($fields[$key])) {
                $gallery[$key] = $item;
            }
        }
        if (count($gallery) > 0) {
            $json = $TR_tools->json_encode($gallery);
            return $json;
        }
    }
    return "";
}
function get_menu($plugin)
{
    $data = array();
    foreach (sys\TR::$menu as $key => $menu) {
        if ($menu["plugin"] == $plugin) {
            $data[$key] = $menu;
        }
    }
    return apply_filters("menu_admin", $data);
}
function get_plugin_model($model, $def_plugin = "")
{
    $data = '';
    $ex = explode("/", $model);
    if (count($ex) > 1) {
        $data = $ex[0] . "_" . $ex[1];
    } else {
        $data = $def_plugin . "_" . $ex[0];
    }
    return $data;
}
function get_plugin_model_array($model, $def_plugin = "")
{
    $data = array();
    $ex = explode("/", $model);
    if (count($ex) > 1) {
        $data["plugin"] = $ex[0];
        $data["model"] = $ex[1];
    } else {
        $data["plugin"] = $def_plugin;
        $data["model"] = $ex[0];
    }
    return $data;
}
function get_jalali_year($year = 0)
{
    global $TR_tools;
    if ($year<=0) {
        $year = $TR_tools->to_jalali(date('Y-m-d H:i:s'), "Y");
    }  
    return $year;
}
function get_range_month($year = 0)
{
    global $TR_tools;
    if ($year<=0) {
        $year = $TR_tools->to_jalali(date('Y-m-d H:i:s'), "Y");
    }
    $range = array();
    $range[] = array("title" => "فروردین", "from" => $year . "/1/1", "to" => $year . "/1/31");
    $range[] = array("title" => "اردیبهشت", "from" => $year . "/2/1", "to" => $year . "/2/31");
    $range[] = array("title" => "خرداد", "from" => $year . "/3/1", "to" => $year . "/3/31");
    $range[] = array("title" => "تیر", "from" => $year . "/4/1", "to" => $year . "/4/31");
    $range[] = array("title" => "مرداد", "from" => $year . "/5/1", "to" => $year . "/6/31");
    $range[] = array("title" => "شهریور", "from" => $year . "/6/1", "to" => $year . "/6/31");
    $range[] = array("title" => "مهر", "from" => $year . "/7/1", "to" => $year . "/7/30");
    $range[] = array("title" => "آبان", "from" => $year . "/8/1", "to" => $year . "/8/30");
    $range[] = array("title" => "آذر", "from" => $year . "/9/1", "to" => $year . "/9/30");
    $range[] = array("title" => "دی", "from" => $year . "/10/1", "to" => $year . "/10/30");
    $range[] = array("title" => "بهمن", "from" => $year . "/11/1", "to" => $year . "/11/30");
    $range[] = array("title" => "اسفند", "from" => $year . "/12/1", "to" => $year . "/12/30");
    return $range;
}
function Redirect($url, $new_tab = false)
{

    if ($new_tab) {
        echo "<script>var win = window.open('" . $url . "', '_blank');
          win.focus();</script>";
    } else {
        echo "<script>window.location.href='" . $url . "'</script>";
    }
}
function set_session($key, $value)
{
    $_SESSION[$key] = $value;
}
function get_session($key)
{
    $value = "";
    if (isset($_SESSION[$key])) {
        $value = $_SESSION[$key];
    } else {
        $value = "";
    }
    return $value;
}
function get_concat($tit)
{
    $concat = "'" . " " . "'";

    $ex_title = explode(",", $tit);
    $vi = "";
    $co = "concat(";

    foreach ($ex_title as $item) {
        $co = $co . $vi . "" . $item;
        $vi = "," . $concat . ",";
    }
    $co = $co . ")";
    return $co;
}
