<?php
use Carbon\Carbon;
/**
 * [将空的str转化为Null]
 * @param [type] $val
 */

function Empty_Null($val)
{
	return $val == "" ? null : $val;
}
function checkPerm($perm_route){
   if (Auth::user()) {
       return Auth::user()->hasPerm($perm_route);
   }
}
/**
 * [验证role为admin 并且 user为admin]
 * @param  [type] $role 角色
 * @param  [type] $user 用户
 * @return [type]       [description]
 */
function protect_user_admin($role, $user)
{
	if ($role->is_admin() && $user->is_admin())
		return 'disabled';
}
/**
 * 文件删除
 * @param  $file_path fill full path
 * @return bool      true 文件没有删除 false 文件删除
 */
function deletefile($file_path)
{
	@unlink($file_path);
	if (is_file($file_path)) {
		return true;
	}
	else {
		return false;
	}
}
/**
 * 递归删除多级目录文件夹
 * @param  [type] $directory fill full name
 * @return [type]            [description]
 */
function deletedir($directory) {
	 if(is_dir($directory)){//判断目录是否存在，如果不存在rmdir()函数会出错
        if($dir_handle=@opendir($directory)){//打开目录返回目录资源，并判断是否成功
            while($filename=readdir($dir_handle)){//遍历目录，读出目录中的文件或文件夹
                if($filename!='.' && $filename!='..'){//一定要排除两个特殊的目录
                    $subFile=$directory."/".$filename;//将目录下的文件与当前目录相连
                    if(is_dir($subFile)){//如果是目录条件则成了
                        deletedir($subFile);//递归调用自己删除子目录
                    }
                    if(is_file($subFile)){//如果是文件条件则成立
                        unlink($subFile);//直接删除这个文件
                    }
                }
            }
            closedir($dir_handle);//关闭目录资源
            rmdir($directory);//删除空目录
        }
    }
}
/**
 * PHP iconv 解决utf-8和gb2312编码转换问题
 * @param  [type] $string [description]
 * @return [type]         [description]
 */
function utf_gb($string)
{
	return iconv("UTF-8", "GB2312//IGNORE", $string);
}

function mkFolder($path)
{
   if (!is_readable($path))
   {
    is_file($path) or mkdir($path, 0700,true);
}
}
function createImage($image)
{
    $path = '/img/';
    $name = sha1(Carbon::now()) . '.' . $image->guessExtension();

    $_url = getcwd();

    $image->move($_url . $path, $name);
    return [
    "path" => $path . $name,
    "name" => $name,
    ];

}
 /*
*  PHP缩略图生成
*  等比压缩
*  支持格式Gif/Jpeg/Png
*/
function makeThumbnail($srcImgPath, $targetImgPath, $targetW = 10, $targetH = 10, $bDengbi = true)
{
    $imgSize = GetImageSize($srcImgPath);
    $imgType = $imgSize[2];
        //使函数不向页面输出错误信息
    switch ($imgType) {
        case 1:
        $srcImg = @ImageCreateFromGIF($srcImgPath);
        break;
        case 2:
        $srcImg = @ImageCreateFromJpeg($srcImgPath);
        break;
        case 3:
        $srcImg = @ImageCreateFromPNG($srcImgPath);
        break;
    }
        //取源图象的宽高
    $srcW = ImageSX($srcImg);
    $srcH = ImageSY($srcImg);
    if ($srcW > $targetW || $srcH > $targetH) {
            if ($bDengbi) {//等比压缩
                if ($targetW > 10) {//定宽
                    $targetH = $srcH * $targetW / $srcW;
                } else if ($targetH > 10) {//定高
                    $targetW = $srcW * $targetH / $srcH;
                } else {
                    return false;
                }
                if ($targetH < 11 || $targetW < 11) return false;
            }//end
            $targetX = 0;
            $targetY = 0;
            if ($srcW > $srcH) {
                $finaW = $targetW;
                $finalH = round($srcH * $finaW / $srcW);
                $targetY = floor(($targetH - $finalH) / 2);
            } else {
                $finalH = $targetH;
                $finaW = round($srcW * $finalH / $srcH);
                $targetX = floor(($targetW - $finaW) / 2);
            }
            //function_exists 检查函数是否已定义
            //ImageCreateTrueColor 本函数需要GD2.0.1或更高版本
            if (function_exists("ImageCreateTrueColor")) {
                $targetImg = ImageCreateTrueColor($targetW, $targetH);
            } else {
                $targetImg = ImageCreate($targetW, $targetH);
            }
            $targetX = ($targetX < 0) ? 0 : $targetX;
            $targetY = ($targetX < 0) ? 0 : $targetY;
            $targetX = ($targetX > ($targetW / 2)) ? floor($targetW / 2) : $targetX;
            $targetY = ($targetY > ($targetH / 2)) ? floor($targetH / 2) : $targetY;
            //背景颜色默认白色
            $white = ImageColorAllocate($targetImg, 255, 255, 255);
            ImageFilledRectangle($targetImg, 0, 0, $targetW, $targetH, $white);
            /*
                PHP的GD扩展提供了两个函数来缩放图象：
                ImageCopyResized 在所有GD版本中有效，其缩放图象的算法比较粗糙，可能会导致图象边缘的锯齿。
                ImageCopyResampled 需要GD2.0.1或更高版本，其像素插值算法得到的图象边缘比较平滑，
                                     该函数的速度比ImageCopyResized慢。
            */
                                     if (function_exists("ImageCopyResampled")) {
                                        ImageCopyResampled($targetImg, $srcImg, $targetX, $targetY, 0, 0, $finaW, $finalH, $srcW, $srcH);
                                    } else {
                                        ImageCopyResized($targetImg, $srcImg, $targetX, $targetY, 0, 0, $finaW, $finalH, $srcW, $srcH);
                                    }
                                    switch ($imgType) {
                                        case 1:
                                        ImageGIF($targetImg, $targetImgPath);
                                        break;
                                        case 2:
                                        ImageJpeg($targetImg, $targetImgPath);
                                        break;
                                        case 3:
                                        ImagePNG($targetImg, $targetImgPath);
                                        break;
                                    }
                                    ImageDestroy($srcImg);
                                    ImageDestroy($targetImg);
        } else //不超出指定宽高则直接复制
        {
            copy($srcImgPath, $targetImgPath);
            ImageDestroy($srcImg);
        }
    }

    function get_filesize($path)
    {
        @$ret = abs(sprintf("%u", filesize($path)));
        return (int)$ret;
    }
