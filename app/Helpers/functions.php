<?php

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;



function send_mail_invoice($mail_details){
    Mail::send($mail_details['view'],$mail_details, function($message)use($mail_details){

        $message->from($mail_details['from_id']);
        $message->to($mail_details['email_id'])->subject($mail_details['subject']);

        $is_valid = file_exists($mail_details['attechment']);
        if (($mail_details['include'] == '1') && $is_valid) {
            $message->attach($mail_details['attechment']);
        }
    });
    return true;
}



function key_encryption($key,$e = 'e'){
    if($e == 'd'):
        $decrypted = Crypt::decryptString($key);
        return $decrypted;
    endif;
    $encrypted = Crypt::encryptString($key);
    return $encrypted;
}

function send_mail($mail_details){
    Mail::send($mail_details['view'], ['data' => $mail_details['data'],'email_id'=>$mail_details['email_id']], function($message)use($mail_details)
    {
        $message->from($mail_details['from_id']);
        $message->to($mail_details['email_id'])->subject($mail_details['subject']);
    });
    return true;
}


function send_mail_project($mail_details){
    Mail::send($mail_details['view'], ['data' => $mail_details['data'],'email_id'=>$mail_details['email_id'],
        'media_details' => $mail_details['project_data'] ], function($message)use($mail_details)
    {
        $message->from($mail_details['from_id']);
        $message->to($mail_details['email_id'])->subject($mail_details['subject']);
    });
    return true;
}
function send_mail_project_attach($mail_details){

    Mail::send($mail_details['view'], ['data' => $mail_details['data'],'email_id'=>$mail_details['email_id'],
        'media_details' => $mail_details['project_data'] ], function($message)use($mail_details){
        $message->from($mail_details['from_id']);
        $message->to($mail_details['email_id'])->subject($mail_details['subject']);
        $message->attach($mail_details['file_link']);
    });
    return true;
}
function random($length = 16)
{
    if ( ! function_exists('openssl_random_pseudo_bytes'))
    {
        throw new RuntimeException('OpenSSL extension is required.');
    }

    $bytes = openssl_random_pseudo_bytes($length * 2);

    if ($bytes === false)
    {
        throw new RuntimeException('Unable to generate random string.');
    }

    return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
}
function create_public_dir($data,$exp){
    
    $dir = [];
    if($exp == 'r'):
           if(!File::isDirectory(public_path('database/'.$data['email'])))
           {
               $dir[] = mkdir(public_path('database/'.$data['email']),0775,true);
               return $dir;
           }
    endif;
    if($exp == 'p'):
            if(!File::isDirectory(public_path('database/'.$data['email'].'/'.$data['project_path'].$data['id'])))
            {
                $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].$data['id']),0775,true);
                $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].$data['id'].'/original'),0775,true);
                $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].$data['id'].'/thumb'),0775,true);
                $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].$data['id'].'/medium'),0775,true);
                $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].$data['id'].'/file'),0775,true);
                $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].$data['id'].'/images'),0775,true);
                $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].$data['id'].'/avatars'),0775,true);
                $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].$data['id'].'/zip'),0775,true);
                $dir[] = mkdir(storage_path('app/usersdata/'.$data['id']),0775,true);
                return $dir;
            }
    endif;
    if($exp == 'share_project'):
        if(!File::isDirectory(public_path('database/'.$data['email'].'/'.$data['project_path'].$data['id'])))
        {
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].$data['id']),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].$data['id'].'/original'),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].$data['id'].'/thumb'),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].$data['id'].'/medium'),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].$data['id'].'/file'),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].$data['id'].'/images'),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].$data['id'].'/avatars'),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].$data['id'].'/zip'),0775,true);
            return $dir;
        }
    endif;
    if($exp == 'single_images'):
        if(!File::isDirectory(public_path('database/'.$data['email'].'/'.$data['project_path'])))
        {
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path']),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].'/original'),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].'/thumb'),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].'/medium'),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].'/file'),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].'/images'),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].'/avatars'),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].'/zip'),0775,true);
        }
        if(!File::isDirectory(storage_path('app/users/' . $data['id']))) {
            $dir[] = mkdir(storage_path('app/users/' . $data['id']),0775,true);
        }
        return $dir;
    endif;
    if($exp == 'share_single_images'):
        if(!File::isDirectory(public_path('database/'.$data['email'].'/'.$data['project_path'])))
        {
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path']),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].'/original'),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].'/thumb'),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].'/medium'),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].'/file'),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].'/images'),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].'/avatars'),0775,true);
            $dir[] = mkdir(public_path('database/'.$data['email'].'/'.$data['project_path'].'/zip'),0775,true);
            return $dir;
        }
    endif;

    if ($exp == 'us') :
        if (!File::isDirectory(public_path('database/' . $data['email'] . '/UserStorage'))) {
            $dir[] = mkdir(public_path('database/' . $data['email'] . '/UserStorage'), 0775, true);
        }
        if (!File::isDirectory(public_path('database/' . $data['email'] . '/UserStorage/' . $data['project_path'] . $data['id']))) {
            $dir[] = mkdir(public_path('database/' . $data['email'] . '/UserStorage/' . $data['project_path'] . $data['id']), 0775, true);
            $dir[] = mkdir(public_path('database/' . $data['email'] . '/UserStorage/' . $data['project_path'] . $data['id'] . '/original'), 0775, true);
            $dir[] = mkdir(public_path('database/' . $data['email'] . '/UserStorage/' . $data['project_path'] . $data['id'] . '/thumb'), 0775, true);
            $dir[] = mkdir(public_path('database/' . $data['email'] . '/UserStorage/' . $data['project_path'] . $data['id'] . '/medium'), 0775, true);
            $dir[] = mkdir(public_path('database/' . $data['email'] . '/UserStorage/' . $data['project_path'] . $data['id'] . '/file'), 0775, true);
            $dir[] = mkdir(public_path('database/' . $data['email'] . '/UserStorage/' . $data['project_path'] . $data['id'] . '/images'), 0775, true);
            $dir[] = mkdir(public_path('database/' . $data['email'] . '/UserStorage/' . $data['project_path'] . $data['id'] . '/avatars'), 0775, true);
            $dir[] = mkdir(public_path('database/' . $data['email'] . '/UserStorage/' . $data['project_path'] . $data['id'] . '/zip'), 0775, true);
        }
        if (!File::isDirectory(storage_path('app/UserStorage'))) {
            $dir[] = mkdir(storage_path('app/UserStorage'), 0775, true);
            $dir[] = mkdir(storage_path('app/UserStorage/' . $data['id']), 0775, true);
        } else {
            $dir[] = mkdir(storage_path('app/UserStorage/' . $data['id']), 0775, true);
        }
        return $dir;
    endif;
}

