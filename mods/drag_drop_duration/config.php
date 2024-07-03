<?php if (!defined('BB_ROOT')) die(basename(__FILE__));

/**
 * Настройки Drag and Drop Duration
 */
$bb_cfg = array_merge($bb_cfg, array(
	basename(__DIR__) => array(
		'duration' => array( // id поля, можно переопределять уже имеющиеся INP[]
			'title' => 'Продолжительность', // заголовок поля
			'attr1' => '8,8', // аттрибуты поля
			'attr2' => 'req', // настройки отображения поля: req,BR,HEAD и т.д.
			'format' => 'H:i:s', // формат отображения продолжительности (http://php.net/manual/ru/function.date.php)
			'recursive' => true, // сканировать папки рекурсивно
			'regex' => '\\\.(mp3|wav|ogg|aac|flac)$', // regex для фильтрации лишних файлов, false – все файлы
			'filelist' => 'tracklist' // id поля файллиста или false
		)
	)
));
