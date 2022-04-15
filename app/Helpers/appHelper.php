<?php
use App\Models\Media;
use App\Models\Setting;
use App\Models\Menu;
use App\Models\MenuLink;
//use Barryvdh\DomPDF\Facade as PDF; 
use Ilovepdf\WatermarkTask;

ini_set('max_execution_time', 0);
function flash($message, $level = 'info')
{
    session()->flash('flash_message', $message);
    session()->flash('flash_message_level', $level);
}
//Save image, return id from medias table
function helperSaveImage($image, $path,$amount = 0,$img_360='') {
    $image_original_name =  $image->getClientOriginalName();
    $image_name = date('d_m_y_h_i_s').helperSanitizeFilename($image->getClientOriginalName());
    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $fullimage = Image::make($image);
    $size = $fullimage->filesize();
    $fullimage->save(storage_path('app/'.$path['storagepath'].$path['id'].'/').$image_name);
    $fullimage->save(public_path('database/'.$path['email'].'/'.$path['project_path'].'/original/').$image_name);
    $thumbnail = Image::make($image);
    $thumbnail->resize(800,165, function ($constraint) {
        $constraint->aspectRatio();
    });
    //$thumbnail->save(storage_path('app/'.$path.'user_thumb/').str_replace('.'.$image_ext,'.'.$image_ext,$image_name));
    $thumbnail->save(public_path('database/'.$path['email'].'/'.$path['project_path'].'/thumb/').str_replace('.'.$image_ext,'.'.$image_ext,$image_name));
    $medium = Image::make($image);
    $medium->resize(1000, null, function ($constraint) {
        $constraint->aspectRatio();
    });
    //$medium->save(storage_path('app/'.$path.'user_medium/').str_replace('.'.$image_ext,'.'.$image_ext,$image_name));
    $medium->save(public_path('database/'.$path['email'].'/'.$path['project_path'].'/medium/').str_replace('.'.$image_ext,'.'.$image_ext,$image_name));
    


    $watermark_img = Image::make($image);
    $watermark_img->resize(1000 ,null, function ($constraint) {
        $constraint->aspectRatio();
    });
    $img = Image::make($watermark_img);
    //$img = Image::make($image);

    $watermarkSource = Image::make(public_path('/images/white-logo.png'));
    $watermark = Image::make($watermarkSource);

    /* $x = 0;
    while ($x < $img->width()) {
      $y = 0;
      while($y < $img->height()) {
            $img->insert($watermarkSource, 'top-left', $x, $y);
            $y += $watermark->height();
      }
      $x += $watermark->width();
    } */
    $img->insert($watermarkSource, 'center', 10, 10);
    //$img->insert($watermarkSource, 'top', 10, 10);
    //$img->insert($watermarkSource, 'top-right', 10, 10);
    //$img->insert($watermarkSource, 'top-left', 10, 10);
    //$img->insert($watermarkSource, 'bottom', 10, 10);
    //$img->insert($watermarkSource, 'bottom-left', 10, 10);
    //$img->insert($watermarkSource, 'bottom-right', 10, 10);


    $img->save(public_path('uploads/').str_replace('.'.$image_ext,'.'.$image_ext,$image_name));

    $id = DB::table('medias')->insertGetId(
        ['media_type' => 'image',
            'title' => $image_original_name,
            'filename' => $image_name,
            'amount'=> $amount,
            'ext' => $image_ext,
            'status' => 1,
            'size' => $size,
            'img_360'=>$img_360,
        ]
    );
    return $id;
}
function helperSaveFile($file, $path, $amount = 0) {
    
    $file_original_name =  $file->getClientOriginalName();
    $file_name = date('d_m_y_h_i_s').helperSanitizeFilename($file->getClientOriginalName());
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $file->storeAs($path['storagepath'].$path['id'].'/',$file_name);

    $size = $file->getClientSize();

    $file->storeAs('/'.$path['email'].'/'.$path['project_path'].'/file/', $file_name );

    $file->move(public_path('uploads/'),$file_name);
    //echo public_path('database/'.$path['email'].'/'.$path['project_path'].'/file/'.$file_name); die;
    if($file_ext == 'pdf') {
        // //$pdf = PDF::loadFile(public_path('database/'.$path['email'].'/'.$path['project_path'].'/file/'.$file_name),$config = []);
        // $pdf = PDF::loadFile(public_path('sss.pdf'),$config = []);
        // print_r( $pdf); die;
        // $pdf->setWatermarkImage(public_path('/images/white-logo.png'));
        // $pdf->save(public_path('assets/file.pdf'));

        // to get your key pair, please visit https://developer.ilovepdf.com/user/projects
        $myTask = new WatermarkTask('project_public_ab3e7b861b8270de6752b27d79242916_S06rL10822b4ff8c00c395f6e0ab8844e8f46','secret_key_6fb8bc85794f3bf1014dc73e243d808e_DBIWoeaa5d8acd86175d16688c064c0942e17');

        // file var keeps info about server file id, name...
        // it can be used latter to cancel file
        $file = $myTask->addFile(public_path('uploads/').$file_name);

        // set mode to text
        $myTask->setMode("text");
        //$myTask->setMode("image");

        // set the text
        $myTask->setText("DataCuda");
        //$myTask->setImage(public_path('/images/white-logo.png'));
        // process files
        $myTask->execute();

        // and finally download the unlocked file. If no path is set, it will be downloaded on current folder
        $myTask->download(public_path('uploads/'));
    }
    $id = DB::table('medias')->insertGetId(
        ['media_type' => 'image',
            'title' =>$file_original_name,
            'filename' => $file_name,
            'amount'=> $amount,
            'ext' => $file_ext,
            'status' => 1,
            'size' => $size
        ]
    );
    return $id;
}
function processVideo($videoSource,$path,$amount = 0)
{
    $video_original_name =  $videoSource->getClientOriginalName();
    $video_ext = 'mp4';
    //$file_name = date('d_m_y_h_i_s').helperSanitizeFilename($videoSource->getClientOriginalName());
    $file_name = date('d_m_y_h_i_s').rand().'.'.$video_ext;
    $size = $videoSource->getClientSize();
    $storagepath = storage_path('app/'.$path['storagepath'].$path['id'].'/');
    $userpath = public_path('database/'.$path['email'].'/'.$path['project_path'].'/file/');
    $ffmpeg = FFMpeg\FFMpeg::create();
    $video = $ffmpeg->open($videoSource);
    $format = new FFMpeg\Format\Video\X264('libmp3lame', 'libx264');
    $format
        -> setKiloBitrate(1000)
        -> setAudioChannels(2)
        -> setAudioKiloBitrate(256);
    $video->save($format, $storagepath.$file_name);
    $video->save($format, $userpath.$file_name);
   /* $videoSource->move($storagepath,$file_name);
    \File::copy($storagepath.$file_name,$userpath.$file_name);*/
    $watermark = base_path('public/images/white-logo.png');
    exec('ffmpeg -i '.$storagepath.$file_name.' -i '.$watermark.' -filter_complex overlay '.base_path('public/uploads/'.$file_name));

    //$publicPath = public_path('database/');
    // $video
    // ->filters()
    // ->watermark($watermark, array(
    //     'position' => 'relative',
    //     'bottom' => 50,
    //     'right' => 50,
    // ));

    // $video->save(new FFMpeg\Format\Video\WebM(), $publicPath.$file_name);

    $id = DB::table('medias')->insertGetId(
        ['media_type' => 'image',
            'title' => $video_original_name,
            'filename' => $file_name,
            'amount'=> $amount,
            'ext' => 'mp4',
            'status' => 1,
            'size' => $size
        ]
    );
    return $id;
}
function oldprocessVideo($videoSource,$path,$amount = 0)
{
    $reqExtension = 'mp4';
    $file_name = date('d_m_y_h_i_s').helperSanitizeFilename($videoSource->getClientOriginalName());
    $watermark = public_path('/images/white-logo.png');
    $ffmpeg = FFMpeg\FFMpeg::create();
    $video = $ffmpeg->open($videoSource);
    $format = new FFMpeg\Format\Video\X264('libmp3lame', 'libx264');
    if (!empty($watermark))
    {
        $filters = new FFMpeg\Filters\Video\WatermarkFilter(public_path('/images/white-logo.png'), [
            'position' => 'absolute',
             'x' => 1180,
              'y' => 620,
        ]);
        $filters->apply();

        $video->addFilter($filters);
    }
    $format
        -> setKiloBitrate(1000)
        -> setAudioChannels(2)
        -> setAudioKiloBitrate(256);
    $randomFileName = rand().".$reqExtension";
    $saveLocation = getcwd(). '/public/uploads/'.$randomFileName;
    $saveLocation = base_path('publicuploads/').$file_name;
    $video->storeAs('public/user_files', $file_name);
    $video->storeAs(storage_path('app/usersdata/'.$path['id'].'/').$file_name);
    $video->storeAs(public_path('database/'.$path['email'].'/'.$path['project_path'].'/original/').$file_name);
    $video->storeAs(public_path('upload/').$file_name);
    $video->save($format, $saveLocation);
    /* //$watermark = public_path('images/white-logo.png');
     exec('ffmpeg -i D:\text\vide.3gp -i '.base_path('public\images\white-logo.png').' -filter_complex overlay '.base_path('public\uploads\output.mp4').'');*/

}


