<?php
/**
 * 產生驗證碼
 */
function create_captcha($str, $width = 300, $height = 150){
    $image = imagecreatetruecolor($width, $height);

    if (!$image) {
        die("Unable to create image.");
    }

    // 分配背景色
    $background_color = imagecolorallocate($image, 255, 255, 204); // 米黃色
    imagefill($image, 0, 0, $background_color);
    for ($i=0; $i <= 9; $i++) {
        // 繪製隨機的干擾線條
        imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), rand_color($image));
    }
    for ($i=0; $i <= 100; $i++) {
        // 繪製隨機的干擾點
        imagesetpixel($image, rand(0, $width), rand(0, $height), rand_color($image));
    }

    /**
     * 查詢 linux 系統字體
     */
    // exec("fc-list | grep -i dejavu")
    
    // 設置字體文件路徑
    // $font = 'fa-solid-900.ttf'; // 請確保這裡的路徑正確
    $font =  "/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf";

    if (!file_exists($font)) {
        die("Font file not found.");
    }

    // 繪製驗證碼中的字元
    for ($i = 0; $i < 5; $i++) {
        imagettftext($image, rand(40, 50), rand(-45, 45), $i * 50 + 10, rand(50, 100), rand_color($image), $font, $str[$i]);
    }

    // 設置內容類型頭為 PNG
    header("Content-Type: image/png");

    // 輸出圖像到瀏覽器
    imagepng($image);

    // 釋放圖像資源
    imagedestroy($image);

}
/**
 * 隨機字串生成函數
 */
function rand_str($length) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $str = '';
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    
    //儲存驗證碼
    $_SESSION['captcha'] = $str;

    return $str;
}

/**
 * 隨機顏色生成函數
 */
function rand_color($image) {
    return imagecolorallocate($image, mt_rand(0, 200), mt_rand(0, 200), mt_rand(0, 255));
}
?>
