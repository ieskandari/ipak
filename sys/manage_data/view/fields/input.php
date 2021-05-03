<div class="<?php echo $ViewData["ColClass"]; ?>">
    <?php include "label.php"; ?>
    <input <?php if ($ViewData["InputName"] == "title") echo 'autocomplete="off" '; ?> title="<?php echo $ViewData["InputValue"]; ?>" value="<?php echo $ViewData["InputValue"]; ?>" <?php echo  $ViewData["OnValid"];  ?> <?php echo $ViewData["Attr"]; ?> id="<?php echo $ViewData["InputName"]; ?>" name="<?php echo $ViewData["InputName"]; ?>" class="<?php echo $ViewData["InputClass"]; ?>" />
</div>