function helperSaveImageNewOne($image, $path) {
    $image_name = helperSanitizeFilename($image->getClientOriginalName());
    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $count = Media::where('filename', $image_name)->count();
    if ($count > '0')
    {
        $image_name = pathinfo($image_name, PATHINFO_FILENAME).'_'.date("ymdHi").'.'.$image_ext;
    }
    $count = Media::where('filename', $image_name)->count();

    $thumbnail = Image::make($image);
    $thumbnail->resize(1000, null, function ($constraint) {
        $constraint->aspectRatio();
    });

    $thumbnail->save(storage_path('app/avatars/'.$image_name));
}


function helperCreateThumbsandMedium($path, $filetype = '.jpg') {

    $dir = $path.'*'.$filetype; // images/*.jpg
    // $dir = storage_path('app/images').'/*'.$filetype;
    $images = glob( $dir );
    foreach ($images as $key => $image) {

        if(strpos($image,'_thumb.') === false && strpos($image,'_medium.') === false) {
            if(!in_array(str_replace($filetype, '_thumb'.$filetype,$image), $images))
            {
                $thumbnail = Image::make($image);
                $thumbnail->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $thumbname = $thumbnail->filename.'_thumb.'.$thumbnail->extension;
                $thumbnail->save(storage_path('app/images/').$thumbname);
            }
            if(!in_array(str_replace($filetype, '_medium'.$filetype,$image), $images))
            {

                $medium = Image::make($image);
                $medium->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $mediumname = $medium->filename.'_medium.'.$medium->extension;
                $medium->save(storage_path('app/images/').$mediumname);
            }
        }
    }
}

