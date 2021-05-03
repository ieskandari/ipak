<?php
foreach (sys\TR::$admin_alerts as $alert) {
    if ($alert["type"] == "danger") {
        $ViewData["AlertErrors"][] = $alert["message"];
    }
    else if ($alert["type"] == "success") {
        $ViewData["AlertSuccess"][] = $alert["message"];
    }
    else if ($alert["type"] == "warning") {
        $ViewData["AlertWarnings"][] = $alert["AlertWarnings"];
    }
    else if ($alert["type"] == "info") {
        $ViewData["AlertMessages"][] = $alert["AlertMessages"];
    }
}
?>
<?php if (isset($ViewData["AlertErrors"])) {
    $ViewData["AlertErrors"] = apply_filters("header_alert_error_" . $ViewData["ModelName"], $ViewData["AlertErrors"]);
    $ViewData["AlertErrors"] = apply_filters("header_alert_error", $ViewData["AlertErrors"]);
    if (count($ViewData["AlertErrors"]) > 0) {
?>
        <?php foreach ($ViewData["AlertErrors"] as $item) {
        ?>
            <div class="alert alert-danger">
                <?php echo $item; ?>
            </div>
        <?php
        }
        ?>
<?php  }
} ?>
<?php if (isset($ViewData["AlertSuccess"])) {
    $ViewData["AlertSuccess"] = apply_filters("header_alert_success_" . $ViewData["ModelName"], $ViewData["AlertSuccess"]);
    $ViewData["AlertSuccess"] = apply_filters("header_alert_success", $ViewData["AlertSuccess"]);

    if (count($ViewData["AlertSuccess"]) > 0) {
?>
        <div class="alert alert-success"><?php
                                            foreach ($ViewData["AlertSuccess"] as $item) {
                                                echo $item;
                                            }
                                            ?></div>
<?php }
} ?>
<?php if (isset($ViewData["AlertWarnings"])) {
    $ViewData["AlertWarnings"] = apply_filters("header_alert_warning_" . $ViewData["ModelName"], $ViewData["AlertWarnings"]);
    $ViewData["AlertWarnings"] = apply_filters("header_alert_warning", $ViewData["AlertWarnings"]);

    if (count($ViewData["AlertWarnings"]) > 0) {
?>
        <div class="alert alert-warning"><?php
                                            foreach ($ViewData["AlertWarnings"] as $item) {
                                                echo $item;
                                            }
                                            ?></div>
<?php  }
} ?>
<?php if (isset($ViewData["AlertMessages"])) {
    $ViewData["AlertMessages"] = apply_filters("header_alert_message_" . $ViewData["ModelName"], $ViewData["AlertMessages"]);
    $ViewData["AlertMessages"] = apply_filters("header_alert_message", $ViewData["AlertMessages"]);


    if (count($ViewData["AlertMessages"]) > 0) {
?>
        <div class="alert alert-info"><?php
                                        foreach ($ViewData["AlertMessages"] as $item) {
                                            echo $item;
                                        }
                                        ?></div>
<?php  }
} ?>