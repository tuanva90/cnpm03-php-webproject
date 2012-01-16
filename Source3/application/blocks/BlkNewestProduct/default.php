<script type="text/javascript">
$(function(){
	$("#edit-newest-product").button().click(function(){
		$("#edit-newest-product-form").dialog("open");
	});

	$("#edit-newest-product-form").dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		modal: true,
		buttons: {
			"Save": function() {
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			allFields.val( "" ).removeClass( "ui-state-error" );
		}
	});
});
</script>

<div class="ui-widget-content ui-conner-all module" id="newest-product">
	<div class="ui-widget-header ui-conner-all module-title">
		<h3>Newest Product</h3>
		<div class="edit-button"><button id='edit-newest-product'>...</button></div>
	</div>
	<p>Content of Newest Product Module.</p>
</div>

<div id="edit-newest-product-form" title="Edit Newest Product Module">
	<form>
		<input type="checkbox" name="chkIsShowed" id=chkIsShowed checked="checked"/>Use this module.<br>
		Amount of items to show: <input type="text" maxlength="2" size="5" value="5" name="txtMaxAmount" id="txtMaxAmount"/>
	</form>
</div>