<?php
include "header.php";
?>
<h4 class="page-title" >مجموعه برنامه های ماژولار تحت وب ایپک</h4>
<hr>
<?php do_action("before_admin_home_" . $CurrentPlugin);  ?>
<div class="plugin-box">
    <?php
    asort($ViewData["Plugins"]);
    echo '<div class="row">';
    foreach ($ViewData["Plugins"] as $key => $item) {
        $img = "";
        $info = get_plugin_info(array("plugin" => $key, "tag" => "description", "debug" => 1));
        $url = PluginPath . $key  . "/" . $key . ".png";
        if (file_exists(stream_resolve_include_path($url))) {
            $img = '<img src="' . BaseUrl . "plugins/" . $key . "/" . $key . ".png" . '" />';
        }
        echo '<a title="' . $info . '" href="' . BaseUrl . $key . '/admin/dashboard"><div class="col-md-2 plugin-item"><label>' . $item . '</label>'.$img .'<div class="desctop-additinal-label">'.apply_filters("filter_desctop_".$key,"").'</div>' . '</div></a>';
    }
    echo '</div>';
    ?>
</div>
<hr>
<?php do_action("after_admin_home_" . $CurrentPlugin);  ?>
<?php
include "footer.php";
?>