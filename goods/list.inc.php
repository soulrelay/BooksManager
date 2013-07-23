<?php
		/** file: list.inc.php 图书列表显示脚本，包括搜索加分页的功能 */
		
		/* 判断用户是通过表单POST提交，还是使用URL的GET提交,都将内容交给$ser处理 */
		$ser = !empty($_POST) ? $_POST : $_GET;                    
		
        $where = array();            								 //声明WHERE从句的查询条件变量
        $param = "";               									 //声明分页参数的组合变量
		$title = "";                 								 //声明本页的标题变量

		/* 处理用户搜索图书名称 */
        if(!empty($ser["bookname"])) {                               
            $where[] = "bookname like '%{$ser["bookname"]}%'";
			$param .= "&bookname={$ser["bookname"]}";
			$title .= ' 图书名称中包含"'.$ser["bookname"].'"的 ';
        }
		/* 处理用户搜索出版社名称 */
        if(!empty($ser["publisher"])) {
            $where[] = "publisher like '%{$ser["publisher"]}%'";
			$param .= "&publisher={$ser["publisher"]}";
			$title .= ' 出版社名称中包含"'.$ser["publisher"].'"的 ';
        }
		/* 处理用户搜索图书作者 */	
        if(!empty($ser["author"])) {
            $where[] = "author like '%{$ser["author"]}%'";
			$param .= "&aruthor={$ser["author"]}";
			$title .= ' 图书作者名子中包含"'.$ser["author"].'"的 ';
        }
		/* 处理用户搜索图书起始范围价格 */
		if(!empty($ser["startprice"])) {
            $where[] = "price > '{$ser["startprice"]}'";
			$param .= "&startprice={$ser["startprice"]}";
			$title .= ' 图书价格大于"'.$ser["startprice"].'"的 ';
        }
		/* 处理用户搜索图书结束范围价格 */
		if(!empty($ser["endprice"])) {
            $where[] = "price < '{$ser["endprice"]}'";
			$param .= "&endprice={$ser["endprice"]}";
			$title .= ' 图书价格小于"'.$ser["startprice"].'"的 ';
        }
		
		/* 处理是否有搜索的情况 */
        if(!empty($where)){
            $where = "WHERE ".implode(" and ", $where);
			$title = "搜索：".$title;
        }else {
			$where = "";
			$title = "图书列表:";
		}
		echo '<h3>'.$title.'</h3>';
?>

<table>
	<tr align="left" bgcolor="#cccccc">
		<th>ID</th><th>图书名称</th> <th>出版商</th> <th>图书作者</th> <th>图书价格</th> <th>上架时间</th> <th>操作</th>
	</tr>
	<?php
		include "conn.inc.php";                              	//包含数据库连接文件，连接数据库
		include "page.class.php";                               //包含分页类文件，加数据分页功能
		
		$sql = "SELECT count(*) FROM books {$where}";           //按条件获取数据表记录总数  
		$result = mysql_query($sql);
		list($total) = mysql_fetch_row($result);
		
		$page = new Page($total, 10, $param);                   //创建分页类对象
		/* 编写查询语句，使用$where组合查询条件， 使用$page->limit获取LIMIT从句,限制数据条数 */
		$sql = "SELECT id, bookname, publisher, author, price, pic,ptime FROM books {$where} ORDER BY id DESC {$page->limit}";
		/* 执行查询的SQL语句 */
		$result = mysql_query($sql);
		/*处理结果集，打印数据记录 */
		if($result && mysql_num_rows($result) > 0 ) {
			$i = 0;
			/* 循环数据，将数据表每行数据对应的列转为变量 */
			while(list($id, $bookname, $publisher, $author, $price, $pic, $ptime) = mysql_fetch_row($result)) {
				if($i++%2==0)
					echo '<tr bgcolor="#eeeeee">';
				else 
					echo '<tr>';
				echo '<td>'.$id.'</td>';
				echo '<td>'.$bookname.'</td>';
				echo '<td>'.$publisher.'</td>';
				echo '<td>'.$author.'</td>';
				echo '<td>￥'.number_format($price, 2, '.', ' ').'</td>';
				echo '<td>'.date("Y-m-d",$ptime).'</td>';
				echo '<td><a href="index.php?action=mod&id='.$id.'">修改</a>/<a onclick="return confirm(\'你确定要删除图书'.$bookname.'吗?\')" href="index.php?action=del&id='.$id.'&pic='.$pic.'">删除</a></td>';
				echo '</tr>';
			}
			echo '<tr><td colspan="6">'.$page->fpage().'</td></tr>';
		}else {
			echo '<tr><td colspan="6" align="center">没有图书被找到</td></tr>';
		}
		
		mysql_free_result($result);                            //释放结果集
		mysql_close($link);                                    //关闭数据库连接
	?>
<table>
