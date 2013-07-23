<?php
	/** file: func.inc.php 函数库文件 */

	include "fileupload.class.php";                            //导入文件上传类FileUpload所在文件
	include "image.class.php";                                 //导入图片处理类Image所在的文件
	
	/* 声明一个函数upload()处理图片上传 */
	function upload(){
		$path = "./uploads/";                                     //设置图片上传路径
		
		$up = new FileUpload($path);                           //创建文件上传类对象
		
		if($up->upload('pic')) {                               //上传图片
			$filename = $up->getFileName();                    //获取上传后的图片名
			
			$img = new Image($path);                           //创建图像处理类对象
			
			$img -> thumb($filename, 300, 300, "");            //将上传的图片都缩放至在300X300以内
			$img -> thumb($filename, 80, 80, "icon_");         //缩放一个80x80的图标，使用icon_作前缀
			$img -> watermark($filename, "logo.gif", 5, "");   //为上传的图片加上图片水印
			
			return array(true, $filename);                     //如果成功返回成功状态和图片名称
		} else {
			return array(false, $up->getErrorMsg());           //如果失败返回失败状态和错误消息
		}
	}
	/* 删除上传的图片 */
	function delpic($picname){
		$path = "./uploads/"; 

		@unlink($path.$picname);                                //删除原图
		@unlink($path.'icon_'.$picname);                        //删除图标
	}
	
	