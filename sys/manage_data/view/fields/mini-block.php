<div class="<?php echo $ViewData["ColClass"]; ?>">
<?php include "label.php"; ?>
    <div  onkeyup="div_editable_key_up($(this));" id="<?php echo $ViewData["InputName"]; ?>_editable" data-id="<?php echo $ViewData["InputName"]; ?>" class="editable-div" contenteditable="true"><?php echo $ViewData["InputValue"]; ?></div>
    <textarea style="display: none;" id="<?php echo $ViewData["InputName"]; ?>" name="<?php echo $ViewData["InputName"]; ?>"  ><?php echo $ViewData["InputValue"]; ?></textarea>
</div>