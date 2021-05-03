<?php
echo '<div class="panel">';
echo  '<div class="panel-body">';

foreach ($data["json"] as $plugin) {
    if (isset($plugin["new"])) {
        if ($plugin["new"] == "0") {
            echo '<div class="updates updated">' . '<label>' . 'آپدیت شده' . ' . ' . $plugin["title"] . ' ' . $plugin["tozih"] . '</label>' . '</div>';
        } else {
            echo '<div class="updates update-new">' . 'آپدیت جدید' . ' : ' . $plugin["title"] . ' ' . $plugin["tozih"] . '<a class="btn btn-primary" href="' . BaseUrl . 'admin/admin/' . 'post_update?plugin=' . $plugin["name"] . '&version=' . $plugin["ver"] . '">' . ' بروزرسانی' . '</a>' . '</div>';
        }
        if (isset($plugin["sub_plugins"])) {
            echo '<ul>';
            foreach ($plugin["sub_plugins"] as $sub) {
                if ($sub["new"] == "1") {
                    echo '<li><div class="updates update-new">' . 'آپدیت جدید' . ' : ' . $sub["title"] . ' ' . $sub["tozih"] . '<a class="btn btn-primary" href="' . BaseUrl . 'admin/admin/' . 'post_update?plugin=' . $plugin["name"] . '&sub_plugin='.$sub["name"].'&version=' . $sub["ver"] . '">' . ' بروزرسانی' . '</a>' . '</div></li>';
                }
            }
            echo '</ul>';
        }
        echo '<hr>';
    }
}
echo  '</div>';
echo '</div>';
?>
<style>
    .updates {
        margin-top: 7px;
    }
</style>