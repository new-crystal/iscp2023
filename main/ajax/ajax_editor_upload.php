<?php
	include_once($_SERVER["DOCUMENT_ROOT"]."/main/common/common.php");
	$file_obj = $_FILES['editor_upload'];	
	$result = array();
	$result['url'] = upload_image($file_obj, 4);
	$result['width'] = 500;
	$result['height'] = 500;

	/*
	$file_obj = $_FILES['editor_upload'];
	$upload_path = '../img/upload/editor/';

	$file_name = $file_obj['tmp_name'];
	$source_properties = getimagesize($file_name);
	$resize_file_name = time().mt_rand(100, 999);
	$file_ext = pathinfo($file_obj['name'], PATHINFO_EXTENSION);

	$upload_image_type = $source_properties[2];
	$source_image_width = $source_properties[0];
	$source_image_height = $source_properties[1];

	$path = $upload_path.$resize_file_name.".".$file_ext;
	
	switch ($upload_image_type) {
		case IMAGETYPE_JPEG:
			$resource_type = imagecreatefromjpeg($file_name); 
			$image_layer = resize_image($resource_type, $source_image_width, $source_image_height, "", "");
			imagejpeg($image_layer,$path);
			break;

		case IMAGETYPE_GIF:
			$resource_type = imagecreatefromgif($file_name); 
			$image_layer = resize_image($resource_type, $source_image_width, $source_image_height, "", "");
			imagegif($image_layer,$path);
			break;

		case IMAGETYPE_PNG:
			$resource_type = imagecreatefrompng($file_name);
			$image_layer = resize_image($resource_type, $source_image_width, $source_image_height, "", "");
			imagepng($image_layer,$path);
			break;

		default:
			break;
	}

	move_uploaded_file($file, $path);

	$result['width'] = $source_image_width;
	$result['height'] = $source_image_height;
	$result['url'] = "//".$_SERVER['HTTP_HOST']."/".str_replace('../', '', $path);
	*/
	
	echo json_encode($result);
?>