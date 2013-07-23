<?php /** file: index.php 程序的主控制文件和主入口文件 */ ?>
<html>
	<head>
		<title>图书表管理</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<style>
			body {font-size:12px;}
			td {font-size:12px;}
		</style>
	<head>
	<body>
			<h1>图书表管理</h1>
			<p>
				<a href="index.php?action=add">添加图书</a> ||
				<a href="index.php?action=list">图书列表</a> ||
				<a href="index.php?action=ser">搜索图书</a> <hr>
			</p>
			<?php
				/* 包含自定义的函数库文件 */
				include "func.inc.php";
				/* 如果用户的操作是请求添加图书表单action=add，则条件成立 */
				if($_GET["action"] == "add") {
					/* 包含add.inc.php获取用户添加表单 */
					include "add.inc.php";
				/* 如果用户提交添加表单action=insert，则条件成立 */
				} else if ($_GET["action"] == "insert") {
					/*在这里可以加上数据验证*/
					
					/* 使用func.inc.php文件中声明的 upload()函数处理图片上传 */
					$up = upload();
					/* 如果返回值$up中的第一个元素是false说明上传失败，报告错误原因并退出程序 */
					if(!$up[0]) 
						die($up[1]);
					
					/* 添加数据需要先连接并选数据库，包含conn.inc.php文件连接数据库 */
					include "conn.inc.php";
					
					/* 根据用户通过POST提交的数据组合插入数据库的SQL语句 */
					$sql = "INSERT INTO books(bookname, publisher, author, price, ptime,pic,detail) VALUES('{$_POST["bookname"]}', '{$_POST["publisher"]}', '{$_POST["author"]}', '{$_POST["price"]}', '".time()."', '{$up[1]}', '{$_POST["detail"]}')";
					/* 执行INSERT语句 */
					$result = mysql_query($sql);
					/* 如果INSERT语句执行成功，并对数据表books有行数影响，则插入数据成功 */
					if($result && mysql_affected_rows() > 0 ) {
						echo "插入一条数据成功!";
					}else {
						echo "数据录入失败!";
					}
					/* 用完后关闭数据库的连接 */
					mysql_close($link);
				/* 如果用户请求一个修改表单action=mod, 则条件成立 */
				} else if($_GET["action"] == "mod") {
					/* 包含文件mod.inc.php获取一个修改表单 */
					include "mod.inc.php";
				} else if($_GET["action"] == "update") {
					/*在这里加上数据验证*/
					
					/* 如果用户需要修改图片，用新上传的图片替换原来的图片 */
					if($_FILES["pic"]["error"] == "0"){
						$up = upload();
						/* 如果有新上传的图片，就使用上传图片名修改数据库 */
						if($up[0])  
							$pic = $up[1];
						else 
							die($up[1]);
								
					} else {
						/* 如果没有上传图片，还是使用原来图片 */
						$pic = $_POST["picname"];
					}
					/* 修改数据需要先连接并选数据库，包含conn.inc.php文件连接数据库 */
					include "conn.inc.php";
					
					/* 根据修改表单提交的POST数据组合一个UPDATE语句 */
					$sql = "UPDATE books SET bookname='{$_POST["bookname"]}', publisher='{$_POST["publisher"]}', author='{$_POST["author"]}', price='{$_POST["price"]}',pic='{$pic}', detail='{$_POST["detail"]}' WHERE id='{$_POST["id"]}'";
		
					/* 执行UPDATE语句 */
					$result = mysql_query($sql);
					
					/* 如果语句执行成功，并对记录行有所影响，则表示修改成功 */
					if($result && mysql_affected_rows() > 0 ) {
						/* 修改新图片成功后，将原来的图片要删除掉，以免占用磁盘空间 */
						if($up[0]) 
							delpic($_POST["picname"]);
						echo "记录修改成功!";
					}else {
						echo "数据修改失败!";
					}
					mysql_close($link);
				/* 如果用户请求删除一本图书action=del, 则条件成立 */
				} else if($_GET["action"] == "del") {
									
					include "conn.inc.php";
					$result = mysql_query("DELETE FROM books WHERE id='{$_GET["id"]}'");
					if($result && mysql_affected_rows() > 0 ) {
						/*删除记录成功后，也要将图书的图片一起删除 */
						delpic($_GET["pic"]);
						/* 删除记录后跳转回到原来的URL */
						echo '<script>window.location="'.$_SERVER["HTTP_REFERER"].'"</script>';
					}else {
						echo "数据删除失败!";
					}
		
					mysql_close($link);
				/* 如果用户请求一个搜索表单action=ser, 则条件成立 */
				} else if($_GET["action"] == "ser"){
					include "ser.inc.php";
				/* 默认的请求都是图书列表 */
				} else {
					include "list.inc.php";
				}
			?>
	</body>
</html>