<script type="text/javascript">
$(function(){
	$("#edit-login").button().click(function(){
		$("#edit-login-form").dialog("open");
	});

	$("#login-button").button();

	$("#edit-login-form").dialog({
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

<div class="ui-widget-content ui-conner-all module" id="login">
	<div class="ui-widget-header ui-conner-all module-title">
		<h3>Login</h3>
		<div class="edit-button"><button id='edit-login'>...</button></div>
	</div>
	Username:<br> 
	<input type="text" name="txtUserName" id="txtUserName" maxlength="50" size="25"/><br>
	Password:<br>
	<input type="password"" name="txtPassword" id="txtPassword" maxlength="50" size="25"/><br>
	<input type="checkbox" name="chkSaveMe" id="chkSaveMe">Keep me signed in.<br>
	<a href="#">Forgot your password?</a><br>
	<div id="login-button">Login</div>
</div>

<div id="edit-login-form" title="Edit Login Module">
	<form>
		<input type="checkbox" name="chkIsShowed" id=chkIsShowed checked="checked"/>Use this module.<br>
		<input type="checkbox" name="chkShowForgetPass" id=chkIsShowed checked="checked"/>Show 'Forgort password' link.<br>
		<input type="checkbox" name="chkShowKeepSignIn" id=chkIsShowed checked="checked"/>Show 'Keep me signed in' checkbox.<br>
	</form>
</div>
<div id="test-child-dialog"></div>