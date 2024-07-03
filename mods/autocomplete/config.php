<?php if (!defined('BB_ROOT')) die(basename(__FILE__));

/**
 * Настройки Autocomplete
 */
$bb_cfg = array_merge($bb_cfg, array(
	basename(__DIR__) => array(
		'genre' => array( // id поля, можно переопределять уже имеющиеся TXT[]
			'title' => 'Жанр', // заголовок поля
			'attr1' => '200,80', // аттрибуты поля
			'attr2' => 'req', // настройки отображения поля: req,BR,HEAD и т.д.
			'multiple' => true, // множественный выбор
			// варианты выбора
			'options' => array(
				'Первый вариант...',
				'Второй вариант...'
			),
		),
		'artist' => array(
			'title' => 'Исполнитель',
			'attr1' => '200,80',
			'attr2' => 'HEAD,headonly,req',
			'multiple' => false,
			'options' => array(
				'Первый вариант...',
				'Второй вариант...'
			),
		),
	)
));
