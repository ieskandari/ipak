<div  class="<?php echo $ViewData["ColClass"]; ?>">
<?php include "label.php"; ?>
    <input <?php echo  $ViewData["OnValid"];  ?> <?php echo $ViewData["Attr"]; ?> type="number" id="<?php echo $ViewData["InputName"]; ?>" name="<?php echo $ViewData["InputName"]; ?>" value="<?php echo $ViewData["InputValue"]; ?>" class="<?php echo $ViewData["InputClass"]; ?>" />
</div>