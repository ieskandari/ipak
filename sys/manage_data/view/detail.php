<?php
foreach($ViewData["Fields"] as $item)
{
?>
<div class="detail-box"><label class="detail-title"><?php echo $item["title"]; ?></label><label class="detail-value"><?php echo $item["val"]; ?></label></div>
<?php
}
