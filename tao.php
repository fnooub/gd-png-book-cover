<?php
/*
 * https://www.transparenttextures.com/
 * https://stackoverflow.com/questions/4060437/how-to-load-and-repeat-x-an-image-with-php-gd
 */
$imgs = glob("anh/*.png");
$srcfile = random_array($imgs);
//$srcfile = 'anh/cartographer.png';
$outfile = 'background.png';
list($src_w,$src_h,$src_type) = getimagesize($srcfile);

$out_w = 1280;
$out_h = 720;

// tao vong lap
$src = imagecreatefrompng($srcfile);
$out = CreateBlankPNG($out_w, $out_h);

$curr_x = 0;
while($curr_x < $out_w) {
    $curr_y = 0;
    while($curr_y < $out_h){
       imagecopy($out, $src, $curr_x, $curr_y, 0, 0, $src_w, $src_h);
       $curr_y += $src_h;
      }
    $curr_x += $src_w;
    }

// tao lop mau nen
$new_image = imagecreatetruecolor($out_w, $out_h);
setTransparency($new_image, $out);
imagecopyresampled($new_image, $out, 0, 0, 0, 0, $out_w, $out_h, $out_w, $out_h);

// in ra
header('Content-Type: image/png');
imagepng($new_image);
imagedestroy($src);
imagedestroy($out);
imagedestroy($new_image);

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

function random_array($array = array()) {
  $k = array_rand($array);
  return $array[$k];
}
//echo random_array(array('#000000', '#990000', '#ff6680'));
