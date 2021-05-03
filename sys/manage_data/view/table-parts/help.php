<hr>
<div id="panel-help-table" class="panel panel-warning help-panel">
    <div class="panel-heading">راهنما و توضیحات <i data-help="راهنمایی و توضیحات" class="fa fa-question-circle"></i></div>
    <div class="panel-body ">
        <?php echo '<h4>' . 'مدیریت ' . $ViewData["JustPageTitle"] . '</h4>'; ?>
        <p></p>
        <ul>
            <li><a onclick="OnClickItemHelp($(this))" data-href="help-new">ثبت اطلاعات جدید</a></li>
            <li><a onclick="OnClickItemHelp($(this))" data-href="help-edit">ویرایش</a></li>
            <li><a onclick="OnClickItemHelp($(this))" data-href="help-delete">حذف</a></li>
            <li><a onclick="OnClickItemHelp($(this))" data-href="help-filter">فیلتر و جستجو</a></li>
            <li><a onclick="OnClickItemHelp($(this))" data-href="help-sort">مرتب سازی</a></li>
            <li><a onclick="OnClickItemHelp($(this))" data-href="help-excel">خروجی اکسل</a></li>
            <li><a onclick="OnClickItemHelp($(this))" data-href="help-print">چاپ</a></li>
            <li><a onclick="OnClickItemHelp($(this))" data-href="help-table-footer">بخش های  نوار پایین جدول</a></li>
        </ul>
        <hr>
        <h4 id="help-new" class="help-header">ثبت اطلاعات جدید</h4>
        <p></p>
        <p><span>برای ثبت اطلاعات جدید در بالای صفحه گزینه</span><a href="#" class="btn btn-success"><?php echo  $ViewData["ModelTitle"] . ' ' . _T("table-filter-btn-plus"); ?><i class="fa fa-plus"></i></a>
            <span>را انتخاب نمائید تا به صفحه مورد نظر بروید.</span>
        </p>
        <hr>
        <h4 id="help-edit" class="help-header">ویرایش</h4>
        <p></p>
        <p><span>برای ویرایش اطلاعات در ستون آخر هر ردیف آیکون </span><i class="fa fa-list"></i><span>را انتخاب کنید منویی ظاهر می گردد که در آن منو گزینه ویرایش را انتخاب نموده و وارد صفحه ویرایش اطلاعات شوید</span>
        </p>
        <hr>
        <h4 id="help-delete" class="help-header">حذف</h4>
        <p></p>
        <p><span>برای حذف اطلاعات در ستون آخر هر ردیف آیکون </span><i class="fa fa-list"></i>
            <span>را انتخاب کنید منویی ظاهر میگردد که در آن منو گزینه حذف را انتخاب نمائید پنجره ای نمایش داده می شود و از شما میخواهد که مطمئن هستید برای حذف اطلاعات بعد از تایید اطلاعات مورد نظر حذف می گردد</span>
        </p>
        <hr>
        <h4 id="help-filter">فیلتر و جستجو</h4>
        <p></p>
        <p><span> در قسمت فرم فیلتر <i class="fa fa-filter"></i></span> <span> با انتخاب هر یک از آیتم ها و پس از آن با انتخاب گزینه </span>
        <button class="btn btn-info"><?php echo  _T("table-filter-btn-submit"); ?><i class="fa fa-search"></i></button>
       <span>لیست بر اساس گزینه های انتخابی فیلتر و محدود می گردد</span>
       <br>
       <span>در پایین عناوین هر ستون تکست باکس با قابلیت نوشتن وجود دارد که اگر در آن تکست باکس چیزی را تایپ کنید و کلید </span>Enter<span>
           <span>را در صفحه کلید فشار دهید جدول بر اساس آن حروف تایپ شده فیلتر و محدود می گردد</span>
       <span> و برای حذف فیلتر گزینه </span>
       <a  class="btn btn-warning"><?php echo  _T("table-filter-btn-clear"); ?><i class="fa fa-refresh"></i></a>
        <span>انتخاب نمائید تا همه اطلاعات بدون فیلتر در نتایج نمایان گردد.</span>
        </p>
        <hr>
        <h4 id="help-sort">مرتب سازی</h4>
        <p></p>
        <p>
            <span>در جدول نمایش داده شده چنانچه  در عنواوین هر ستون کلیک نمائید جدول بر اساس آن ستون مرتب می گردد و دو وضعیت صعودی و نزولی دارد که با کلیک کردن دوباره  آن وضعیت تغییر می یابد و وضعیت مرتب سازی در آیکون کناری همان عنوان نشان داده می شود.</span>
        </p>
        <hr>
        <h4 id="help-excel">خروجی اکسل</h4>
        <p></p>
        <p>
            <span>برای دریافت خروجی اکسل نتایج آمده در جدول گزینه </span>
            <a title="<?php  echo _T("report-excel"); ?>" class="report"><img style="width: 30px;" class="report-icon" src="<?php echo BaseUrl; ?>content/img/excel.png" /></a>
