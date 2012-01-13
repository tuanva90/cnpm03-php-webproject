<script type="text/javascript" src="<?php echo HTTP_JAVASCRIPT;?>/jquery/jquery.jqDock.min.js"></script>
<div id='sharing'>
  <div id='jmenu'>
    <a href="javascript:void(0)" title="Facebook" onclick="fbs_click()"><img alt="<?php echo HTTP_IMAGES;?>/sharing/facebook.png" src="<?php echo HTTP_IMAGES;?>/sharing/facebook.s.png"/></a>
    <a href="javascript:void(0)" title="Twitter" onclick="twitter_click()"><img alt="<?php echo HTTP_IMAGES;?>/sharing/twitter.png" src="<?php echo HTTP_IMAGES;?>/sharing/twitter.s.png"/></a>
    <a href="javascript:void(0)" title="Linkedin" onclick="linkedin_click()"><img alt="<?php echo HTTP_IMAGES;?>/sharing/linkedin.png" src="<?php echo HTTP_IMAGES;?>/sharing/linkedin.s.png"/></a>
    <a href="javascript:void(0)" title="Wordpress" onclick="wordpress_click()"><img alt="<?php echo HTTP_IMAGES;?>/sharing/wordpress.png" src="<?php echo HTTP_IMAGES;?>/sharing/wordpress.s.png" /></a>
    <a href="javascript:void(0)" title="Tumblr" onclick="tumblr_click()"><img alt="<?php echo HTTP_IMAGES;?>/sharing/tumblr.png" src="<?php echo HTTP_IMAGES;?>/sharing/tumblr.s.png" /></a>
    <a href="javascript:void(0)" title="MySpace" onclick="myspace_click()"><img alt="<?php echo HTTP_IMAGES;?>/sharing/myspace.png" src="<?php echo HTTP_IMAGES;?>/sharing/myspace.s.png" /></a>
    <a href="javascript:void(0)" title="Stumbleupon" onclick="stumbleupon_click()"><img alt="<?php echo HTTP_IMAGES;?>/sharing/stumbleupon.png" src="<?php echo HTTP_IMAGES;?>/sharing/stumbleupon.s.png" /></a>
    <a href="javascript:void(0)" title="Delicious" onclick="delicious_click()"><img alt="<?php echo HTTP_IMAGES;?>/sharing/delicious.png" src="<?php echo HTTP_IMAGES;?>/sharing/delicious.s.png" /></a>
    <a href="javascript:void(0)" title="Digg" onclick="digg_click()"><img alt="<?php echo HTTP_IMAGES;?>/sharing/digg.png" src="<?php echo HTTP_IMAGES;?>/sharing/digg.s.png" /></a>
    <a href="javascript:void(0)" title="Reddit" onclick="reddit_click()"><img alt="<?php echo HTTP_IMAGES;?>/sharing/reddit.png" src="<?php echo HTTP_IMAGES;?>/sharing/reddit.s.png" /></a>
    <a href="javascript:void(0)" title="Messenger" onclick="messenger_click()"><img alt="<?php echo HTTP_IMAGES;?>/sharing/messenger.png" src="<?php echo HTTP_IMAGES;?>/sharing/messenger.s.png" /></a>
    <a href="javascript:void(0)" title="Google" onclick="google_click()"><img alt="<?php echo HTTP_IMAGES;?>/sharing/buzz.png" src="<?php echo HTTP_IMAGES;?>/sharing/buzz.s.png" /></a>
    <a href="javascript:void(0)" title="Blogger" onclick="blogger_click()"><img alt="<?php echo HTTP_IMAGES;?>/sharing/blogger.png" src="<?php echo HTTP_IMAGES;?>/sharing/blogger.s.png" /></a>
    <a href="javascript:void(0)" title="Google Reader" onclick="googlereader_click()"><img alt="<?php echo HTTP_IMAGES;?>/sharing/google.png" src="<?php echo HTTP_IMAGES;?>/sharing/google.s.png" /></a>
    <a href="javascript:void(0)" title="Linkhay" onclick="linkhay_click()"><img alt="<?php echo HTTP_IMAGES;?>/sharing/linkhay.png" src="<?php echo HTTP_IMAGES;?>/sharing/linkhay.s.png" /></a>
    <a href="javascript:void(0)" title="Zing Me" onclick="zingme_click()"><img alt="<?php echo HTTP_IMAGES;?>/sharing/zing.png" src="<?php echo HTTP_IMAGES;?>/sharing/zing.s.png" /></a>
  </div>
