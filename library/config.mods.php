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

// Поиск по статусу раздачи
$bb_cfg['search_by_tor_status'] = true;
