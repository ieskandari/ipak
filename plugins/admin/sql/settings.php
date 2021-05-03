<?php
global $TR_db;
$sql = "";
$sql = "START TRANSACTION;";
$sql = $sql . "CREATE TABLE IF NOT EXISTS `settings` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(500) COLLATE ucs2_persian_ci NOT NULL,
        `val` text COLLATE ucs2_persian_ci NOT NULL,
        `plugin` varchar(500) COLLATE ucs2_persian_ci NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=ucs2 COLLATE=ucs2_persian_ci;";
$sql = $sql . " COMMIT;";


$TR_db->pdo_exc($sql);
