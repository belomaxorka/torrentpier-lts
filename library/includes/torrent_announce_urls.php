<?php

if (!defined('BB_ROOT')) die(basename(__FILE__));

$announce_urls = array(); // разрешенные URL-адреса анонсеров
$additional_announce_urls = array(); // дополнительные URL-адреса анонсеров

// Разрешенные URL-адреса анонсеров
// ------------------------------------------------------------------------------------------------------------------------------
// Примеры:
// $announce_urls[] = 'http://demo.torrentpier.com/bt/announce.php';
// $announce_urls[] = 'http://tracker.openbittorrent.com:80/announce';
// $announce_urls[] = 'udp://tracker.openbittorrent.com:6969/announce';
// ------------------------------------------------------------------------------------------------------------------------------
// Примечание:
// - Добавляйте URL-адреса без GET параметров в конце
// - Для работы этого файла нужно в админ-панели в "Настройки форумов" включить опцию "Проверять announce url"
// ==============================================================================================================================
// Дополнительные URL-адреса анонсеров, которые будут добавляться к вашим раздачам
// ------------------------------------------------------------------------------------------------------------------------------
// Примеры:
// $additional_announce_urls[] = 'http://tracker.openbittorrent.com:80/announce';
// $additional_announce_urls[] = 'udp://tracker.openbittorrent.com:6969/announce';
// ------------------------------------------------------------------------------------------------------------------------------
// Примечание:
// - Анонсеры с GET параметрами (например passkey или иной аутентификатор доступа) лучше не добавлять
// - Для работы этого файла нужно в админ-панели в "Настройки форумов" отключить опцию "Удалять все дополнительные announce urls"
// ==============================================================================================================================
