<?php
if (!empty($_GET['img'])){
	SetImgSize($_GET['img'], 100, 100, true);
}


$func = new \Inc\Classes\MyFunctions();

echo $func->buildLinkImg($_GET['img']);
function SetImgSize($img, $width, $height, $AspectRatio)
{

//Создаем изображение в зависимости от типа исходного файла
// для упрощения, считаю, что расширение соответствует типу файла
	$srcImage = '';
	switch ( strtolower(strrchr($img, '.')) ){
		case ".jpg":
			$srcImage = @imagecreatefromjpeg($img);
			break;
		case ".gif":
			$srcImage = @imagecreatefromgif($img);
			break;
		case ".png":
			$srcImage = @imagecreatefrompng($img);
			break;
	}
	$pURL_name = 'http://test2';
	$srcWidth = ImageSX($srcImage);
	$srcHeight = ImageSY($srcImage);
	var_dump($img);
	echo 'Исходная картинка('.$srcWidth.'x'.$srcHeight.'): <b>'.$pURL_name.'</b><br><img src="'.$img.'" />';die();
	if(($width < $srcWidth) || ($height > $srcHeight))
	{   if($AspectRatio){
		$ratioWidth = $srcWidth/$width;
		$ratioHeight = $srcHeight/$height;
		if($ratioWidth < $ratioHeight)
		{
			$destWidth = intval($srcWidth/$ratioHeight);
			$destHeight = $height;
		}
		else
		{
			$destWidth = $width;
			$destHeight = intval($srcHeight/$ratioWidth);
		}
	}else {
		$destHeight = $height;
		$destWidth = $width;}
		$resImage = ImageCreateTrueColor($destWidth, $destHeight);
		ImageCopyResampled($resImage, $srcImage, 0, 0, 0, 0, $destWidth, $destHeight, $srcWidth, $srcHeight);
		unlink($img);// удаляю исходный файл
		switch ( strtolower(strrchr($img, '.')) ){
			case "jpg":
				ImageJPEG($resImage, $img, 100); // 100 - максимальное качество
				break;
			case "gif":
				ImageGIF($resImage, $img);
				break;
			case "png":
				ImagePNG($resImage, $img);
				break;
		}
		ImageDestroy($srcImage);
		ImageDestroy($resImage);
		echo "<br>\nИзмененная картинка(".$destWidth.'x'.$destHeight.'):<br><img src="'.$img.'" />';
	}
}

