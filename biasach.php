<?php
require __DIR__.'/vendor/autoload.php';

use GDText\Box;
use GDText\Color;

$im = imagecreatetruecolor(500, 500);
$backgroundColor = imagecolorallocate($im, 255, 255, 253);
imagefill($im, 0, 0, $backgroundColor);

$box = new Box($im);
$box->setFontFace(__DIR__.'/fonts/times.ttf');
$box->setFontColor(new Color(98, 86, 60));
$box->setFontSize(45);
$box->setBox(20, 20, 460, 460);
$box->setTextAlign('center', 'top');
$box->draw("nguyễn nhật ánh");

$box = new Box($im);
$box->setFontFace(__DIR__.'/fonts/UVNKieu.ttf');
$box->setFontColor(new Color(148, 82, 116));
$box->setFontSize(100);
$box->setLineHeight(0.5);
$box->setBox(200, 120, 250, 460);
$box->setTextAlign('right', 'top');
$box->draw("Cô gái đến từ hôm qua");

$box = new Box($im);
$box->setFontFace(__DIR__.'/fonts/arial.ttf');
$box->setFontColor(new Color(148, 82, 116));
$box->setFontSize(25);
$box->setLineHeight(0.5);
$box->setBox(20, 0, 460, 500);
$box->setTextAlign('left', 'bottom');
$box->draw("NHÀ XUẤT BẢN TRẺ");

header("Content-type: image/png");
imagepng($im);