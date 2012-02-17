<div class="ui-widget-content ui-conner-all module" id="<?php echo $info['module_id'];?>">
	<script type="text/javascript">
	function update() {
		var option_str = "";			
		var isShowed = $("input[name=chkContactIsShowed]").is(":checked");			
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
    	$("#edit-search-form").dialog({
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
    	$("#edit-search-button").button().click(function() {
			$("#edit-search-form").dialog("open");
		});
		
		//////////////////////////////////
		$("#btnSubmitSearch").button().click(function() {
			$("#SearchResult-Dialog").dialog("open");
			$.ajax({
				type: 'POST',
				url: '<?php echo HTTP_SERVER."front/index/search"?>',
				data: {
					tukhoa: $("input[name=txtTuKhoa]").val()
				},
				success: function(data) {
					$("#SearchResult-Dialog").html(data);
				},
				error: function(request, textStatus, error) {
					showMessage("Error! <br> Detail: <br>" + request.responseText + error);
				}	
			});
		});
		
		$("#edit-Search").button();
		
		$("#SearchResult-Dialog").dialog({
			autoOpen: false,
			width: 800,
			heigh: 400,
			modal: true,
			buttons: {
				"OK": function() {
					$("#SearchResult-Dialog").dialog("close");
				}
			}
		});
		
	});
	</script>
	<div class="ui-widget-header ui-corner-all module-title">
		<h3>Search</h3>
		<div class="edit-button">
			<button id='edit-search-button' class="state-changable-button">...</button>
		</div>
	</div>
	Tu Khoa:<br> 
	<input type="text" name="txtTuKhoa" id="txtTuKhoa" maxlength="50" size="25"/><br>
	<div id ="txtTuKhoa"></div>
	<div id="btnSubmitSearch">Search</div>
	<div id="SearchResult-Dialog" Title="Dialog"></div>
	<!-- ////////////////////// -->
    <div id="edit-search-form" title="Edit Contact Module">
		<form>
			<input type="checkbox" name="chkSearchIsShowed" id=chkIsShowed checked="checked"/>Use this module.<br>
			
		</form>
	</div>
</div>