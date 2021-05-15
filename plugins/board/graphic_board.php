<?php
class GraphicBoardClass
{
    function __construct()
    {
        //$query="select * from board_roles where id=:role_id";
        //$data=$TR_db->pdo_json($query,array(":role_id"=>$role_id));
    }
    function index()
    {
        global $ViewData, $TR_db;
        add_action("header_styles", array($this, "styles"));

        if (isset($_GET['role_id'])) {
            $role_id = $_GET['role_id'];
            $ViewData["role_id"] = $role_id;
            add_action("header_styles", array($this, "board_styles"));
            include 'view/board.php';
        } else {
            $query = "select * from board_roles";
            $data = $TR_db->pdo_json($query);
            $ViewData["show_all_roles"] = $data;
            add_action("header_styles", array($this, "role_styles"));
            include 'view/index.php';
        }
    }
    function styles()
    { ?>
        <link rel="stylesheet" type="text/css" href="<?php echo ThisPluginUrl; ?>asset/css/style.css">
    <?php
    }
    function role_styles()
    { ?>
        <link rel="stylesheet" type="text/css" href="<?php echo ThisPluginUrl; ?>asset/css/roles.css">
    <?php }
    function board_styles()
    { ?>
        <link rel="stylesheet" type="text/css" href="<?php echo ThisPluginUrl; ?>asset/css/state.css">
        <link rel="stylesheet" type="text/css" href="<?php echo ThisPluginUrl; ?>asset/css/card.css">
<?php }
}
$GraphicBoardClass = new GraphicBoardClass;
add_menu("graphic_board", "بولتن", BaseUrl . "board/admin/graphic_board", "board");
add_action("board_graphic_board", array($GraphicBoardClass, "index"));
