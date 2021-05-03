<?php
$treee = "";
$treee  = $ViewData["PermissonValue"];
?>
<link href="<?php echo BaseUrl; ?>content/css/tree.css" rel="stylesheet">
<form action="<?php echo BaseUrl  ?>admin/admin/set_permission?role_id=<?php echo $ViewData["role_id"]; ?>" method="post">
<div class="panel panel-info">
    <div class="panel-heading"><span>مدیریت دسترسی نقش ها</span><span><?php  $ViewData["RoleTitle"]; ?></span></div>
    <div class="panel-body">
        <div style="margin-top: 15px;"></div>
        <div class="tree">
        </div>
    </div>
    <div class="panel-footer">
        <button class="btn btn-primary">ذخیره</button>
    </div>
</div>
<input id="tree" name="tree" value="<?php echo $treee; ?>" type="hidden" />
</form>

<?php
function permission_tree_view()
{
    global $ViewData;
    $da = array();
    $da = explode(",", $ViewData["PermissonValue"]);
    $jsontree = json_encode($da);
?>
    <script src="<?php echo BaseUrl; ?>content/js/tree.js"></script>
    <script>
        // prettier-ignore
        let data = <?php echo $ViewData["PermissonTree"]; ?>;
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
add_action("footer_scripts", "permission_tree_view");
?>