</div>
<script type="text/javascript">
function GetMetaValue(meta_name) {
	var my_arr=document.getElementsByTagName("META");
	for (var counter=0; counter<my_arr.length; counter++) {
		if (my_arr[counter].name.toLowerCase() == meta_name.toLowerCase()) {
			return my_arr[counter].content;
		}
	}  
	return "N/A";
}
</script>
<script type="text/javascript">
function fbs_click() {u=location.href;t=document.title;window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}
function twitter_click(){u=location.href;t=document.title;window.open('http://twitter.com/share/?url='+encodeURIComponent(u)+'&text='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}
function linkedin_click(){u=location.href;t=document.title;window.open('http://www.linkedin.com/shareArticle?url='+encodeURIComponent(u)+'&title='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}
function wordpress_click(){u=location.href;t=document.title;window.open('http://so1vnforum.wordpress.com/wp-admin/press-this.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t)+'&s='+GetMetaValue('description')+'&v='+2,'sharer','toolbar=0,status=0,width=626,height=436');return false;}
function tumblr_click() {u=location.href;t=document.title;window.open('http://www.tumblr.com/share/link?url='+encodeURIComponent(u)+'&name='+t+'&description='+GetMetaValue('description'),'sharer','toolbar=0,status=0,width=626,height=436');return false;}
function myspace_click() {u=location.href;t=document.title;window.open('http://www.myspace.com/index.cfm?fuseaction=postto&t='+encodeURIComponent(t)+'&c='+GetMetaValue('description')+'&u='+encodeURIComponent(u),'sharer','toolbar=0,status=0,width=626,height=436');return false;}
function stumbleupon_click() {u=location.href;t=document.title;window.open('http://www.stumbleupon.com/submit?url='+encodeURIComponent(u)+'&title='+t,'sharer','toolbar=0,status=0,width=626,height=436');return false;}
function delicious_click() {u=location.href;t=document.title;window.open('http://delicious.com/post?url='+encodeURIComponent(u)+'&title='+t+'&notes='+GetMetaValue('description'),'sharer','toolbar=0,status=0,width=626,height=436');return false;}
function digg_click() {u=location.href;t=document.title;window.open('http://digg.com/submit?url='+encodeURIComponent(u)+'&title='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}
function reddit_click() {u=location.href;t=document.title;window.open('http://www.reddit.com/submit?url='+encodeURIComponent(u)+'&title='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}
function messenger_click() {u=location.href;t=document.title;window.open('http://profile.live.com/P.mvc#!/badge?url='+encodeURIComponent(u)+'&title='+encodeURIComponent(t)+'&description='+GetMetaValue('description'),'sharer','toolbar=0,status=0,width=626,height=436');return false;}
function google_click() {u=location.href;t=document.title;window.open('http://www.google.com/bookmarks/mark?op=edit&bkmk='+encodeURIComponent(u)+'&title='+t+'&annotation='+GetMetaValue('description'),'sharer','toolbar=0,status=0,width=626,height=436');return false;}
function blogger_click(){u=location.href;t=document.title;window.open('http://www.blogger.com/blog_this.pyra?t=&u='+encodeURIComponent(u)+'&n='+encodeURIComponent(t)+'&pli='+1,'sharer','toolbar=0,status=0,width=626,height=436');return false;}
function googlereader_click() {u=location.href;t=document.title;window.open('http://www.google.com/reader/link?url='+encodeURIComponent(u)+'&title='+t+'&snippet='+GetMetaValue('description'),'sharer','toolbar=0,status=0,width=626,height=436');return false;}
function linkhay_click() {u=location.href;t=document.title;window.open('http://linkhay.com/submit?link_url='+encodeURIComponent(u)+'&link_title='+t,'sharer','toolbar=0,status=0,width=626,height=436');return false;}
function zingme_click() {u=location.href;t=document.title;window.open('http://link.apps.zing.vn/pro/view/conn/share?u='+encodeURIComponent(u)+'&t='+t+'&desc='+GetMetaValue('description'),'sharer','toolbar=0,status=0,width=626,height=436');return false;}
//function govn_click() {u=location.href;t=document.title;window.open('http://my.go.vn/share.aspx?url='+encodeURIComponent(u)+'&title='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}
function yahoo_click() {u=location.href;t=document.title;window.open('http://buzz.yahoo.com/buzz?publisherurn=VNE&targetUrl='+encodeURIComponent(u),'sharer','toolbar=0,status=0,width=626,height=436');return false;}
</script>
<script>
$(document).ready(function($){
	  $('#sharing #jmenu').jqDock({
		  align:'left',
		  size:24,
		  labels:'tr'
	 });
});
</script>