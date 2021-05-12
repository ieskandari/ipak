<?php
if(isset($ViewData["ExistsGalleryFields"]))
{
include "gallery.php";
}
else  if(isset($ViewData["ExistsImageFields"]))
{
?>
<script src="<?php echo BaseUrl; ?>content/js/image-compressor.js"></script>
<script src="<?php echo BaseUrl; ?>content/js/file.js"></script>
<?php
}
?>