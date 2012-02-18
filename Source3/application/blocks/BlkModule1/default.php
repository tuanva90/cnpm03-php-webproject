<div class="ui-widget-content ui-conner-all module" id="<?php echo $info['module_id'];?>">
<script type="text/javascript">
	function module1update() {
		var option_str = "";			
		var isShowed = $("input[name=chkModule1IsShowed]").is(":checked");				
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
				}
			},
			error: function(request, error) {
				showMessage("Error! <br> Detail: <br>" + request.responseText);
			}	
		});	
	}
	$(function() {
		/////////////ThaoNX///////
    	$("#edit-module1-form").dialog({
			autoOpen: false,
			height: 300,
			width: 350,
			modal: true,
			buttons: {
				"Save": function() {
					showMessage("Saving...");
					module1update();
					$(this).dialog("close");
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
    	$("#edit-module1").button().click(function() {
			$("#edit-module1-form").dialog("open");
		});	
			
		});
	</script>
	<div class="ui-widget-header ui-corner-all module-title">
		<h3><?php echo $info['name'];?></h3>
		<div class="edit-button">
			<button id='edit-module1' class="state-changable-button">...</button>
		</div>
	</div>
	<p>Content of <?php echo $info['name'];?> goes here.</p>
	<!-- ////////////////////// -->
    <div id="edit-module1-form" title="Edit Contact Module">
		<form>
			<input type="checkbox" name="chkModule1IsShowed" id=chkIsShowed checked="checked"/>Use this module.<br>			
		</form>
	</div>
</div>