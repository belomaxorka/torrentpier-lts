<?php if (!defined('BB_ROOT')) die(basename(__FILE__));

/**
 * Настройки Drag and Drop файл-лист
 */
$bb_cfg = array_merge($bb_cfg, array(
	basename(__DIR__) => array(
		'tracklist' => array( // id поля, можно переопределять уже имеющиеся TXT[]
			'title' => 'Треклист', // заголовок поля
			'attr1' => '15', // аттрибуты поля
			'attr2' => 'br2,req', // настройки отображения поля: req,BR,HEAD и т.д.
			'remove_extension' => true, // удалять расширение
			'insert' => true, // заменять значение или вставлять в позицию курсора
			'recursive' => true, // сканировать папки рекурсивно
			'folder_format' => '[spoiler=\"<<FOLDERNAME>>\"]\r\n<<FILELIST>>\r\n[/spoiler]', // формат вывода папок (если их больше 1)
			'regex' => '\\\.(mp3|wav|ogg|aac|flac)$', // regex для фильтрации лишних файлов, false – все файлы
			'duration' => 'duration', // id поля продолжительности или false
		)
	)
));