<span>را انتخاب نموده و فایل مورد نظر را دریافت نمائید.</span>
        </p>
        <hr>
        <h4 id="help-print">چاپ</h4>
        <p></p>
        <p>
            <span>برای چاپ نتایج آورده شده در جدول گزینه </span>
            <a  title="<?php  echo _T("report-print"); ?>" class="report" ><img style="width: 30px" class="report-icon" src="<?php echo BaseUrl; ?>content/img/print.png" /></a>
<span> را انتخاب نمائید</span>
<span>صفحه کوچکی نمایان  می گردد در آن پنجره باز شده می توانید با برداشتن هر یک از تیک های مربوطه مشخص نمائید که کدام ستون ها در چاپ باشد یا نباشد.</span>
        </p>
        <hr>
        <h4 id="help-table-footer">بخش های  نوار پایین جدول</h4>
        <p></p>
        <p>در نوار پایینی جدول چند بخش وجود دارد که از سمت راست هر کدام را تشریح میکنیم</p>
        <h4>بخش صفحه بندی جدول</h4>
        <p>
            <span>نمایش اطلاعات جدول بصورت صفحه بندی هست به گونه ای که با انتخاب شماره صفحه مورنظر اطلاعات بر اساس شماره صفحه نمایش داده می شود.</span>
        </p>
        <h4>تعداد یافته ها</h4>
        <p>تعداد اطلاعات یافت شده بر اساس فیلتر یا بدون فیلتر نمایش داده می شود.</p>
        <h4>کارهای دسته جمعی</h4>
        <p>
            برای مثال چنانچه حذف تک به تک اطلاعات کاری سخت باشد با انتخاب تیک هر ردیف از جدول و سپس با انتخاب گزینه حذف از کارهای دسته جمعی و با کلیک برروی گزینه اعمال در آن بخش همه ردیف های انتخاب شده پاک می گردد.
        </p>
        <h4>سایز صفحه </h4>
        <p>
            به طور پیش فرض تعداد اطلاعات نمایش داده شده در جدول حداکثر 10 مورد می باشد چنانچه قصد دارید بیشتر از 10 مورد باشد در این قسمت با انتخاب گزینه های مربوطه و سپس با زدن گزینه اعمال تعداد اطلاعات نمایش داده شده در هر صفحه از جدول را تغییر دهید.
        </p>
        <h4>تاریخچه تغییرات</h4>
        <p>تمام تغییراتی که در اطلاعات  انجام می دهید اعم از ویرایش و حذف  در سیستم آرشیو شده و  با انتخاب گزینه تاریخچه تغییرات به اطلاعات قبلی دسترسی دارید و می توانید بررسی نمائید.</p>
        <hr>
        <?php do_action("table_help_" . $ViewData["PluginName"]); ?>
    </div>
</div>
<?php
function OnClickItemHelp()
{
?>
<script>
    function OnClickItemHelp(obj)
    {
        $('.selected').removeClass('selected');
        $([document.documentElement, document.body]).animate({
        scrollTop: $('#'+obj.attr('data-href')).offset().top-100
    }, 1000);
    $('#'+obj.attr('data-href')).addClass('selected');
    }
</script>
<?php
}
add_action("footer_scripts","OnClickItemHelp");
?>
<style>
    .help-header {}

    .help-panel .btn {
        font-size: 11px;
        margin-right: 10px;
        margin-left: 10px;
    }

    .help-panel i {
        margin-right: 10px;
        margin-left: 10px;
    }
    .help-panel li a{
        cursor: pointer;
    }
    .help-panel .selected{
        color:red;
    }
</style>