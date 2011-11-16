$(document).ready(function(){
	var flag=false;
	$(':checkbox:first').click(function(){
		flag=!flag;
		$(':checkbox').attr('checked',flag);
	});
	$(".right div a:contains('Delete')").click(function(){
		var x=$(':checkbox:checked').length;
		if(x==0) return confirm('Bạn chưa chọn sản phẩm nào');
		if($(':checkbox:first').is(':checked')) return confirm('Bạn muốn xóa hết tất cả các sản phẩm');
		var len=$(':checkbox').length;
		var s="";
		for(var i=0;i<len;i++)
		{
			var k=$(':checkbox').eq(i);
			if(k.is(':checked'))
			{
				s+=k.parent().next().text();
			}
		}
		return confirm('Bạn muốn xóa các sản phẩm có id là'+s);
	});
});