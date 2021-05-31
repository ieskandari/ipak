


<?php
$treee = "";
$treee  = $ViewData["MultiCheckValue"];
?>
<link href="<?php echo BaseUrl; ?>content/css/tree.css" rel="stylesheet">
<form action="<?php echo BaseUrl  ?>admin/admin/set_permission?role_id=" method="post">
<div class="panel panel-info">
    <div class="panel-heading"><span>دسته بندی ها</span><span> </span></div>
    <div class="panel-body">
        <div style="margin-top: 15px;"></div>
        <div class="tree">
        </div>
    </div>
</div>
<input id="tree" name="tree" value="<?php echo $treee; ?>" type="hidden" />
</form>


<?php
function MultiCheck_tree_view()
{
    global $ViewData;
    $da = array();
    $da = explode(",", $ViewData["MultiCheckValue"]);
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