function helperNameCleaner($name) {
    $search = array('å', 'ä', 'ö', ' ');
    $replace = array('a', 'a', 'o' , '-');
    return str_replace($search, $replace, $name);
}

function helperSanitizeFilename( $filename ) {
    $filename_raw = $filename;
    $special_chars = array("å", "ä", "ö", "?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}");
    $filename = str_replace($special_chars, array('a','a','o','-'), $filename);
    $filename = preg_replace('/[\s-]+/', '-', $filename);
    $filename = trim($filename, '.-_');
    return $filename;
}

function classActivePath($path)
{
    $path = explode('.', $path);
    $segment = 1;
    foreach($path as $p) {
        if((request()->segment($segment) == $p) != false) {
            return 'active';
        }
        $segment++;
    }
    return '';
}
function pr($var, $die = true)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    if($die) {
        die();
    }
}

function helperMenuitemIsActive($link)
{
    $current_url = explode("/", Request::url());

    if(in_array($link, $current_url) || in_array(str_singular($link), $current_url)) {
        return true;
    }
    if(($link == 'blog' || $link == 'blogg') && in_array('category', $current_url)) {
        return true;
    }
    return false;
}

function helperGetSetting($title) {
    return Setting::where('title', $title)->first();
}

function urlWithoutLang($path)
{
    $path = explode('/', $path);
    $segment = 1;
    $url = '';
    foreach($path as $p) {
        if((request()->segment($segment) == $p) == false) {
            return '';
        } else {
            if($segment != 1)
            {
                $url .= $p.'/';
            }
        }
        $segment++;
    }
    return $url;
}

function helperExcerpt($str, $maxLength) {
    if(strlen($str) > $maxLength) {
        $excerpt   = substr($str, 1, $maxLength);
        $excerpt   = strip_tags($excerpt);
        $excerpt  .= '...';
    } else {
        $excerpt = $str;
        $excerpt   = substr($str, 1);
        $excerpt   = strip_tags($excerpt);
    }
    return $excerpt;
}

