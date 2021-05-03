<div class=" <?php echo $ViewData["ColClass"]; ?>">
    <?php include BasePath."sys/manage_data/view/fields/label.php"; ?>
    <?php if (isset($ViewData["SelectPluginModelName"]) && !$ViewData["Is_form_filter"]) {
    ?>
        <a onclick="new_shortcode_model($(this))" class="new-shortcode-model" plugin-name="<?php echo $ViewData["SelectPluginModelName"]; ?>" href="#">(ایجاد کردن)</a>
    <?php  } ?>
    <div class="parent-select-dropdown form-control">
        <select <?php echo  $ViewData["OnValid"];  ?> <?php echo $ViewData["Attr"]; ?> id="<?php echo $ViewData["InputName"]; ?>" name="<?php echo $ViewData["InputName"]; ?>" class="<?php echo $ViewData["InputClass"]; ?> ">
            <?php
            echo '<option  value="0">' . 'خالی' . '</option>';
            foreach ($data as $item) {
                $get_name = $item["name"];
                if (!is_array($dep)) {
                    $my_row = array($dep->name => $item["id"]);
                    $get_name = get_field_data($my_row, $dep);
                    if (strlen($get_name) == 0) {
                        $get_name = $item["name"];
                    }
                }
                $selected = "";
                if ($ViewData["InputValue"] == $item["id"]) {
                    $selected = "selected";
                }
                echo '<option title="' . $get_name . '" ' . $selected . ' value="' . $item["id"] . '">' . $get_name . '</option>';
            }
            ?>
        </select>
        <input onclick="dropdown_input_select($(this));" onkeyup="key_up_select_input($(this));" class="select-input-ajax form-control" />
        <i class="fa fa-search search-icon"></i>
        <img class="select-loader" src="<?php echo BaseUrl; ?>content/img/loader.gif" />
    </div>
</div>