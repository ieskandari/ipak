<?php
$colors = array("#007bff", "#28a745", "#dc3545", "#ffc107", "#17a2b8", "#fd0282", "#343a40", "#7a17b8");
$tiles = apply_filters("dashboard_tiles_" . $ViewData["PluginName"], array());
?>
<?php
if (count($tiles) > 0) {
?>
    <div class="row">
        <?php
        $index_color=-1;
        foreach ($tiles as $tile) {
            $index_color++;
            if( $index_color>=8)
            {
                $index_color=0;
            }
            
        ?>
            <div class="col-md-3">
                <div style="background: <?php echo $colors[$index_color]; ?>" class="dashbord-tile">
                    <h4> <?php echo $tile["title"];
                            if (isset($tile["icon"])) {
                                echo '<i class="' . $tile["icon"] . '"></i>';
                            } ?> </h4>
                    <hr>
                    <p><?php echo $tile["desc"]; ?></p>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
<?php
}
?>