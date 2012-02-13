<div class="ui-widget-content ui-conner-all module" id="<?php echo $info['module_id'];?>">
	<script type="text/javascript">
	$(function() {
		$("#btnSubmitSearch").button().click(function() {
			$("#HelloWorld-Dialog").dialog("open");
			 $.ajax({
				type: 'POST',
				url: '<?php echo HTTP_SERVER."front/menu/index"?>',
				success: function(data) {
					$("#HelloWorld-Dialog").html(data);
				},
				error: function(request, textStatus, error) {
					showMessage("Error! <br> Detail: <br>" + request.responseText + error);
				}	
			});
		});

		$("#HelloWorld-Dialog").dialog({
			autoOpen: false,
			width: 500,
			heigh: 300,
			modal: true,
			buttons: {
				"OK": function() {
					$("#HelloWorld-Dialog").dialog("close");
				}
			}
		});

		$("#edit-helloworld").button().click(function() {
			
		});
	});
	</script>
	<div class="ui-widget-header ui-corner-all module-title">
		<h3>Hello Word</h3>
		<div class="edit-button">
			<button id='edit-helloworld' class="state-changable-button">...</button>
		</div>
	</div>
	Hello World
	<div id="btnSubmitSearch">Search</div>
	
	<div id="search-result">
	</div>
	
	<div id="HelloWorld-Dialog" Title="Dialog"></div>
</div>