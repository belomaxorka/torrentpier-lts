<?php
/**
 * Укажите в этом файле настройки модов (в config.php дублировать не нужно!)
 */

if (!defined('BB_ROOT')) die(basename(__FILE__));

// Режим: Новый год
// Автоматическая активация 21 декабря по 10 января
$bb_cfg['new_year_mode'] = ((date('n') == 12 && date('j') >= 21) || (date('n') == 1 && date('j') <= 10));

// Дата запуска форума в статистике на главной
$bb_cfg['show_board_start_date'] = true;

// Случайная раздача
$bb_cfg['random_release_button'] = true;

// Контрольные суммы файлов
$bb_cfg['attach_file_hash'] = true;

// Кто просматривает тему
$bb_cfg['who_is_looking_topic'] = true;

// Поиск по статусу раздачи
$bb_cfg['search_by_tor_status'] = true;

// Знак зодиака
$bb_cfg['zodiac_sign'] = array(
#	'знак зодиака' => [месяц начала, день начала, месяц конца, день конца]
	'aries' => [3, 21, 4, 20],
	'taurus' => [4, 21, 5, 21],
	'gemini' => [5, 22, 6, 21],
	'cancer' => [6, 22, 7, 22],
	'leo' => [7, 23, 8, 21],
	'virgo' => [8, 22, 9, 23],
	'libra' => [9, 24, 10, 23],
	'scorpio' => [10, 24, 11, 22],
	'sagittarius' => [11, 23, 12, 22],
	'capricorn' => [12, 23, 1, 20],
	'aquarius' => [1, 21, 2, 19],
	'pisces' => [2, 20, 3, 20],
);

// Просмотр кода топика
$bb_cfg['show_post_bbcode_button'] = true;

// Парковка аккаунта
$bb_cfg['park_acc_help_url'] = 'viewtopic.php?t=5';

// Семейное положение
$bb_cfg['show_relationships'] = true;

// Спасибо
$bb_cfg['tor_thank'] = true;
$bb_cfg['tor_thanks_list_guests'] = true;
$bb_cfg['tor_thank_limit_per_topic'] = 50;
