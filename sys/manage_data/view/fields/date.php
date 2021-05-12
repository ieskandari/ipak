<?php

?>
<div class="<?php echo $ViewData["ColClass"]; ?>">
<?php include "label.php"; ?>
    <?php echo '<input '.$ViewData["Attr"].' onclick="Mh1PersianDatePicker.Show(this,'."'".$ViewData["InputValue"]."'".',window.holidays)" class="'.$ViewData["InputClass"].'" value="'.$ViewData["InputValue"].'" id="'.$ViewData["InputName"].'" name="'.$ViewData["InputName"].'" placeholder="0000/00/00" />';?>
</div>