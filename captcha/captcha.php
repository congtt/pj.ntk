<?php

class Captcha {
 
   var $font = 'monofont.ttf';
 
   function generateCode($characters) {

      /* list all possible characters, similar looking characters and vowels have been removed */
      $possible = '23456789bcdfghjkmnpqrstvwxyz';
      $code = '';
      $i = 0;
      while ($i < $characters) { 
         $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
         $i++;
      }
      return $code;
   }
 

function encrypt_decrypt($Str_Message) {
 
    $Len_Str_Message=STRLEN($Str_Message); 
    $Str_Encrypted_Message=""; 
    for ($Position = 0;$Position<$Len_Str_Message;$Position++){ 
        $Key_To_Use = (($Len_Str_Message+$Position)+1); // (+5 or *3 or ^2) 
        $Key_To_Use = (255+$Key_To_Use) % 255; 		
        $Byte_To_Be_Encrypted = SUBSTR($Str_Message, $Position, 1); 
        $Ascii_Num_Byte_To_Encrypt = ORD($Byte_To_Be_Encrypted); 
        $Xored_Byte = $Ascii_Num_Byte_To_Encrypt ^ $Key_To_Use;  //xor operation 
        $Encrypted_Byte = CHR($Xored_Byte); 
        $Str_Encrypted_Message .= $Encrypted_Byte; 
        
    } 
    return $Str_Encrypted_Message; 
} //end function 


   function Captcha_default($width='135',$height='50',$characters='6',$code) {


	  if ($code==''){$code = $this->generateCode($characters);}
      /* font size will be 75% of the image height */
      $font_size = $height * 0.65;
      $image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');
      /* set the colours */
      $background_color = imagecolorallocate($image, 255, 255, 255);
      $text_color = imagecolorallocate($image, 0, 0, 0);
      $noise_color = imagecolorallocate($image, 220, 220, 220);
      /* generate random dots in background */
      for( $i=0; $i<($width*$height)/3; $i++ ) {
         imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
      }
      /* generate random lines in background */
      for( $i=0; $i<($width*$height)/150; $i++ ) {
         imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
      }
      /* create textbox and add text */
      $textbox = imagettfbbox($font_size, 0, $this->font, $code) or die('Error in imagettfbbox function');
      $x = ($width - $textbox[4])/2;
      $y = ($height - $textbox[5])/2;
      imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font , $code) or die('Error in imagettftext function');
      /* output captcha image to browser */
      header('Content-Type: image/jpeg');
      imagejpeg($image);
      imagedestroy($image);
   }


   function Captcha($width='135',$height='50',$characters='6',$code) {


	  if ($code==''){$code = $this->generateCode($characters);}
	  $code=$this->encrypt_decrypt($code);

	  for ($j=0;$j<strlen($code);$j++){
		$code1.=substr($code,$j,1);
		if ($j<strlen($code)-1){$code1.=" ";}
	  }
	  $code=$code1;

      /* font size will be 75% of the image height */
      $font_size = $height * 0.52;
      $image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');
	  //$image =imagecreatefromjpeg("captcha.jpg");//image create by existing image and as back ground 
      /* set the colours */
      $background_color = imagecolorallocate($image, 250, 250, 250);
      $text_color = imagecolorallocate($image, 10, 10, 0);
      $noise_color = imagecolorallocate($image,20, 130, 187);
      /* create textbox and add text */
      $textbox = imagettfbbox($font_size, 0, $this->font, $code) or die('Error in imagettfbbox function');
      $x = ($width - $textbox[4])/2;
      $y = ($height - $textbox[5])/2;
	 

	 for ($i=1;$i<5;$i++){
	  imageline($image, $width, $i*10, 0,$i*10, $noise_color);}


	 for ($i=1;$i<15;$i++){
	  imageline($image, $i*9, $height, $i*9,0, $noise_color);}

      imagettftext($image, $font_size, 0, $x+2, $y+2, $noise_color, $this->font , $code) or die('Error in imagettftext function');
	  imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font , $code) or die('Error in imagettftext function');
      /* output captcha image to browser */
      header('Content-Type: image/jpeg');
      imagejpeg($image);
      imagedestroy($image);
   }
 
}
 
$tmp="abcde";


$width = isset($_GET['w']) ? $_GET['w'] : '135';
$height = isset($_GET['h']) ? $_GET['h'] : '50';
$characters = isset($_GET['characters']) && $_GET['characters'] > 1 ? $_GET['characters'] : '5';
$code = $_GET['code']!='' ? $_GET['code'] : 'abcde';
//$RandomStr = md5(microtime());// md5 to generate the random string
//$code = substr($RandomStr,0,$characters);//trim 5 digit 
$captcha = new Captcha($width,$height,$characters,$code); 
?>