<link href="<?php echo BaseUrl; ?>content/css/tree.css" rel="stylesheet">
<div class="<?php echo $ViewData["ColClass"]; ?>">
    <?php include "sys/manage_data/view/fields/label.php"; ?>
    <div class="tree_<?php echo $dep->name; ?>">
    </div>
</div>
<?php
$func_tree = 'MultiCheck_tree_view_' . $dep->name;
if (!function_exists($func_tree)) {
    $$func_tree = function ($ViewData, $dep) {
        $MultiCheckTree = $ViewData["MultiCheckTree" . $dep->name];
        $da = array();
        $da = explode(",", $MultiCheckTree);
        $jsontree = json_encode($da);
?>
        <script src="<?php echo BaseUrl; ?>content/js/tree.js"></script>
        <script>
            let tree<?php echo $dep->name; ?> = new Tree('.tree_<?php echo $dep->name; ?>', {
                data: <?php echo $MultiCheckTree; ?>,
                closeDepth: 3,
                loaded: function() {
                    this.values = <?php echo $jsontree; ?>;
                },
                onChange: function() {
                    $("#tree_<?php echo $dep->name; ?>").val(this.values);
                }
            });
            $('.treejs-node').addClass('treejs-node__close');
        </script>
<?php
    };
}
$$func_tree($ViewData, $dep);
?>