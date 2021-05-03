<?php
if (count($ViewData["Results"]["fields"]) == 0) {
    return;
}
if (!isset($ViewData["HeaderData"])) {
    $ViewData["HeaderData"] = $ViewData["PrintHeader"];
    echo '<tr>';
    echo '<td>' . _T("sum") . '</td>';
    foreach ($ViewData["HeaderData"] as $field) {
        $data = "";
        if (isset($ViewData["Results"]["fields"][$field->name])) {
            $data = $ViewData["Results"]["fields"][$field->name];
            $data = apply_filters("table_results_" . $ViewData["PluginName"] . "_" . $ViewData["JustModelName"] . "_" . $field->name, $data);
            if (is_numeric($data)) {
                $data = number_format($data);
            }
        }
        echo '<td title="' . $data . '">' . $data . '</td>';
    }
    echo '</tr>';
} else {
    echo '<tr>';
    echo '<td class="first-td"></td>';
    echo '<td class="second-td">' . _T("sum") . '</td>';
    foreach ($ViewData["HeaderData"] as $field) {
        $data = "";
        if (isset($ViewData["Results"]["fields"][$field->name])) {
            $data = $ViewData["Results"]["fields"][$field->name];
            $data = apply_filters("table_results_" . $ViewData["PluginName"] . "_" . $ViewData["JustModelName"] . "_" . $field->name, $data);
            if (is_numeric($data)) {
                $data = number_format($data);
            }
        }
        echo '<td title="' . $data . '">' . $data . '</td>';
    }
    echo '<td class="last-td" ></td>';
    echo '</tr>';
}
