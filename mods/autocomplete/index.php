<?php
/**
 * TorrentPier – Autocomplete
 *
 * @link https://torrentpier.com/resources/autocomplete.266/
 * @author lufton <lufton@gmail.com>
 */

require __DIR__ . '/config.php';
$tpl = new Template(__DIR__);
$tpl->set_filenames(array('mod' => 'index.tpl'));
$tpl->assign_vars(array(
	'MODNAME' => basename(__DIR__),
	'CONFIG' => json_encode($mod_cfg[basename(__DIR__)], JSON_UNESCAPED_SLASHES),
));
$tpl->pparse('mod');
