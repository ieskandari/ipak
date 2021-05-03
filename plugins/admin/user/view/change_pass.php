<?php
include "header.php";
?>
<div class="wrapper fadeInDown">
    <div id="formContent">
    <form action="<?php  echo BaseUrl; ?>admin/change_password" method="post">
        <!-- Tabs Titles -->
        <!-- Icon -->
        <div class="fadeIn first">
            <img src="<?php  echo BaseUrl; ?>content/img/login.png" id="icon" alt="User Icon" />
        </div>
      <?php  if (isset($data["error"]))
        {
           echo '<div class="alert alert-danger">'.$data["error"].'</div>';
        } ?>
             <?php  if (isset($data["success"]))
        {
           echo '<div class="alert alert-success">'.$data["success"].'</div>';
        } ?>
        <!-- Login Form -->
        
            <input autocomplete="off" type="password" id="old_pass" class="fadeIn second" name="old_pass" placeholder="رمز عبور فعلی">
            <input autocomplete="off" type="password" id="new_pass" class="fadeIn third" name="new_pass" placeholder="رمز جدید">
            <input autocomplete="off" type="password" id="verify_pass" class="fadeIn third" name="verify_pass" placeholder="تکرار رمز جدید">
            <input type="submit" class="fadeIn fourth" value="ذخیره">
            <a href="<?php echo BaseUrl ?>admin/index" class="fadeIn fourth">بازگشت به داشبورد</a>

        <!-- Remind Passowrd -->
        <div id="formFooter">

        </div>
        </form>
    </div>
</div>
<?php
include "footer.php";
?>