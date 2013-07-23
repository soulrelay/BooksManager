<?php /** file: add.inc.php  图书添加表单 */ ?>
<h3>添加图书:</h3>
<form enctype="multipart/form-data" action="index.php?action=insert" method="POST">
	图书名称：<input type="text" name="bookname" value="" /><br>
	出版商名：<input type="text" name="publisher" value="" /><br>
	图书作者：<input type="text" name="author" value="" /><br>
	图书价格：<input type="text" name="price" value="" /><br>
	<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
	图书图片：<input type="file" name="pic" value="" /><br>
	图书介绍：<textarea name="detail" cols="30" rows="5"></textarea><br>
    <input type="submit" name="add" value="添加图书" />
</form>