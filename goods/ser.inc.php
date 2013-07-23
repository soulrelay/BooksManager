<?php /** file: ser.inc.php 图书搜索表单 */  ?>
<h3>图书搜索：</h3>
<form action="index.php?action=list" method="POST">
	图书名称：<input type="text" name="bookname" /><br>
	出版商名：<input type="text" name="publisher" /><br>
	图书作者：<input type="text" name="author" /><br>
	图书价格：<input type="text" name="startprice" size="5"  /> --
			   <input type="text" name="endprice" size="5" /><br>
    <input type="submit" name="add" value="搜索图书" /> <br>
</form>