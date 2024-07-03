<?php
/**
 * TorrentPier – Drag and Drop Duration
 *
 * @link https://torrentpier.com/resources/drag-and-drop-duration.267/
 * @author lufton <lufton@gmail.com>
 */

require __DIR__ . '/config.php';
$tpl = new Template(__DIR__);
$tpl->set_filenames(array('mod' => 'index.tpl'));
$tpl->assign_vars(array(
	'MODNAME' => basename(__DIR__),
	'CONFIG' => json_encode($bb_cfg[basename(__DIR__)], JSON_UNESCAPED_SLASHES),
));
$tpl->pparse('mod');
