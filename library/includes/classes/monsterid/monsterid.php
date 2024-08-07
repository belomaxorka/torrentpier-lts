<?php

function build_monster($seed, $size, $stream)
{
	// init random seed
	if ($seed) {
		srand(hexdec(substr(md5($seed), 0, 6)));
	}

	// throw the dice for body parts
	$parts = array(
		'legs' => rand(1, 5),
		'hair' => rand(1, 5),
		'arms' => rand(1, 5),
		'body' => rand(1, 15),
		'eyes' => rand(1, 15),
		'mouth' => rand(1, 10)
	);

	// create background
	if (!$monster = @imagecreatetruecolor(120, 120)) {
		die("GD image create failed");
	}
	$white = imagecolorallocate($monster, 255, 255, 255);
	imagefill($monster, 0, 0, $white);

	// add parts
	foreach ($parts as $part => $num) {
		$file = dirname(__FILE__) . '/parts/' . $part . '_' . $num . '.png';
		$im = @imagecreatefrompng($file);
		if (!$im) {
			die('Failed to load ' . $file);
		}

		imageSaveAlpha($im, true);
		imagecopy($monster, $im, 0, 0, 0, 0, 120, 120);
		imagedestroy($im);

		// color the body
		if ($part == 'body') {
			$color = imagecolorallocate($monster, rand(20, 235), rand(20, 235), rand(20, 235));
			imagefill($monster, 60, 60, $color);
		}
	}

	// restore random seed
	if ($seed) {
		srand();
	}

	// resize if needed, then output
	if ($size < 400) {
		if (!$out = @imagecreatetruecolor($size, $size)) {
			die("GD image create failed");
		}

		imagecopyresampled($out, $monster, 0, 0, 0, 0, $size, $size, 120, 120);
		imagepng($out, $stream);
		imagedestroy($out);
	} else {
		imagepng($monster, $stream);
	}

	imagedestroy($monster);
	return $stream;
}
