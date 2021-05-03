<?php
include "header.php";

?>
<link href="<?php echo BaseUrl; ?>content/css/tree.css" rel="stylesheet">
<style>
    .treejs .treejs-checkbox {
        display: none;
    }
    .treejs .node-child{
        color: #0f78fb;
    }
    .treejs .node-parent{
        color: #ada8a8;
    }
</style>
<div class="panel panel-info">
    <div class="panel-heading">
      <?php echo $ViewData["TitleTree"];  ?>
    </div>
    <div class="panel-body">

        <div style="margin-top: 15px;" class="tree">
        </div>
    </div>
    <div class="panel-footer">

    </div>
</div>
<?php
function tree_view_models()
{
    global $ViewData;
?>
    <script src="<?php echo BaseUrl; ?>content/js/tree.js"></script>
    <script>
        var ChildData = <?php echo $ViewData["ChildData"]; ?>;
        var ParentData = <?php echo $ViewData["ParentData"]; ?>;
        var treeNodes = ParentData.filter(t => t.parent_id == 0);
        var main_tree = [];

        function get_children(id) {
            var childs = ParentData.filter(t => t.parent_id == id);
            var node_childs=[];
            for (var i = 0; i < childs.length; i++) {
                node_childs[node_childs.length] = {
                    id: "category_" + childs[i].id,
                    text: childs[i].title,
                    children: get_children(childs[i].id)
                };
            }
            var childs_1 = ChildData.filter(t => t.parent_id == id);
            for (var i = 0; i < childs_1.length; i++) {
                node_childs[node_childs.length] = {
                    id: "this_" + childs_1[i].id,
                    text: childs_1[i].title+'_is_child',
                    children:[]
                };
            }
            return node_childs;
        }
        for (var i = 0; i < treeNodes.length; i++) {
            main_tree[main_tree.length] = {
                id: "category_" + treeNodes[i].id,
                text: treeNodes[i].title,
                children: get_children(treeNodes[i].id)
            };
        }
        let tree = new Tree('.tree', {
            data: main_tree,
            closeDepth: 3,
            loaded: function() {

            },
            onChange: function() {

            }
        })
        $('.treejs-node').addClass('treejs-node__close');
       var childs= $('.treejs-label');
        for(var i=0;i<childs.length;i++)
        {
            if(childs.eq(i).html().includes("_is_child"))
            {
                childs.eq(i).html(childs.eq(i).html().replace('_is_child',''));
                childs.eq(i).addClass('node-child');
            }
           else
           {
               if(childs.eq(i).parent().children('.treejs-nodes').length==0)
               {
                childs.eq(i).addClass('node-parent');
               }
           }
        }
    </script>
<?php
}
add_action("footer_scripts", "tree_view_models");
?>
<?php
include "footer.php";
?>