<?php
global $TR_tools;
$val = "{}";
$val = $ViewData["InputValue"];
$Gallery = $TR_tools->json_decode($val);
if (!is_array($Gallery)) {
    $Gallery = array();
}
?>
<div class="<?php echo $ViewData["ColClass"]; ?> col-gallery">
    <?php include "label.php"; ?>
    <input data-toggle="modal" data-target="#filemanager" onclick="AddImageToPost($('#box-image-<?php echo $ViewData['InputName']; ?>'),'<?php echo BaseUrl; ?>Content/img/image.png','<?php echo $ViewData['InputName']; ?>','1');" type="button" class="btn btn-default" id="<?php echo $ViewData['InputName']; ?>" name="<?php echo $ViewData['InputName']; ?>" value="اضافه کردن تصویر" />
    <!--  start box image !-->
    <div class="box-image" id="box-image-<?php echo $ViewData['InputName']; ?>">

        <?php foreach ($Gallery as $key => $item) {
            $src = get_url_img($item);
        ?>
            <div onmouseover="ShowRemoveButtonImagePost($(this),1);" onmouseout="ShowRemoveButtonImagePost($(this),0);" id="" class="img gallery-img-item"><i onclick="RemoveImagePost($(this));" class="fa fa-remove img-remove" style="display: none;"></i><img src="<?php echo $src; ?>" data-name="post_image" id=""><input type="hidden" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php echo $item; ?>"></div>
        <?php } ?>
    </div>
</div>
<?php $ViewData["ExistsGalleryFields"] = 1; ?>