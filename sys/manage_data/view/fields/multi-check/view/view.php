<link href="<?php echo BaseUrl; ?>content/css/tree.css" rel="stylesheet">
<div class="<?php echo $ViewData["ColClass"]; ?>">
    <?php include "sys/manage_data/view/fields/label.php"; ?>
    <div class="tree_<?php echo $ViewData["InputName"]; ?>"  >
    </div>
</div>
<?php
$func_tree = 'MultiCheck_tree_view_'.$ViewData["InputName"];
//if (!function_exists($func_tree)) {
    $$func_tree = function ()
    {
        global $ViewData;
        $MultiCheckTree = $ViewData["MultiCheckTree".$ViewData["InputName"]];
        $da = array();
        $da = explode(",", $MultiCheckTree);
        $jsontree = json_encode($da);
?>
        <script src="<?php echo BaseUrl; ?>content/js/tree.js"></script>
        <script>
            // prettier-ignore
            //console.log(data);
            let tree<?php echo $ViewData["InputName"]; ?> = new Tree('.tree_<?php echo $ViewData["InputName"]; ?>', {
                data: <?php echo $MultiCheckTree; ?>,
                closeDepth: 3,
                loaded: function() {
                    this.values = <?php echo $jsontree; ?>;
                },
                //onChange: function() {
                  //  $("#tree_<?php //echo $ViewData["InputName"]; ?>").val(this.values);
                //}
            });
            $('.treejs-node').addClass('treejs-node__close');
        </script>
<?php
    };
//}
$$func_tree();
//add_action("footer_scripts", $$func_tree);
?>