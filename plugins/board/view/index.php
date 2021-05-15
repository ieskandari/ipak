<?php
foreach ($ViewData["show_all_roles"] as $item) { ?>
    <div class="roles">
        <?php echo $item['title']; ?>
        <a href="?role_id=<?php echo $item['id']; ?>">مشاهده</a>
    </div>
<?php }
?>