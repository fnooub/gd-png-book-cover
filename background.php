<?php
/*
 * https://www.transparenttextures.com/
 * https://stackoverflow.com/questions/4060437/how-to-load-and-repeat-x-an-image-with-php-gd
 */
$srcfile = 'brick-wall-dark.png';
$outfile = 'background.png';
list($src_w,$src_h,$src_type) = getimagesize($srcfile);

$out_w = 1366;
$out_h = 768;

$src = imagecreatefrompng($srcfile);

// tạo nền đục
$out = imagecreatetruecolor($out_w, $out_h);
$background_color = imagecolorallocate($out, 153, 51, 51);
imagefill($out, 0, 0, $background_color);

$curr_x = 0;
while($curr_x < $out_w) {
	$curr_y = 0;
	while($curr_y < $out_h){
		imagecopy($out, $src, $curr_x, $curr_y, 0, 0, $src_w, $src_h);
		$curr_y += $src_h;
	}
	$curr_x += $src_w;
}

imagepng($out, $outfile);
imagedestroy($src);
imagedestroy($out);
