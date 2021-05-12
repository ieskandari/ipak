-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 12, 2021 at 05:58 AM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tr`
--

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`user_id`, `name`, `lname`, `username`, `se_key`, `setting`, `pass`, `permission`, `is_admin`, `user_role`, `img`, `role_id`) VALUES
(1, 'جلیل', 'نوری', 'admin', 'admin__________1@1024574261', '{\"file-select\":\"\",\"current-folder\":\"np-content/uploads/\",\"register-folder\":\"\",\"web_post_Form_EditId\":\"21\",\"salary_other_advantage_Form_EditId\":\"23\",\"salary_advantage_Form_EditId\":\"14\",\"salary_personal_deficit_Form_EditId\":\"12\",\"web_post_status_Form_EditId\":\"4\",\"admin_role_Form_EditId\":\"3\",\"web_labs_Form_EditId\":\"3\",\"costs_costs_Form_EditId\":\"\",\"bye_bye_Form_EditId\":\"\",\"sale_sale_Form_EditId\":\"35\",\"web_category_post_Form_EditId\":\"1\",\"web_menu_Form_EditId\":\"\",\"admin_user_Form_EditId\":\"8\",\"web_slider_Form_EditId\":\"2\",\"hesab_hesab_Form_EditId\":\"\",\"kala_kala_Form_EditId\":\"5\",\"kala_category_kala_Form_EditId\":\"\",\"hesab_category_hesab_Form_EditId\":\"\",\"ticket_ticket_Form_EditId\":\"9\",\"ticket_ticket_type_Form_EditId\":\"\",\"crm_company_Form_EditId\":\"1\",\"crm_contact_Form_EditId\":\"\",\"crm_event_Form_EditId\":\"\",\"check_my_checks_Form_EditId\":\"2\",\"check_other_checks_Form_EditId\":\"1\",\"crm_task_Form_EditId\":\"1\",\"admin_message_Form_EditId\":\"\",\"message_message_Form_EditId\":\"\",\"salary_work_Form_EditId\":\"269\",\"sale_pre_sale_Form_EditId\":\"\",\"accountside_account_hesab_Form_EditId\":\"\",\"accountside_account_Form_EditId\":\"\",\"salary_other_advantage_table\":{\"advantage_id\":\"0\",\"personal_id\":\"2\",\"year_id\":\"0\",\"month_id\":\"0\",\"page\":\"1\"},\"salary_other_deficit_table\":{\"deficit_id\":\"0\",\"personal_id\":\"2\",\"year_id\":\"0\",\"month_id\":\"0\",\"page\":\"1\"},\"salary_other_deficit_Form_EditId\":\"7\",\"rank_base_rank_Form_EditId\":\"2\",\"rank_year_Form_EditId\":\"\",\"rank_secret_Form_EditId\":\"2\",\"rank_formul_Form_EditId\":\"2\",\"rank_cat_formul_Form_EditId\":\"2\",\"sanad_view_daftar_kol_table\":{\"title\":\"t2\"},\"sanad_view_daftar_moin_table\":{\"title\":\"t2\"},\"sanad_view_daftar_tafzil_table\":{\"title\":\"t2\"},\"sanad_view_daftar_sod_table\":{\"title\":\"t2\"},\"sanad_view_beds_bess_table\":{\"title\":\"t2\"}}', '$2y$10$y6cTi8KS./ew5Ueeq3k66eRf.n/Zut0mZhzJFOhO0H6Dh3an9fF52', 'salary_month_log,salary_work,salary_work_log,salary_advantage,salary_advantage_log,salary_deficit,salary_deficit_log,salary_other_advantage,salary_other_advantage_log,salary_other_deficit,salary_other_deficit_log,salary_personal,salary_personal_log,salary_personal_advantage,salary_personal_advantage_log,salary_personal_deficit,salary_personal_deficit_log,salary_friday,salary_friday_log,salary_holiday,salary_holiday_log,salary_leave_day,salary_leave_day_log,salary_leave_hour,salary_leave_hour_log,salary_work_advantage,salary_work_advantage_log,salary_work_deficit,salary_work_deficit_log,salary_import,anbar_anbar,anbar_anbar_log', 1, 'مدیر', '53DEC971-6162-42A5-80E7-435299273DF2.jpeg', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