/***
 * function : custom_copy
 * working  : copy directory  
 */

function custom_copy($src, $dst){  
  
    // open the source directory 
    $dir = opendir($src);  

    // Make the destination directory if not exist 
    if(!is_dir($dst)) {
       mkdir($dst,0775,true);
    }

    // Loop through the files in source directory 
    while( $file = readdir($dir) ) {  
        
        if (( $file != '.' ) && ( $file != '..' )) {  
            if (is_dir($src . '/' . $file) ){  
                // Recursively calling custom copy function 
                // for sub directory  
                custom_copy($src . '/' . $file, $dst . '/' . $file);  
            }  
            else{  
                copy($src . '/' . $file, $dst . '/' . $file);  
            }  
        }  
    }  
  
    closedir($dir); 
}


function rand_string( $length ) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);

}
function convertToReadableSize($size){
    if($size == 0){
        $data['value'] = 0;
        $data['type']  = 'B';
        return $data;
    }
    $base = log($size) / log(1024);
    $suffix = array("B", "KB", "MB", "GB", "TB");
    $f_base = floor($base);
    $data['value'] = round(pow(1024, $base - floor($base)), 1);
    $data['type']  = $suffix[$f_base];
    return $data;
   // return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];

}

function memoryConverterToBytes (int $quantity, string $unit):int {
    switch (strtoupper ($unit)) {
        case 'TB':
            return $quantity * 1099511627776;
        case 'GB':
            return $quantity * 1073741824;
        case 'MB':
            return $quantity * 1048576;
    }

}

function reverseMemoryConversion (int $quantity):float {
    $tb = 1099511627776;
    $gb = 1073741824;
    $mb = 1048576;

    if ($quantity >= $tb) {
        return number_format ($quantity/$tb, 2, '.', '');
    } else if ($quantity >= $gb) {
        return number_format ($quantity/$gb, 2, '.', '');
    }

    return number_format ($quantity/$mb, 2, '.', '');
}

function reverseMemoryConversionUnit (int $quantity):string {
    $tb = 1099511627776;
    $gb = 1073741824;
    $mb = 1048576;

    if ($quantity >= $tb) {
        return 'tb';
    } else if ($quantity >= $gb) {
        return 'gb';
    }
    
    return 'mb';
}