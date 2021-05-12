</div>
</div>
<footer></footer>
<script src="<?php echo BaseUrl; ?>content/js/jquery-3.5.1.min.js"></script>
<script src="<?php echo BaseUrl; ?>content/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo BaseUrl; ?>content/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo BaseUrl; ?>content/js/Mh1PersianDatePicker.js" type="text/javascript"></script>
<script src="<?php echo BaseUrl; ?>content/js/table.js" type="text/javascript"></script>
<script src="<?php echo BaseUrl; ?>content/js/dropdown.js" type="text/javascript"></script>
<script src="<?php echo BaseUrl; ?>content/js/menu.js" type="text/javascript"></script>
<?php  include "footer-parts/file-manager.php";  ?>
<script src="<?php echo BaseUrl; ?>content/js/myjs.js" type="text/javascript"></script>
<script>
       InitNav();
       function separate_1000(obj,input)
       {
              obj.val(function (index, value) {
        return '' + value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
               });
               $('#'+input).val(obj.val().replace(/\D/g, ""));
       }
</script>
<?php
include "footer-parts/tooltip.php";
include "scripts-editable-tools.php";
do_action("footer_scripts");
?>
</body>

</html>