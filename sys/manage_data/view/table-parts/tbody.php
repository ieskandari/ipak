<tbody>
    <?php
    do_action("before_tbody");
    do_action("before_tbody_" . $ViewData["ModelName"]);
    ?>
    <?php include "tbody-search-row.php";  ?>
    <?php
    $row = ($ViewData["TableDataPage"] - 1) * $ViewData["TableDataPageSize"];
    $menu = '<div class="table-menu" id="table-menu-1">
    <div onclick="set_item_detail_modal($(this));" class="item-menu" data-toggle="modal" data-target="#detail-modal">'._T("detail").'</div>
    <div class="item-menu item-edit"><a href="">'._T("edit").'</a></div>
    <div onclick="set_item_delete_modal($(this));" class="item-menu" data-toggle="modal" data-target="#delete-modal">'._T("delete").'</div>
</div>';
    foreach ($ViewData["TableData"] as $item) {
        $row++;
        echo '<tr data-id="' . $item["primary__key__id"] . '">';
        if($ViewData["ShowBtns"])
        {
            echo '<td title="' . _T("select") . '" class="first-td"><input type="checkbox" /></td>';
        }
        else
        {
            echo '<td class="first-td"></td>';
        }
       
        echo '<td class="second-td">' . $row . '</td>';
        foreach ($ViewData["HeaderData"] as $field) {
            $data = "";
            if (isset($item[$field->name])) {
            $data=get_field_data($item,$field,false,$ViewData["PluginName"],$ViewData["JustModelName"]);
             }
             if($field->file=="img")
             {
                $imt=BaseUrl."upload/". $data;
                echo '<td><a target="_blank" href="'.BaseUrl."upload/upload-max/".$data.'"><img src="' .  $imt. '" /></a></td>';
             }
             else
             {
                echo '<td title="' . $data . '">' . $data . '</td>';
             }
        }
        include "btns_data.php";
        if($ViewData["ShowBtns"]&&!$ViewData["NoAction"])
        {
            $btns=apply_filters("btn_option_".$ViewData["PluginName"]."_".$ViewData["JustModelName"],"",$item["primary__key__id"],$item);
            echo '<td class="last-td" ><div title="عملیات" class="operation" data-id="' . $item["primary__key__id"] . '"></div>' . $menu .$btns. '</td>';
            
        }
        else
        {
            echo '<td class="last-td" ></td>';

        }
      
        echo '</tr>';
        $menu = '';
    }
    include "tbody-results.php";
    ?>
    <?php
        do_action("after_tbody_" . $ViewData["ModelName"]);
    do_action("after_tbody");
    ?>
</tbody>
<?php include "tbody-scripts.php"; ?>