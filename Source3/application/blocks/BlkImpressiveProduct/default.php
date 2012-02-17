
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
	///
	function impressive_product_refesh(){		
		$("#impressive-product-content").html("<center><h3>Loading...</h3></center>");
		var max = $("#edit-impressive-product-form input[name='txtMaxAmount']").val();
		$.ajax({
			type: 'POST',
			url: '<?php echo HTTP_SERVER."front/index/impressiveproducts"?>',
			data: {				
				num_rows: max
			},
			success: function(data) {
				//alert(data);
				$("#impressive-product-content").html(data);
			},
			error: function(request, textStatus, error) {
				showMessage("Error! <br> Detail: <br>" + request.responseText + error);
			}	
		});
	}
	//////////////////
	$(function(){			
		$("#edit-impressive-product").button().click(function(){
			$("#edit-impressive-product-form").dialog("open");
		});
		
		function update() {
			var max = $("#edit-impressive-product-form input[name='txtMaxAmount']").val();	
			var isShowed = $("#edit-impressive-product-form :checkbox['chkIsShowed']").is(":checked");			
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
						impressive_product_refesh();
					}
						
				},
				error: function(request, error) {
					alert(data);
					showMessage("Error! <br> Detail: <br>" + request.responseText);
				}	
			});				
			
		}
		$("#edit-impressive-product-form").dialog({
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

		impressive_product_refesh();
	});
	</script>
	<div class="ui-widget-header ui-corner-all module-title">
		<h3><?php echo $info['name']?>t</h3>
		<div class="edit-button">
			<button id='edit-impressive-product' class="state-changable-button">...</button>
		</div>
	</div>
	<!-- ///////////////////////////////////////////////////// -->
	<div id="impressive-product-content" style="overflow-x:auto;min-height: 10px; ">	
		

	</div><!-- #end #content -->
	<!-- ///////////////////////////////////////////////////// -->
	
	<div id="edit-impressive-product-form" title="Edit Most View Module">
		<form >
			<input type="checkbox" name="chkIsShowed" id="impressive-productIsShowed" checked="checked"/>Use this module.<br>
			Amount of items to show: <input type="text" maxlength="2" size="5" value="<?php echo $amount_items;?>" name="txtMaxAmount" id="txtMaxAmount"/>
		</form>
	</div>
</div>