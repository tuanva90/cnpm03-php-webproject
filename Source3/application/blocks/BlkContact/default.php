<div class="ui-widget-content ui-conner-all module" id="<?php echo $info['module_id'];?>">	<script type="text/javascript">		$(document).ready(function()    {	        $('#contact-form').validate();	        $('#name-contact').click(function(){		        $(this).focus();});	        $('#email-contact').click(function(){		        $(this).focus();});	        $('#subject-contact').click(function(){		        $(this).focus();});	        $('#comments-contact').click(function(){		        $(this).focus();});	        $('#security_code1').click(function(){		        $(this).focus();});	    });	    $(function() {		    $("#send").button().click(function() {		    	$("#send").html("Sending...");		    	submitForm();			});						$("#edit-contact").button().click(function() {			});					    function submitForm() {		    	$.ajax({					type: 'POST',					url: '<?php echo HTTP_SERVER."front/index/sendcontact"?>',					data: {						name: $("input[name=name]").val(),						email: $("input[name=email]").val(),						comments: $("input[name=comments]").val(),						subject: $("input[name=subject]").val()					},					success: function(data) {						$("#send").html("Send Message");						},					error: function(request, error) {						$("#send").html("Send Message");						$("#validating-contact").html(request.responseText);					}					});			};		});	</script>	<div class="ui-widget-header ui-corner-all module-title">		<h3>Contact Us</h3>		<div class="edit-button">			<button id='edit-contact' class="state-changable-button">...</button>		</div>	</div>	<div id="contact">        <div id="validating-contact" class="ui-state-error"></div>        <!-- <img class="stamp" src="images/stamp.png" alt="stamp" /> -->        <form method="post" action="" id="contact-form">                <label for="name-contact"><strong>Name:<span>*</span></strong></label>                <input type="text" size="50" name="name-contact" id="name-contact" class="required" minlength="4" /><br>                <label for="email-contact"><strong>Email:<span>*</span></strong></label>                <input type="text" size="50" name="email-contact" id="email-contact" class="required email" /><br>                <label for="subject-contact"><strong>Subject:</strong></label>                <input type="text" size="50" name="subject-contact" id="subject-contact"/><br>                <label for="comments-contact"><strong>Comments:</strong><span>*</span>                </label>                <textarea rows="" cols="" name="comments-contact" id="comments-contact" class="required"></textarea><br>            <img src="<?php echo HTTP_SERVER."public/images/captcha/captcha.php"?>" id="captcha" alt="captcha"/>            <label for="security_code1"><strong>Spam protection:</strong><span>*</span>            </label>            <input type="text" id="security_code1" name="security_code1" autocomplete="off" class="required"/>            <input type="submit" value="Send Message" name="send" id="send" />            <!-- <div id="send">Send Message</div>  -->        </form>    </div></div>