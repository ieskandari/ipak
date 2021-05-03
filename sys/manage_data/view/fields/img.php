<div class="<?php echo $ViewData["ColClass"]; ?>">
    <?php
    $img_name = $ViewData["InputName"];
    $src = "";
    $display = "display:none;";
    if (strlen($ViewData["InputValue"]) > 0) {
        $src = BaseUrl . "upload/" . $ViewData["InputValue"];
        $display = "";
    }
    ?>
    <?php include "label.php"; ?>
    <input onchange="upl_image($(this),'<?php echo $img_name; ?>','img_<?php echo $img_name; ?>');" type="file" accept="image/*" />
    <input id="<?php echo $ViewData["InputName"]; ?>" name="<?php echo $ViewData["InputName"]; ?>" type="hidden" />
    <img id="img_<?php echo $ViewData["InputName"]; ?>" src="<?php echo $src; ?>" style="<?php echo $display; ?>width:100px;" />
</div>
<?php $ViewData["ExistsImageFields"]=1; ?>