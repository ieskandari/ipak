<div class="<?php echo $ViewData["ColClass"]; ?>">
    <?php include "label.php"; ?>
    <input type="hidden" name="<?php echo $ViewData["InputName"]; ?>" id="<?php echo $ViewData["InputName"]; ?>" value="<?php echo $ViewData["InputValue"]; ?>" />
    <input <?php echo "onkeyup=\"separate_1000($(this),'" . $ViewData["InputName"] . "');\";" ?> <?php echo  $ViewData["OnValid"];  ?> <?php echo $ViewData["Attr"]; ?> id="<?php echo $ViewData["InputName"]; ?>_1000" name="<?php echo $ViewData["InputName"]; ?>_1000" value="<?php echo number_format($ViewData["InputValue"]); ?>" class="<?php echo $ViewData["InputClass"]; ?>" />
</div>