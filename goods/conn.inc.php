<?php
    /** file: conn.inc.php 数据库连接文件 */
	/*连接本地的数据库*/
	$link = mysql_connect("localhost", "root", "123456");
				
	if (!$link) {
		die('连接数据库失败: '.mysql_error());
	}
	/* 选择bookstore作为默认的数据库 */
	if(!mysql_select_db("bookstore")) {
		die('数据库选择失败: '.mysql_error());
	}