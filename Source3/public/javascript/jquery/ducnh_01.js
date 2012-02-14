$(document).ready(function(){
	var _currentNewsID;
	//
	$('#contextMenu').hide();
	
	$('.editable-item').mouseenter(function(e){
		if($('#contextMenu').css('display')=='block') return false;
		e.stopPropagation();
		_currentNewsID = $(this).attr('newsid');
		var offset = $(this).offset();
		$('#highlighter-region').css('position','absolute');
		$('#highlighter-region').css('top', offset.top);
		$('#highlighter-region').css('left', offset.left);
		$('#highlighter-region').css('width',$(this).width());
		$('#highlighter-region').css('height',$(this).height());
		$('#highlighter-region').css('display','block');
		
	});
	
	$('#highlighter-region').click(function(e){
		e.stopPropagation();
		$('#contextMenu').css('top',e.pageY);
		$('#contextMenu').css('left',e.pageX);
		$('#contextMenu').find('input[name=news-id]').val(_currentNewsID);
		$('#contextMenu').show();
		
	});
	
	$('#remove-menu-item_01').click(function(){
		var actionurl = $("#delete-action").val();
		$('#news-context-menu').attr('action',actionurl);
		$('#news-context-menu').submit();
	});
	
	
	$('#add-menu-item_01').click(function(){
		$('#add-form').dialog("open");
	});
	
	$('#edit-menu-item_01').click(function(){
		$('#add-form').after("<input type='hidden' name='save-news-id' value='" + _currentNewsID + "'/>");
		$('#add-form').dialog("open");
	});
	
	$('#edit-news-form').bind(function(){
		ajax({
			url:'<?php ?>'
		});
	});
});
$(function(){
	//
	$(document).click(function(){
		$('#highlighter-region').hide();
		$('#contextMenu').hide();
	});
	
	//
	$('#add-form').dialog({
			autoOpen:false,
			modal:true,
			width:500,
			height:500,
			buttons: {
				"Save": function() {
					$('#add-news-form').submit();
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}});
	
	//
	$('#edit-form').dialog({
		autoOpen:false,
		modal:true,
		width:500,
		height:500,
		buttons:{
			"Save":function(){
				$('#edit-news-form').submit();
			},
			Cancel:function(){
				$(this).dialog("close");
			}
		}
	});
});