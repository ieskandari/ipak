<a  class="menu-a" href="<?php echo BaseUrl . ThisPlugin . '/admin'; ?>"><i class="fa fa-desktop"></i><span> میزکار</span></a>
<a  class="menu-a" href="<?php echo BaseUrl . ThisPlugin . '/admin/dashboard'; ?>"><i class="fa fa-tachometer"></i><span class="span"><?php echo "داشبورد"; ?></span><?php echo apply_filters("filter_nav_" . ThisPlugin . "_dashbord", '') ?></a>
<?php
$id = 5;
$models = sys\TR::$models[ThisPlugin];
foreach ($models as $model) {
    if (!get_permission(ThisPlugin . "_" . $model->name)) {
        continue;
    }
    $id++;
    if ($model->in_menu) {
        $class = '';
        if (Action == $model->name) {
            $class = "active";
        }
?>
        <a title="<?php echo $model->get_title(true, '') ?>"  class="menu-a  <?php echo $class ?>" href="<?php echo BaseUrl . ThisPlugin . '/' . $model->name . '?clear=1' ?>"><i class="<?php echo $model->icon; ?>"></i><span class="span"><?php echo $model->get_title(true, ""); ?></span><?php echo apply_filters("filter_nav_" . ThisPlugin . "_" . $model->name, ''); ?></a>
<?php
    }
}
$menus = get_menu(ThisPlugin);
foreach ($menus as $key => $menu) {
    if (!get_permission($key)) {
        continue;
    }
    if ($menu["is_show"] == false) {
        continue;
    }
    $id++;
    $class = '';
    if (Action == $menu["tag"]) {
        $class = "active";
    }
    echo '<a title="' . $menu["title"] . '"  class="menu-a ' . $class . '" href="' . $menu["link"] . '"><i class="' . $menu["icon"] . '"></i><span class="span">' . $menu["title"] . '</span></a>';
}
?>