<?php 
	/** file: mod.inc.php 图书修改表单 */ 
	include "conn.inc.php";
	/* 通过ID查找指定的一行记录 */
	$sql = "SELECT id, bookname, publisher, author, price, pic, detail FROM books WHERE id='{$_GET["id"]}'";
	$result = mysql_query($sql);
	
	if($result && mysql_num_rows($result) > 0) {
		/* 获取需要修改的记录数据 */
		list($id, $bookname, $publisher, $author, $price, $pic, $detail) = mysql_fetch_row($result);
	}else {
		die("没有找到需要修改的图书");
	}
	
	mysql_free_result($result);           //释放结果集
	mysql_close($link);                   //关闭数据库的连接
?>
<h3>修改商品:</h3>
<form enctype="multipart/form-data" action="index.php?action=update" method="POST">
	<input type="hidden" name="id" value="<?php echo $id ?>" />
	图书名称：<input type="text" name="bookname" value="<?php echo $bookname ?>" /><br>
	出版商名：<input type="text" name="publisher" value="<?php echo $publisher ?>" /><br>
	图书作者：<input type="text" name="author" value="<?php echo $author ?>" /><br>
	图书价格：<input type="text" name="price" value="<?php echo $price ?>" /><br>
	<input type="hidden" name="MAX_FILE_SIZE" value="1000000" /><br>
	<img src="./uploads/icon_<?php echo $pic ?>"><br>
	<input type="hidden" name="picname" value="<?php echo $pic ?>" />
	图书图片：<input type="file" name="pic" value="" /><br>
	图书介绍：<textarea name="detail" cols="30" rows="5"><?php echo $detail ?></textarea><br>
    <input type="submit" name="add" value="修改图书" />
</form>