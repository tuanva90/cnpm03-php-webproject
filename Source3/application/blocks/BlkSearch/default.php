<div class="ui-widget-content ui-conner-all module" id="<?php echo $info['module_id'];?>">
	<script type="text/javascript">
	$(function() {
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
			<button id='edit-Search' class="state-changable-button">...</button>
		</div>
	</div>
	Tu Khoa:<br> 
	<input type="text" name="txtTuKhoa" id="txtTuKhoa" maxlength="50" size="25"/><br>
	<div id ="txtTuKhoa"></div>
	<div id="btnSubmitSearch">Search</div>
	<div id="SearchResult-Dialog" Title="Dialog"></div>
</div>