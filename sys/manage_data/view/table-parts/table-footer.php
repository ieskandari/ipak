<?php
if (count($ViewData["Results"]["footer"])) {
    echo '<div class="box-table-results">';
    foreach ($ViewData["Results"]["footer"] as $item) {
        $res = apply_filters("result_table_" . $ViewData["PluginName"] . "_" . $ViewData["JustModelName"] . "_" . $item["tag"], $item["result"]);
        if (is_numeric($res)) {
            $res = number_format($res);
        }
        if($res==0)
        {
           continue;
        }
        echo '<div class="table-results">' . '<label class="table-results-label">' . $item["label"] . '</label>' . '<label class="table-results-result">' . $res . '</label>' . '</div>';
    }
    echo '</div>';
}