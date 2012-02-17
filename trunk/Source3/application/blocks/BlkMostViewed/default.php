
<div class="ui-widget-content ui-conner-all module" id="<?php echo $info['module_id'];?>">
<style>
	#content a:hover{
		color:#1C94C4;
	}
	#content a{
		text-decoration: none;
	}
</style>
	<script type="text/javascript">
		$(function(){
			$("#edit-mostviewed-news").button().click(function(){
				$("#edit-mostviewed-news-form").dialog("open");
			});
			function update() {
				var max = $("#edit-mostviewed-news-form input[name=txtMaxAmount]").val();
				var isShowed = $("#edit-mostviewed-news-form :checkbox['chkIsShowed']").is(":checked");
				var option_str = "";				
				var max_number = 0;				
				if(isNaN(max)){
					max_number = 5;
				}else{
					max_number = parseInt(max);
				}
				option_str += "$amount_items=" + max_number + ";";						
				$.ajax({
					type: 'POST',
					url: '<?php echo HTTP_SERVER."front/index/saveblock"?>',
					dataType: 'json',
					data: {
						module_id: <?php echo $info['module_id'];?>,
						name: "<?php echo $info['name'];?>",
						file_name: "<?php echo $info['file_name'];?>",
						is_showed: isShowed?1:0,
						position: <?php echo $info['position'];?>,
						sort_order: <?php echo $info['sort_order'];?>,
						option: option_str
					},
					success: function(data) {						
						closeMessage();	
						if(!isShowed){
							$("#<?php echo $info['module_id']?>").remove();
						}else{
							window.location.reload() 
						}
					},
					error: function(request, error) {						
						showMessage("Error! <br> Detail: <br>" + request.responseText);
					}	
				});				
				
			}
			$("#edit-mostviewed-news-form").dialog({
				autoOpen: false,
				height: 300,
				width: 350,
				modal: true,
				buttons: {
					"Save": function() {										
						showMessage("Saving...");
						update();
						$(this).dialog("close");
					},
					Cancel: function() {
						$( this ).dialog( "close" );
					}
				}
			});
		});
	</script>
	<div class="ui-widget-header ui-corner-all module-title">
		<h3><?php echo $info['name']?></h3>
		<div class="edit-button">
			<button id='edit-mostviewed-news' class="state-changable-button">...</button>
		</div>
	</div>
	<!-- ///////////////////////////////////////////////////// -->
	<div id="content" style="overflow-x:auto;min-height: 10px; ">
	
		<table class="list" style="margin-bottom: 0px;">
			<thead>
				<tr>					

					<td class="center" style="min-width: 100px">News</td>
					<td class="center">Viewed</td>					
				</tr>
			</thead>
			<tbody>
				<?php if ($items) { ?>			
				<?php foreach($items as $val){										
					?>
					<tr>						
						<td><a href="<?php echo HTTP_SERVER.'/front/news/detail/news_id/'.$val['news_id']?>"><?php echo $val["title"]?></a></td>
		            	<td class="center"><?php echo $val['viewed'];?></td>		            	
            		</tr>
	          	<?php } ?>	          
          		<?php } else { ?>
			        <tr>
			            <td class="center" colspan="2">Không có kết quả</td>
			        </tr>
          		<?php } ?>
			</tbody>
		</table>
		
	</div><!-- #end #content -->
	<!-- ///////////////////////////////////////////////////// -->
	
	<div id="edit-mostviewed-news-form" title="Edit Most View Module">
		<form >
			<input type="checkbox" name="chkIsShowed" id="mostviewedIsShowed" checked="checked"/>Use this module.<br>
			Amount of items to show: <input type="text" maxlength="2" size="5" value="<?php echo $amount_items;?>" name="txtMaxAmount" id="txtMaxAmount"/>
		</form>
	</div>
</div>