function getExcerpt($str, $startPos=0, $maxLength=100) {

    $str = strip_tags($str);

    if(strlen($str) > $maxLength) {
        $excerpt   = substr($str, $startPos, $maxLength-3);
        $lastSpace = strrpos($excerpt, ' ');
        $excerpt   = substr($excerpt, 0, $lastSpace);
        $excerpt  .= '...';
    } else {
        $excerpt = $str;
    }

    return $excerpt;
}

function helperGetMenu($lang, $menu_position) {

    $querymenu = Menu::where('position', $menu_position)->first();
    $menu = MenuLink::where('menu_id', $querymenu->id)->where('lang_code', $lang)->orderBy('sort_order', 'asc')->get();

    $menus = array();
    foreach ($menu as $key => $value) {
        if ($value['parent_id'] === NULL)
        {
            $menus[$value['id']]['title'] = $value['title'];
            $menus[$value['id']]['url'] = $value['url'];
            $menus[$value['id']]['sort_order'] = $value['sort_order'];
            $menus[$value['id']]['has_childs'] = 0;
        }
        else
        {
            $menus[$value['parent_id']]['has_childs'] = 1;
            $menus[$value['parent_id']]['childrens'][$key]['title'] = $value['title'];
            $menus[$value['parent_id']]['childrens'][$key]['url'] = $value['url'];
            $menus[$value['parent_id']]['childrens'][$key]['sort_order'] = $value['sort_order'];
        }
    }
    if($lang=="sv"){
        unset($menus[9]);
    }else{
        unset($menus[6]);
    }

    return $menus;
}

class PseudoCrypt {

    /* Key: Next prime greater than 62 ^ n / 1.618033988749894848 */
    /* Value: modular multiplicative inverse */
    private static $golden_primes = array(
        '1'                  => '1',
        '41'                 => '59',
        '2377'               => '1677',
        '147299'             => '187507',
        '9132313'            => '5952585',
        '566201239'          => '643566407',
        '35104476161'        => '22071637057',
        '2176477521929'      => '294289236153',
        '134941606358731'    => '88879354792675',
        '8366379594239857'   => '7275288500431249',
        '518715534842869223' => '280042546585394647'
    );

    /* Ascii :                    0  9,         A  Z,         a  z     */
    /* $chars = array_merge(range(48,57), range(65,90), range(97,122)) */
    private static $chars62 = array(
        0=>48,1=>49,2=>50,3=>51,4=>52,5=>53,6=>54,7=>55,8=>56,9=>57,10=>65,
        11=>66,12=>67,13=>68,14=>69,15=>70,16=>71,17=>72,18=>73,19=>74,20=>75,
        21=>76,22=>77,23=>78,24=>79,25=>80,26=>81,27=>82,28=>83,29=>84,30=>85,
        31=>86,32=>87,33=>88,34=>89,35=>90,36=>97,37=>98,38=>99,39=>100,40=>101,
        41=>102,42=>103,43=>104,44=>105,45=>106,46=>107,47=>108,48=>109,49=>110,
        50=>111,51=>112,52=>113,53=>114,54=>115,55=>116,56=>117,57=>118,58=>119,
        59=>120,60=>121,61=>122
    );

    public static function base62($int) {
        $key = "";
        while(bccomp($int, 0) > 0) {
            $mod = bcmod($int, 62);
            $key .= chr(self::$chars62[$mod]);
            $int = bcdiv($int, 62);
        }
        return strrev($key);
    }

    public static function hash($num, $len = 5) {
        $ceil = bcpow(62, $len);
        $primes = array_keys(self::$golden_primes);
        $prime = $primes[$len];
        $dec = bcmod(bcmul($num, $prime), $ceil);
        $hash = self::base62($dec);
        return str_pad($hash, $len, "0", STR_PAD_LEFT);
    }

    public static function unbase62($key) {
        $int = 0;
        foreach(str_split(strrev($key)) as $i => $char) {
            $dec = array_search(ord($char), self::$chars62);
            $int = bcadd(bcmul($dec, bcpow(62, $i)), $int);
        }
        return $int;
    }

    public static function unhash($hash) {
        $len = strlen($hash);
        $ceil = bcpow(62, $len);
        $mmiprimes = array_values(self::$golden_primes);
        $mmi = $mmiprimes[$len];
        $num = self::unbase62($hash);
        $dec = bcmod(bcmul($num, $mmi), $ceil);
        return $dec;
    }


    //Save image, return id from medias table


}


