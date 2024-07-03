<?php
/**
 * TorrentPier – Autocomplete Field
 *
 * @author lufton <lufton@gmail.com>
 */

require __DIR__ . '/config.php';

$tpl = new Template(__DIR__);

$tpl->set_filenames(array('mod' => 'index.tpl'));
$tpl->assign_vars(array(
	'MODNAME' => basename(__DIR__),
	'CONFIG' => json_encode($bb_cfg[basename(__DIR__)]),
));

$tpl->pparse('mod');
