<?php
namespace app\src\controller;
use think\Db;
use think\Image;
use think\Config;
use app\index\controller\Iplog;
use app\index\controller\IpLocation;
use app\src\controller\Snoopy;

use app\src\controller\SMTP;
use app\src\controller\PHPMailer;



    class Cmade extends \think\Controller
    {
        public function Made($path,$name,$dd)
        //$path='../public/uploads/colour/',$name='66.jpg')
        {
            $name1 = $path.$name;//
            $average = new \Imagick($name1);
            $e1 = $average->COLORSPACE_RGB;
            $average->quantizeImage(10, $e1, 0, false, false);
            $average->uniqueImageColors();
            $im = $average->getPixelIterator()->getNextIteratorRow();
            foreach ( $im as $pixel )
            {
                $carr[] = $pixel->getColor();
            }
            $d = 0;
            foreach($carr as $ca)
            {
                $r = $ca['r'];
                $g = $ca['g'];
                $b = $ca['b'];

                $cc = 'rgb('.$r.','.$g.','.$b.')';
                // $image = new \Imagick();
                // $draw = new \ImagickDraw();
                // $pixel = new \ImagickPixel($cc);
                // $x =60;//宽度
                // $y =$x;//高度
                // $image->newImage($x, $y, $pixel);
                // $path1 = $path.$dd.$d.'.png';//保存图片路径
                // $image->writeImage($path1);//保存图片

                $aa[] = ["$d","$cc","$r","$g","$b"];
                $d++;
            }
            return $aa;
        }
            }
?>
