<?php
if ($ViewData["Paging"]) {
?>
  <div class="paging-links table-footer-part">
    <div id="table-paging" class="<?php echo apply_filters("filter_class_paging_footer_datatable", "paging"); ?>">

    </div>
    <div class="<?php echo apply_filters("filter_class_goto_page_footer_datatable", "goto-page"); ?>">
      <form action="" method="GET">
        <button><?php echo  _T("table-paging-goto"); ?></button>
        <input id="page" name="page" min="1" max="<?php echo $ViewData["TableDataTotalPage"]; ?>" type="number" />
      </form>
    </div>
  </div>
  <div class="table-footer-part <?php echo apply_filters("filter_class_group_works_footer_datatable", "group-works"); ?>">
    <form>
      <label><?php echo _T("table-data-count"); ?></label>
      <label> : <?php echo $ViewData["TableDataCount"]; ?></label>
    </form>
  </div>
<?php
}

function pagin_script()
{
  global $ViewData;
?>
  <script src="<?php echo BaseUrl; ?>content/js/paging.js" type="text/javascript"></script>
  <script>
    var pages = generatePagination(<?php echo $ViewData["TableDataTotalPage"]; ?>, <?php echo $ViewData["TableDataPage"] ?>);
    // pages = generatePagination(1000, 10);
    var first = 0;
    var last = 0;
    var str = '';
    var total_page = <?php echo $ViewData["TableDataTotalPage"]; ?>;
    var current_page = <?php echo $ViewData["TableDataPage"] ?>;
    console.log(pages);
    var cur_pages=[];
    for (var i = 0; i < pages.length; i++) {
      if (pages[i].value == 0 || cur_pages[pages[i].value]==pages[i].value) {
        continue;
      }
      cur_pages[pages[i].value]=pages[i].value;
      var selected = "active";
      var href = '?page=' + pages[i].value;
      if (pages[i].isSelected) {
        selected = "selected";
        href = "#";
      }

      if (pages[i].value == "...") {
        str = '<a class="noactive"><span style="font-size: 7px;">000</span></a>' + str;
      } else {
        str = '<a class="' + selected + '" href="' + href + '">' + pages[i].value + '</a>' + str;
      }

    }
    if (current_page > 1) {
      var href = '?page=' + (current_page - 1);
      str = '<a class="active" href="' + href + '">' + '<?php echo  _T("paging-prev");  ?>' + '</a>' + str;
    }
    if (current_page < total_page) {
      var href = '?page=' + (current_page + 1);
      str = str + '<a class="active" href="' + href + '">' + '<?php echo  _T("paging-next");  ?>' + '</a>';
    }
    $('#table-paging').html(str);
  </script>
<?php
}
add_action("footer_scripts", "pagin_script");
