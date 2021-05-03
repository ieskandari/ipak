<?php
if (isset($ViewData["TableData"])) {
?> 
    <div class="panel panel-info">
        <div class="panel-heading"><?php echo $ViewData["DetailJustPageTitle"]; ?></div>
        <div class="panel-body">
            <div class="group-by-header">
                <div class="row">
                    <?php
                    foreach ($ViewData["GroupByData"]["fields"] as $field) {
                        $value="";
                        if(count($ViewData["TableData"])>0)
                        {
                            $value = get_field_data($ViewData["TableData"][0],$field["field_model"], false, $ViewData["PluginName"], $ViewData["JustModelName"]);
                        }
                        echo '<div class="col-md-4"><label class="title">'.$field["field_model"]->title.'</label><label class="value">'.$value.'</label></div>';
                    }
                    ?>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th class="second-th">
                            <?php echo 'ردیف';  ?>
                        </th>
                        <?php
                        foreach ($ViewData["HeaderData"] as $field) {
                            if (isset($ViewData["GroupByData"]["fields"][$field->name])) {
                                continue;
                            }
                            echo '<th>' . apply_filters("table_th_" . $field->name . "_" . $ViewData["ModelName"], $field->get_title($ViewData["ModelName"])) . '</th>';
                        }
                        ?>
                        <th class="last-th"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $row = 0;
                    foreach ($ViewData["TableData"] as $item) {
                        $row++;
                        echo '<tr data-id="' . $item["primary__key__id"] . '">';

                        echo '<td class="second-td">' . $row . '</td>';
                        foreach ($ViewData["HeaderData"] as $field) {
                            if (isset($ViewData["GroupByData"]["fields"][$field->name])) {
                                continue;
                            }
                            $data = "";
                            if (isset($item[$field->name])) {
                                $data = get_field_data($item, $field, false, $ViewData["PluginName"], $ViewData["JustModelName"]);
                            }
                            echo '<td title="' . $data . '">' . $data . '</td>';
                        }
                        echo '<td class="last-td" ></td>';



                        echo '</tr>';
                    }
                    include BasePath . "sys/manage_data/view/table-parts/" . "tbody-results.php";
                    ?>
                </tbody>
            </table>
            <?php
            if (count($ViewData["Results"]["footer"])) {
                echo '<div class="box-table-results">';
                foreach ($ViewData["Results"]["footer"] as $item) {
                    if ($item["result"] == 0) {
                        continue;
                    }
                    echo '<div class="table-results">' . '<label class="table-results-label">' . $item["label"] . '</label>' . '<label class="table-results-result">' . apply_filters("result_table_" . $ViewData["PluginName"] . "_" . $ViewData["JustModelName"] . "_" . $item["tag"], $item["result"]) . '</label>' . '</div>';
                }
                echo '</div>';
            }
            ?>
        </div>
        <div class="panel-footer">
        <a  class="btn btn-primary" onclick="check_group_by_print();" href="#" data-toggle="modal" data-target="#print-modal"><?php echo "چاپ"." ".$ViewData["DetailJustPageTitle"]; ?><i class="fa fa-print"></i></a></div>
    </div>

<?php
include BasePath."sys/manage_data/view/table-parts/table-tags.php"; 
include BasePath."sys/manage_data/view/table-parts/footer-parts/print-modal.php"; 
}
