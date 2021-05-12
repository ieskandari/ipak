<div class="parent-select-dropdown <?php echo $ViewData["ColClass"]; ?>">
    <label class="<?php echo $ViewData["LabelClass"]; ?>"><?php echo $ViewData["TitleLabel"]; ?></label>
    <select  <?php echo  $ViewData["OnValid"];  ?> <?php echo $ViewData["Attr"]; ?> id="<?php echo $ViewData["InputName"]; ?>" name="<?php echo $ViewData["InputName"]; ?>" class="<?php echo $ViewData["InputClass"]; ?> ">
        <?php
        echo '<option  value="0">' . 'خالی' . '</option>';
        foreach ($data as $item) {
            $selected = "";
            if($ViewData["InputValue"]==$item["id"])
            {
                $selected="selected";
            }
            echo '<option '.$selected.' value="' . $item["id"] . '">' . $item["name"] . '</option>';
        }
        ?>
    </select>
    <input onkeyup="key_up_select_input($(this));" class="select-input-ajax form-control" />
</div>
