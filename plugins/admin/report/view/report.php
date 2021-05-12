<form method="post">
    <div class="panel panel-info col-md-12">
        <div class="panel-heading">
            فیلتر گزارش
        </div>
        <div class="panel-body">
            <div class="row">
                <?php
                foreach ($ViewData["Fields"] as $field) {
                    get_view_field($field);
                }
                ?>
            </div>
            <label class="red">اگر سال را خالی بگذارید و اعمال فیلتر را انتخاب نمائید گزارش همه سال ها می آید</label>
        </div>
        <div class="panel-footer col-md-6">
            <button class="btn btn-primary">اعمال فیلتر</button>
            <!-- <input type="submit" name="excel" class="btn btn-primary" value="خروجی اکسل" /> -->
        </div>
    </div>
</form>
<div class="panel panel-info col-md-6">
    <div class="panel-heading">
        <?php echo 'نمودار میله ای ' . $ViewData["ChartTitle"]; ?>
    </div>
    <div class="panel-body">
        <div id="canvas-panel"></div>
    </div>
</div>
<div class="panel panel-info col-md-6">
    <div class="panel-heading">
        <?php echo 'نمودار دایره ای ' . $ViewData["ChartTitle"]; ?>
    </div>
    <div class="panel-body">
        <div id="canvas-panel-1"></div>
    </div>
</div>
<div class="panel panel-info col-md-6">
    <div class="panel-heading">
        <?php echo '  گزارش ' . $ViewData["ChartTitle"]; ?>
    </div>
    <div class="panel-body">
        <div id="canvas-panel-2">
            <table class="table">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>عنوان</th>
                        <th>مقدار</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sum = 0;
                    $index = 0;
                    foreach ($ViewData["MyData"] as $item) {
                        $index++;
                        $sum = $sum + $item["val"];
                        echo '<tr>';
                        echo '<td>' . $index . '</td>';
                        echo '<td>' . $item["title"] . '</td>';
                        echo '<td>' . number_format($item["val"]) . '</td>';

                        echo '</tr>';
                    }
                    echo '<tr>';
                    echo '<td>جمع</td>';
                    echo '<td></td>';
                    echo '<td>' . number_format($sum) . '</td>';
                    echo '</tr>';
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
function drow_chart_report()
{
    global $ViewData;
?>
    <script src="<?php echo BaseUrl; ?>content/js/jalali.js" type="text/javascript"></script>
    <script src="<?php echo BaseUrl; ?>content/js/Chart.bundle.min.js" type="text/javascript"></script>
    <script src="<?php echo BaseUrl; ?>content/js/chart-render.js" type="text/javascript"></script>
    <script>
        function drow_chart_report() {
            var points_chart_label = <?php echo $ViewData["ChartLabels"]; ?>;
            var points_chart_val = <?php echo $ViewData["ChartData"]; ?>;

            var name_canvas = 'myChart1';
            $('#canvas-panel').html('<canvas id="' + name_canvas + '" width="900" height="400"></canvas>');

            drow_chart(name_canvas, " ", points_chart_label, points_chart_val);

            var name_canvas1 = 'myChart2';
            $('#canvas-panel-1').html('<canvas id="' + name_canvas1 + '" width="900" height="400"></canvas>');
            drow_chart_cyc(name_canvas1, " ", points_chart_label, points_chart_val);

        }
        drow_chart_report();
    </script>
<?php
}
add_action("footer_scripts", "drow_chart_report");
?>