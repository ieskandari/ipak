START TRANSACTION;CREATE TABLE IF NOT EXISTS `admin_user` (
            `user_id` bigint(18) NOT NULL AUTO_INCREMENT,`name` varchar(50) COLLATE utf8_persian_ci,`lname` varchar(50) COLLATE utf8_persian_ci,PRIMARY KEY (`user_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
            COMMIT;



    