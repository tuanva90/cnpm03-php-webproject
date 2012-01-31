<div class="ui-widget-content ui-conner-all module" id="<?php echo $info['module_id'];?>">
	<script type="text/javascript">
		$(function(){
			var amount_items = <?php echo $amount_items;?>;
			$("#txtMaxAmount").val(amount_items);
		
			$("#edit-impressive-product-form").dialog({
				autoOpen: false,
				height: 300,
				width: 350,
				modal: true,
				buttons: {
					"Save": function() {
						amount_items = $("#txtMaxAmout").val();
						this.dialog("close");
					},
					Cancel: function() {
						$( this ).dialog( "close" );
					}
				}
			});
		
			$("#edit-impressive-product").button().click(function(){
				$("#txtMaxAmount").val(amount_items);
				$("#edit-impressive-product-form").dialog("open");
			});
		});
	</script>
	<div class="ui-widget-header ui-corner-all module-title">
		<h3>Impressive Product</h3>
		<div class="edit-button">
			<button id='edit-impressive-product' class="state-changable-button">...</button>
		</div>
	</div>
	<p>Content of Impressive Product Module.</p>
	
	<div id="edit-impressive-product-form" title="Edit Impressive Product Module">
		<form>
			<input type="checkbox" name="chkIsShowed" id=chkIsShowed checked="checked"/>Use this module.<br>
			Amount of items to show: <input type="text" maxlength="2" size="5" value="2" name="txtMaxAmount" id="txtMaxAmount"/>
		</form>
	</div>
</div>