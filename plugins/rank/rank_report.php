<?php
class RankReportClass
{
    function index()
    {
        include 'view/report.php';
    }
}
$RankReportObject =new RankReportClass;
add_menu("rank_report", "گزارش رتبه بندی", BaseUrl . "rank/admin/rank_report", "rank");
add_action("rank_rank_report", array($RankReportObject, "index")); 