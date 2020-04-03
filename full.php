<?php
require __DIR__.'/vendor/autoload.php';

use GDText\Box;
use GDText\Color;

// lay random mau nen
$imgs = glob("anh/*.png");
$srcfile = random_array($imgs);
//$srcfile = 'anh/cartographer.png';
$outfile = 'background.png';
list($src_w,$src_h,$src_type) = getimagesize($srcfile);

$out_w = 600;
$out_h = 800;

$src = imagecreatefrompng($srcfile);
$out = CreateBlankPNG($out_w, $out_h);

// lap lai anh n lan de tao ra kich thuoc can
$curr_x = 0;
while($curr_x < $out_w) {
	$curr_y = 0;
	while($curr_y < $out_h){
		imagecopy($out, $src, $curr_x, $curr_y, 0, 0, $src_w, $src_h);
		$curr_y += $src_h;
	}
	$curr_x += $src_w;
}

// imagepng($out); in ra

// tao lop mau nen
/*
$new_image = imagecreatetruecolor($out_w, $out_h);
setTransparency($new_image, $out);
imagecopyresampled($new_image, $out, 0, 0, 0, 0, $out_w, $out_h, $out_w, $out_h);
*/
$new_image = imagecreatetruecolor($out_w, $out_h);
$backgroundColor = imagecolorallocate($new_image, 80, 145, 123);
imagefill($new_image, 0, 0, $backgroundColor);
imagecopyresampled($new_image, $out, 0, 0, 0, 0, $out_w, $out_h, $out_w, $out_h); // ghep nen moi va $out png

/*
xu ly text gd
auto font size
*/
$text = "nguyễn nhật ánh";
$text = preg_replace('/\s+/', ' ', $text);
$text = trim(mb_strtolower($text));
$fontfile = realpath('fonts/times.ttf');
$fontsize = auto_font_size($text, 600, $fontfile);
//$fontsize = ($fontsize < 35) ? $fontsize : 35;

$box = new Box($new_image);
$box->setFontFace(__DIR__.'/fonts/times.ttf');
$box->setFontColor(new Color(255, 255, 255));
$box->setFontSize($fontsize);
$box->setBox(0, 10, 600, 800);
$box->setTextAlign('center', 'top');
$box->draw($text);

$box = new Box($new_image);
$box->setFontFace(__DIR__.'/fonts/UVNKieu.ttf');
$box->setFontColor(new Color(148, 82, 116));
$box->setFontSize(150);
$box->setLineHeight(0.5);
$box->setBox(240, 150, 300, 800);
$box->setTextAlign('right', 'top');
$box->draw("Bàn có năm chỗ ngồi");

$box = new Box($new_image);
$box->setFontFace(__DIR__.'/fonts/arial.ttf');
$box->setFontColor(new Color(0, 0, 0));
$box->setFontSize(20);
$box->setLineHeight(0.5);
$box->setBox(30, -35, 540, 800);
$box->setTextAlign('left', 'bottom');
$box->draw("NHÀ XUẤT BẢN TRẺ");

// in ra
header("Content-type: image/png"); // image/png trong suot
imagepng($new_image); // imagepng trong suot
imagedestroy($src);
imagedestroy($out);
imagedestroy($new_image);

// func gioi han font size 1 dong
function auto_font_size($text, $text_maxwidth, $fontfile, $fontsize = 1)
{
	do
	{
		$fontsize++;
		$bbox = imagettfbbox($fontsize, 0, $fontfile, $text);
		$text_width = $bbox[2] - $bbox[0];
		// $text_height = $bbox[1] - $bbox[7];
	}
	while ($text_width <= $text_maxwidth);
	return $fontsize;
}

// function xuat anh trong suot
function CreateBlankPNG($w, $h)
{
	$im = imagecreatetruecolor($w, $h);
	imagesavealpha($im, true);
	$transparent = imagecolorallocatealpha($im, 0, 0, 0, 127);
	imagefill($im, 0, 0, $transparent);
	return $im;
}

function setTransparency($new_image, $image_source)
{

	$transparencyIndex = imagecolortransparent($image_source);
	$transparencyColor = array(
		'red' => rand(1,255),
		'green' => rand(1,255),
		'blue' => rand(1,255)
	);

	if ($transparencyIndex >= 0)
	{
		$transparencyColor = imagecolorsforindex($image_source, $transparencyIndex);
	}

	$transparencyIndex = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);
	imagefill($new_image, 0, 0, $transparencyIndex);
	imagecolortransparent($new_image, $transparencyIndex);

}

// random mang
function random_array($array = array()) {
	$k = array_rand($array);
	return $array[$k];
}
//echo random_array(array('#000000', '#990000', '#ff6680'));
