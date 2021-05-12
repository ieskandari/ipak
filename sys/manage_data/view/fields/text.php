<div class="<?php echo $ViewData["ColClass"]; ?>">
<?php include "label.php"; ?>
    <textarea  title="<?php echo $ViewData["InputValue"]; ?>"  <?php echo  $ViewData["OnValid"];  ?>  <?php  echo $ViewData["Attr"]; ?>  id="<?php echo $ViewData["InputName"]; ?>" name="<?php echo $ViewData["InputName"]; ?>" class="<?php echo $ViewData["InputClass"]; ?>" ><?php echo $ViewData["InputValue"]; ?></textarea>
</div>