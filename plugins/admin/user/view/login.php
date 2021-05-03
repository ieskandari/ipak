<?php
include "header.php";
?>
<div class="wrapper fadeInDown">
    <div id="formContent">
    <form action="<?php echo BaseUrl; ?>admin/login" method="post">
        <!-- Tabs Titles -->
        <!-- Icon -->
        <div class="fadeIn first">
            <img src="<?php  echo BaseUrl; ?>content/img/login.png" id="icon" alt="User Icon" />
        </div>
      <?php  if (isset($data["error"]))
        {
           echo '<div class="alert alert-danger">'.$data["error"].'<span id="timer"></span></div>';
        } ?>
        <!-- Login Form -->
        
            <input autocomplete="off" type="text" id="username" class="fadeIn second" name="username" placeholder="نام کاربری">
            <input autocomplete="off" type="password" id="password" class="fadeIn third" name="password" placeholder="رمز عبور">
            <input type="submit" class="fadeIn fourth" value="ورود">

        <!-- Remind Passowrd -->
        <div id="formFooter">

        </div>
        </form>
    </div>
</div>
<?php if(isset($data["timer"])){ ?>

<script>
var timer=<?php echo $data["timer"].';'; ?>

function timer_m()
{
    timer=timer-1;
    if(timer>-1)
    {
        setTimeout(function(){  $('#timer').html(timer);timer_m(timer); }, 1000);
    }
    else
    {
        $('.alert').remove();
    }
}
timer_m();
</script>

<?php  }  ?>
<?php
include "footer.php";
?>