//分块上传
    function  upload_chunk($file_info, $path = './', $temp_path)
    {
        $file = $file_info;
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;
        if (!isset($file)) return [
            "message" => 'upload_error_null',
        "path" => ''

        ];

        $file_name = $file["name"];
        if ($chunks > 1) {//并发上传，不一定有前后顺序
            $temp_file_pre = $temp_path . md5($temp_path . $file_name) . '.part';
            if (get_filesize($file['tmp_name']) == 0) {
                return [
                "message" => 'upload_success' . 'chunk_' . $chunk . ' error!',
                "path" => ''

                ];
            }
            if (move_uploaded_file($file['tmp_name'], $temp_file_pre . $chunk)) {
                $done = true;
                for ($index = 0; $index < $chunks; $index++) {
                    if (!file_exists($temp_file_pre . $index)) {
                        $done = false;
                        break;
                    }
                }
                if (!$done) {
                    return [
                    "message" => 'upload_success' . 'chunk_' . $chunk . ' success!',
                    "path" => ''

                    ];
                }
                $save_path = $path . $file_name;
                $out = fopen(iconv("UTF-8", "GB2312//IGNORE", $save_path), "wb");
                if ($done && flock($out, LOCK_EX)) {
                    for ($index = 0; $index < $chunks; $index++) {
                        if (!$in = fopen($temp_file_pre . $index, "rb")) break;
                        while ($buff = fread($in, 4096)) {
                            fwrite($out, $buff);
                        }
                        fclose($in);
                        unlink($temp_file_pre . $index);
                    }
                    flock($out, LOCK_UN);
                    fclose($out);
                }

                return [
                "message" => 'upload success',
                "path" => substr($save_path, strlen(base_path() . DIRECTORY_SEPARATOR))

                ];
            } else {
                return [
                "message" => 'move error',
                "path" => ''

                ];
            }
        }
        //正常上传
        $save_path = $path . $file_name;
        if (move_uploaded_file( $file['tmp_name'], iconv("UTF-8", "GB2312//IGNORE", $save_path))) {

            return [
            "message" => 'upload success',
            "path" => substr($save_path, strlen(base_path() . DIRECTORY_SEPARATOR))

            ];
        } else {
            return [
            "message" => 'move error',
            "path" => ''

            ];
        }

    }


    function downloadFile($file_path)
    {
        // return basename($file_path);
        $fp = fopen($file_path, "rb");
        $file_size = get_filesize($file_path);
        //下载文件需要用到的头
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length:" . $file_size);
        // Header("Content-Disposition: attachment; filename=" . basename($file_path));
        Header("Content-Disposition: attachment; filename=" . preg_replace('/^.+[\\\\\\/]/', '', $file_path));
        $buffer = 1024;
        $file_count = 0;
        //向浏览器返回数据
        while (!feof($fp) && $file_count < $file_size) {
            $file_con = fread($fp, $buffer);
            $file_count += $buffer;
            echo $file_con;
        }
        fclose($fp);
        exit;
    }
