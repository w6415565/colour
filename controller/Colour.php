<?php
namespace app\colour\controller;
use think\Db;
use think\Image;
use think\Config;
use app\src\controller\Snoopy;
use app\colour\controller\Cmade;
use think\facade\Session;



    class Colour extends \think\Controller
    {

        public function initialize() //初始化

        {

            // Session::set('uid', '','colour');// 赋值colour作用域
            // Session::set('pwd', '','colour');// 赋值colour作用域

        }
        public function Colourtry()//试用用户取色
        {

                $uid = 'try_user';// 

                if(request()->isPost())
                {
                        $this->Ruser($uid);//记录数据
            
                        $path = '../public/uploads/colour/';
                        $pathjpg = '../public/uploads/colour/jpg/';

                        $name11 = date('YmdHis');//date('Y-m-d H:i:s')
                        $name1 = input('pname').'★标准样★'.$name11;
                        $name2 = input('pname').'★测试样★'.$name11;

                            $base64 = input('base64');
                            $base641 = input('base641');
                            $this-> base64($base64,$pathjpg,$name1);
                            $this-> base64($base641,$pathjpg,$name2);

        
                            $cmade = new Cmade;
                                    
                            $aa1=$cmade->Made($pathjpg,$name1.'.jpg',$name1); 
                            $aa2=$cmade->Made($pathjpg,$name2.'.jpg',$name2); 
        
        
                            $aa = count($aa1);
                                    
                                for($cii=0;$cii<$aa;$cii++) 
                                {
                                    $r = $aa1[$cii][2];
                                    $g = $aa1[$cii][3];
                                    $b = $aa1[$cii][4];
        
                                    $table = 'colour_o';
                                    DB::connect('mysql://root:64315565@127.0.0.1:3306/c_user#utf8')->table($table)->insert
                                    ([
                                        'r'=>$r,
                                        'g'=>$g,
                                        'b'=>$b,
                                        'name'=>$name1,
                                        'rgb'=>$aa1[$cii][1],
                                        'date'=>date('Y.m.d H:i:s'),
                                        'jpg_base64'=>$base64,
        
                                    ]);
        
                                }
                            $a2 = count($aa2);
                                    
                                for($cii2=0;$cii2<$a2;$cii2++) 
                                {
                                    $r = $aa2[$cii2][2];
                                    $g = $aa2[$cii2][3];
                                    $b = $aa2[$cii2][4];
        
                                    $table = 'colour_o';
                                    DB::connect('mysql://root:64315565@127.0.0.1:3306/c_user#utf8')->table($table)->insert
                                    ([
                                        'r'=>$r,
                                        'g'=>$g,
                                        'b'=>$b,
                                        'name'=>$name2,
                                        'rgb'=>$aa2[$cii2][1],
                                        'date'=>date('Y.m.d H:i:s'),
                                        'jpg_base64'=>$base641,
        
                                    ]);
        
                                }
        
        
                            $mmm = '/mysitetp51/public/index.php/report?name1='.$name1.'&name2='.$name2;
                            $this->redirect($mmm);



                }



                return view();


        }

        public function Newt ($table)//创建新表
        {

            $table= substr($table,0 ,8);//取前面8个字符

            $table = 'c_'.$table;


            $sql11 = "SHOW TABLES LIKE '". $table."'";//判断数据中表是不是存在

            $ff = Db::connect('mysql://root:64315565@127.0.0.1:3306/c_user#utf8')->query($sql11);//判断数据中表是不是存在


            if($ff)
            {
                return 0;

            }else{

            
                $sql = "CREATE TABLE $table
                (
                    id int(11) NOT NULL AUTO_INCREMENT,
                    u_uid varchar(255) DEFAULT NULL,
                    ip varchar(255) DEFAULT NULL,
                    u_date datetime DEFAULT NULL,
                    prem varchar(255) DEFAULT NULL,
                    PRIMARY KEY (id)
                ) ENGINE=InnoDB AUTO_INCREMENT=1115 DEFAULT CHARSET=utf8";

                DB::connect('mysql://root:64315565@127.0.0.1:3306/c_user#utf8')->query($sql);//创建新表

                return 1;

            }
    
        }
        public function Ruser ($table)//记录数据
        {
    
            // $sql = "CREATE TABLE $table
            // (
            //     id int(11) NOT NULL AUTO_INCREMENT,
            //     u_uid varchar(255) DEFAULT NULL,
            //     ip varchar(255) DEFAULT NULL,
            //     u_date datetime DEFAULT NULL,
            //     prem varchar(255) DEFAULT NULL,
            //     PRIMARY KEY (id)
            // ) ENGINE=InnoDB AUTO_INCREMENT=1115 DEFAULT CHARSET=utf8";

            // DB::connect('mysql://root:64315565@127.0.0.1:3306/c_user#utf8')->query($sql);//创建新表
                // 记录用户始
                if($table=='try_user')
                {
                    $table='try_user';

                }else{

                    $table= substr($table,0 ,8);//取前面8个字符

                    $table = 'c_'.$table;
    
                }

                $sql11 = "SHOW TABLES LIKE '$table'";//判断数据中表是不是存在

                $ff = Db::connect('mysql://root:64315565@127.0.0.1:3306/c_user#utf8')->query($sql11);//判断数据中表是不是存在
    
                if($ff)
                {
                    
                    $time = date("Y-m-d H:i:s",$_SERVER["REQUEST_TIME"]); //当前时间年月日小时分钟秒-访问时间
                    $se1 = $_SERVER['REMOTE_HOST'];//取客户访问主机IP
                    $se5 = $_SERVER['HTTP_USER_AGENT'];//取客户访问主机操作系统
                    $se5 = strstr($se5,'(');
                    $se5 = strstr($se5,')',true);
                    $se5 = substr($se5,0 ,33);

                    $ip = $se1;
        
                    $pp=IpLocation::getLocation($ip);
                    $lation=$pp['area'];
                    DB::connect('mysql://root:64315565@127.0.0.1:3306/c_user#utf8')->table($table)->insert
                    ([
                        'u_uid'=>$lation,
                        'ip'=>$se1,
                        'u_date'=>$time,
                        'prem'=>$se5,
                    ]);
                    return 1;

                }else{
                    return 0;
                }




        }
        public function Suser ($table)//试用用户数据对比
        {
            

            // $sql11 = "SHOW TABLES LIKE '$table'";//判断数据中表是不是存在

            // $ff1 = Db::connect('mysql://root:64315565@127.0.0.1:3306/c_user#utf8')->query($sql11);//判断数据中表是不是存在

            // if(!$ff1)
            // {
            //     return 21;
            // }

    
            $se1 = $_SERVER['REMOTE_HOST'];//取客户访问主机IP
            $se5 = $_SERVER['HTTP_USER_AGENT'];//取客户访问主机操作系统
            $se5 = strstr($se5,'(');
            $se5 = strstr($se5,')',true);
            $se5 = substr($se5,0 ,33);

            $sql11 = "SELECT * from $table where ip = '$se1' and prem = '$se5'";

            $ff = count(Db::connect('mysql://root:64315565@127.0.0.1:3306/c_user#utf8')->query($sql11));

            return $ff;
        }



        public function report ($name1='',$name2='')//生成网页报告
        {


                $sql = "SELECT * from colour_o where name = '$name1' ";//列出所有

                $c1= Db::connect('mysql://root:64315565@127.0.0.1:3306/c_user#utf8')->query($sql);

                $count1 = count($c1);

                // var_dump($j_ip);
                // exit;

                $sql2 = "SELECT * from colour_o where name = '$name2' ";//列出所有

                $c2= Db::connect('mysql://root:64315565@127.0.0.1:3306/c_user#utf8')->query($sql2);

                $count2 = count($c2);

                $sim = $this->similar($c1,$c2,$count1,$count2);
                $similar = $sim[0];

                $nnn1 = explode("★", $name1);
                $nnn2 = explode("★", $name2);

                // var_dump($nnn1);
                // var_dump($nnn2);
                // exit;


                $n1 = $nnn1[0].'★'.$nnn1[1];
                $n2 = $nnn2[0].'★'.$nnn2[1];

                $this->assign('jj1',$c1);
                $this->assign('jj2',$c2);
                $this->assign('name1',$n1);
                $this->assign('name2',$n2);
                $this->assign('similar',$similar);
                $this->assign('sim',$sim);
                // $this->assign('h',$h);
                return view();
                exit;
    
        }
    
        public function similar($c1,$c2,$count1,$count2)//比较颜色相似度
        {

            if($count1>$count2)
            {
                $count = $count2;
                $cc1 =$c2;
                $cc2 =$c1;

            }else
            {
                $count = $count1;
                $cc1 =$c1;
                $cc2 =$c2;

            }


                    foreach($cc1 as $key => $value)//两个取得的颜色值相减值存到数组中
                        {
                            
                                $r1r = $value['r']-$cc2[$key]['r'];
                                $g1g = $value['g']-$cc2[$key]['g'];
                                $b1b = $value['b']-$cc2[$key]['b'];
                                
                                $r[$key]=abs($value['r']-$cc2[$key]['r']);
                                $g[$key]=abs($value['g']-$cc2[$key]['g']);
                                $b[$key]=abs($value['b']-$cc2[$key]['b']);

                                // if($r1r>=0){$r1[$key]=1}else{$r1[$key]=-1}};
                                // if($g1g>=0){$g2[$key]=1}else{$g2[$key]=-1}};
                                // if($b1b>=0){$b3[$key]=1}else{$b3[$key]=-1}};

                        }

                        $rsum=0;
                        foreach($r as $r1)
                        {
                            $rsum = $rsum+$this->cp($r1,$count);
                        }

                        $gsum=0;
                        foreach($g as $r1)
                        {
                            $gsum = $gsum+$this->cp($r1,$count);
                        }

                        $bsum=0;
                        foreach($b as $r1)
                        {
                            $bsum = $bsum+$this->cp($r1,$count);
                        }




                        if($rsum==0)
                        {
                            $rsum1 = 10;
                        }else
                        {
                            $rsum1 = $rsum/3;
                        }

                        if($gsum==0)
                        {
                            $gsum1 = 10;
                        }else
                        {
                            $gsum1 = $gsum/3;
                        }

                        if($bsum==0)
                        {
                            $bsum1 = 10;
                        }else
                        {
                            $bsum1 = $bsum/3;
                        }

                       $max = floor($rsum1+$gsum1+$bsum1);
                    //    $max = floor(MAX($rsum,$gsum,$bsum));

                        $rgb = [$max, floor($rsum), floor($gsum), floor($bsum)];

                        return $rgb;

                
        }

        public function cp($n,$count)//颜色相似度数据
        {
            if($n<=5)
            {
                return 100/$count;
            }else
            {
                if($n<=10)
                {
                    return 80/$count;
                }else
                {
                    if($n<=20)
                    {
                        return 70/$count;
                    }else
                    {
                        if($n<=40)
                        {
                            return 50/$count;
                        }else
                        {
                            return 0;
                        }
                    }
                }
            }
        }

        function base64($base64_image_content,$path,$name)//图片格式转换
        {
            //匹配出图片的格式
            // $imgUrl = "/".date('Ymd',time())."/";
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
                $type = $result[2];
                // $new_file = $path.$name;
                // if(!file_exists($new_file)){
                //     //检查是否有该文件夹，如果没有就创建，并给予最高权限
                //     mkdir($new_file, 0700);
                // }
                $imgUrl = $name.".jpg";
                $new_file =  $path.$imgUrl;
                if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
                    return $imgUrl;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

            

    }
?>
