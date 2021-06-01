<link href="<?php echo BaseUrl; ?>content/css/tree.css" rel="stylesheet">
<div class="<?php echo $ViewData["ColClass"]; ?>">
    <?php include   "sys/manage_data/view/fields/label.php"; ?>
    <div class="tree">
    </div>
</div>
<?php
function MultiCheck_tree_view()
{
    global $ViewData;
    $da = array();
    $da = explode(",", $ViewData["MultiCheckTree"]);
    $jsontree = json_encode($da);
?>
    <script src="<?php echo BaseUrl; ?>content/js/tree.js"></script>
    <script>
        // prettier-ignore
        let data = <?php echo $ViewData["MultiCheckTree"]; ?>;
        //console.log(data);
        let tree = new Tree('.tree', {
            data: data,
            closeDepth: 3,
            loaded: function() {
                this.values = <?php echo $jsontree; ?>;
            },
            onChange: function() {
                $("#tree").val(this.values);
            }
        })
        $('.treejs-node').addClass('treejs-node__close');
    </script>
<?php
}
add_action("footer_scripts", "MultiCheck_tree_view");
?>