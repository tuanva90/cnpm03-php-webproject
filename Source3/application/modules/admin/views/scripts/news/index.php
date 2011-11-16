<script type="text/javascript">
function getSelectedCheckbox(alink){
	alert('1');
	var a = document.news_form.check_box.length;
	var a = 5;   
	var i = 0;   
	var checked_values = new Array();   
	alink = String(alink);
	alert(alink);
	for(i = 0; i < a; i++){	   
		if(document.news_form.check_box[i].checked == true){
			alert('2');
			checked_values.push(document.news_form.check_box[i].value);
			alert('3');
			alink = alink.concat("?check_box=",document.news_form.check_box[i].value);
			alert('4');
			}
		}	
	alert(alink);	
	//window.location = alink;
	}
	function function2(){	
		var txt1 = "Hello ";	
		var txt2 = "world!";	
		var txt3 = "fuck it!";	
		alert(txt1.concat(txt2,txt3));
	}
</script>
<div id="content">
<?php $newlink = $this->baseUrl("/admin/news/new");
	$editlink = $this->baseUrl("/admin/news/edit");
	$deletelink = $this->baseUrl("/admin/news/delete");
?>
	<div class="toolbox">
		<div class="left">Quản lý :: Tin tức - Sự kiện</div>
		<div class="right">
			<div><a href="<?php echo $newlink;?>"><img alt="" src="<?php echo HTTP_IMAGES . '/icon/icon-32-new.png';?>"/><br>New</a></div>
			<div><a href="<?php echo $$editlink;?>"><img alt="" src="<?php echo HTTP_IMAGES . '/icon/icon-32-inactive.png';?>"/><br>Edit</a></div>
			<div><a href="#" <?php echo " onclick=\"getSelectedCheckbox('$deletelink')\""?>><img alt="" src="<?php echo HTTP_IMAGES . '/icon/icon-32-active.png';?>"/><br>Delete</a></div>
			<div><a href="#"><img alt="" src="<?php echo HTTP_IMAGES . '/icon/icon-32-active.png';?>"/><br>Active</a></div>
			<div><a href="#"><img alt="" src="<?php echo HTTP_IMAGES . '/icon/icon-32-active.png';?>"/><br>Active</a></div>
			<div><a href="#" <?php echo " onclick=\"function2()\""?>><img alt="" src="<?php echo HTTP_IMAGES . '/icon/icon-32-active.png';?>"/><br>Delete</a></div>
		</div>
	</div>
	<div class="breadcrumb">
		<a href="#">...</a>
		<a href="#">...</a>
	</div>
	
<form id="news_form" name="news-form" method="post">
	<table border="1" cellpadding="1" cellspacing="0">
	<tr style="font-weight: bold;"> <td><input type="checkbox" name="checkboxCol"/></td> <td>ID</td> <td>TIÊU ĐỀ</td> <td>TÁC GIẢ</td> <td>HÌNH ẢNH</td> <td>LƯỢT XEM</td> <td>THỨ TỰ</td> <td>TRẠNG THÁI</td> <td>NGÀY TẠO</td> <td>NGÀY SỬA</td> <td>THAO TÁC</td></tr> 
	<?php 
	foreach($this->news as $news){
		$news_description = $this->model->getNews_description($news['news_id'],"vi_VN");
		echo "<tr><td><input type='checkbox' name='check_box' value='".$news['news_id']."' />";
		echo '</td> <td>'.$news['news_id'];
		echo '</td> <td>'.$news_description['title'];
		echo '</td> <td>'.$news['author'];
		echo "</td> <td>".$news["image"];
		echo '</td> <td>'.$news['viewed'];
		echo '</td> <td>'.$news['sort_order'];
		echo '</td> <td>'.$news['status'];
		echo '</td> <td>'.$news["date_added"];
		echo '</td> <td>'.$news["date_modified"];
		echo '</td><td><a href='.$this->baseUrl("/admin/news/edit")."?news_id=".$news['news_id'].'>SỬA</a>  &nbsp&nbsp  <a href='.$this->baseUrl("admin/news/delete")."?news_id=".$news['news_id'].'>XÓA</a> &nbsp&nbsp <a>Active</a></td></tr>';
	}
	?>
	</table>
</form>
	<pre>
		<?php 
		//$description = $this->model->getNews_Description(722,"vi_VN");
		//print_r($description);
		//echo count($description);
		//print_r($_POST['check']);
		?>
	</pre>
</div>


