<div class="<?php echo $ViewData["ColClass"]; ?>">
    <label class="<?php echo $ViewData["LabelClass"]; ?>"><?php echo $ViewData["TitleLabel"]; ?></label>
    <select  <?php echo  $ViewData["OnValid"];  ?> <?php echo $ViewData["Attr"]; ?> id="<?php echo $ViewData["InputName"]; ?>" name="<?php echo $ViewData["InputName"]; ?>" class="<?php echo $ViewData["InputClass"]; ?> selectpicker" data-show-subtext="true" data-live-search="true">
        <?php
        echo '<option  value="0">' . 'خالی' . '</option>';
        foreach ($data as $item) {
            $selected = "";
            echo '<option data-subtext=" " ' . $selected . ' value="' . $item["id"] . '">' . $item["name"] . '</option>';
        }
        ?>
    </select>
</div>