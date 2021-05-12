<?php
if(isset($_GET["gallery"]))
{
    include BasePath."sys/lib/libs/ImageResize.php";
    include "gallery.php";
}
else
{
    include BasePath."sys/lib/libs/file.php";
}