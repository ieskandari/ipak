<?php if (isset($ViewData["FormErrors"]) && count($ViewData["FormErrors"]) > 0) { ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($ViewData["FormErrors"] as $error) {  ?>
                <li><?php echo $error; ?></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
<?php if (isset($ViewData["FormSuccess"]) && count($ViewData["FormSuccess"]) > 0) { ?>
    <div class="alert alert-success">
        <ul>
            <?php foreach ($ViewData["FormSuccess"] as $error) {  ?>
                <li><?php echo $error; ?></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
<?php if (isset($ViewData["FormWarnings"]) && count($ViewData["FormWarnings"]) > 0) { ?>
    <div class="alert alert-warning">
        <ul>
            <?php foreach ($ViewData["FormWarnings"] as $error) {  ?>
                <li><?php echo $error; ?></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
<?php if (isset($ViewData["FormMessages"]) && count($ViewData["FormMessages"]) > 0) { ?>
    <div class="alert alert-info">
        <ul>
            <?php foreach ($ViewData["FormMessages"] as $error) {  ?>
                <li><?php echo $error; ?></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>