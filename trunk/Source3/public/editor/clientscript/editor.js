var tEditor = null;
function replace(id, id_replace, str_directory)
{
	var tx = document.getElementById(id);
	//alert(tx.value);
	RTE=new Editor('RTE', id, id_replace, tx.value,600, 350, str_directory);
	RTE.display(id);
	RTE.setHTMLto(id);
	
	with(tx.style){visibility = 'hidden'; display = 'none';};
	//with(tx.style){visibility = 'hidden'; display = 'none';}//
	//tx.setAttribute('style', 'visibility: hidden; display: none;');
	tEditor = RTE;
}


function rte_reset()
{
	tEditor = null;
	RTE = null;
}

function getNavigator(){
	var bUserAgent=navigator.userAgent.toLowerCase();
	if(bUserAgent.indexOf('msie')>0){
		return 'msie';}
	else 
		if(bUserAgent.indexOf('opera')==0){return 'opera'}
		else 
			if(bUserAgent.indexOf('safari')>0){
				if(bUserAgent.indexOf('chrome')==-1){
					return 'safari';}
				else{return 'chrome'}}
			else{return 'firefox';}
};

var nav=getNavigator();
var isIE=(nav=='msie')?true:false;
var isMz=(nav=='firefox')?true:false;
var isOp=(nav=='opera')?true:false;
var isGC=(nav=='chrome')?true:false;
var isSa=(nav=='safari')?true:false;


	

function Editor(instanceName, contentplaceholder, contain, defaultContent, width, height, str_directory){
  this.is=instanceName;
  this.contentplaceholder = contentplaceholder;
  this.contain=contain;
  this.ID=this.is+'_editor';
  this.UI=null;
  this.ed=null;
  this.cnt=defaultContent;
  this.width=width<300?300:width;
  this.height=height<200?200:height;
  this.cache='';
  this.submenu=null;
  this.btnApp=null;
  this.preilta=null;
  this.ToolBar=contain+'_toolBar';
  this.sm= function(el,s){
	this.cm();
	this.rel(this.is+'_'+el).style.position='relative';
	var paf=document.createElement('div');
	var pop=document.createElement('div');
	var w=this.width;
	var h=this.height;
	paf.id=this.is+'_ePaf';
	pop.id=this.is+'_'+el+'_pop';
	with(paf.style){position='absolute';
		padding='0px';
		backgroundImage='url("'+this.iconPath+'bg.gif")';
		top=isOp?'35px':'28px';
		left='0px';
		zIndex='2';
		width=(w==0)?'100%':w+'px';
		height=(h-58)+'px';
		}
	with(pop.style){
		position='absolute';
		padding='2px';
		borderWidth='1px';
		borderStyle='solid';
		borderColor='#cccccc';
		background='#ffffff';
		cursor='default';
		top=isOp?'38px':'25px';
		left='0px';
		zIndex='3';
		}
	pop.innerHTML=s;
	this.rel(this.is+'_subMenu').appendChild(paf);
	this.rel(this.is+'_'+el+'_menu').appendChild(pop);
	this.sa(this.is+'_ePaf', 'click', this.is+'.cm()');
	this.submenu=this.is+'_'+el+'_pop';
	this.btnApp=this.is+'_'+el+'_menu';
	this.preilta=paf;
  	};
  
  	this.addButton=function(id,t,ic,f,no,i){
		if(i!=null&&!isNaN(i)&&i>=0&&i<this.bs.length){
			this.bs.splice(i,0,new Array(id,t,ic,f,(no==null)?1:no));
			}
		else{
			this.bs.push(new Array(id,t,ic,f,(no==null)?1:no));
		}
		this.ltb();
	};
	
	this.moveButton=function(id,ix,r){
		for(var i=0;i<this.bs.length;i++){
			if(id==this.bs[i][0]){
				if(r==2){this.bs[i][4]=2;}
				else{this.bs[i][4]=1;}
				if(!isNaN(ix)&&ix>=0&&ix<this.bs.length){
					var t=this.bs[i];
					this.bs.splice(i,1);
					this.bs.splice(ix,0,t);};
				break;
			}
		}
		this.ltb();
	};
	
	this.cm=function(){  //gán nội dung innerHTML cho đối tượng btnApp = '', đồng thời gỡ bỏ 'preilta'
	if(this.submenu!=null){
		this.clearTxt(this.btnApp);
		this.submenu=null;
		if(this.preilta){
			this.rel(this.is+'_subMenu').removeChild(this.preilta);
			this.preilta=null;}
		}
	};
	
	this.unformat=function(){
		if(isOp){
			var sel=this.UI.getSelection();
			this.fmt('inserthtml',sel);}
		else{
			this.fmt('unlink');
			this.fmt('removeformat');}
	};
	
	this.getSelectedText=function(){
		if(!isIE){
			var sel=this.UI.getSelection();
			if(sel==''){return ''}
			var rg=sel.getRangeAt(0);
			var doc=rg.extractContents();
			var xmls=new XMLSerializer();
			return xmls.serializeToString(doc)}
		else{
			var ir=this.ed.selection.createRange();
			ir.select();
			return ir.htmlText;}
	};
	
	this.quote=function(){
		try{
			var s=this.getSelectedText();
			if(s!=''){
				var qt='';
				var sq='<br><blockquote style="border-left:1px solid rgb(204, 204, 204); margin: 1px 1px 1px 20px; padding-left: 8px;">',eq='</blockquote><br>';
				if(!isIE){
					qt=sq+s+eq;
					this.fmt('inserthtml',qt);}
				else{
					var ig=this.ed.selection.createRange();
					ig.select();
					qt=sq+s+eq;
					ig.pasteHTML(qt);}
				}
		}catch(e){}
	};
	
	this.code=function(){
		try{
			this.unformat();
			var ss=this.getSelectedText();
			if(ss!=''){
				var sc='<br>'+this.openCodeTag+'<br>', ec='<br>'+this.closeCodeTag+'<br>';
				if(!isIE){
					this.fmt('inserthtml',sc+ss+ec);}
				else{
					var ig=this.ed.selection.createRange();
					ig.select();
					ig.pasteHTML(sc+ss+ec);}
			}
		}catch(e){}};
		
	this.rel=function(ob){
		try{
			return document.getElementById(ob);}
		catch(e){}};
		
	this.gTxt=function(ob,txt){
		try{
			this.rel(ob).innerHTML=txt;}
		catch(e){}};
		
	this.clearTxt=function(ob){
		try{this.gTxt(ob,"");}
		catch(e){}
	};
	
	this.setStyle=function(ob,cln){
		this.rel(ob).className=cln;};
		
	this.osl=function(){ // hình ảnh mặt cười
		var s='<table border="0" width="120" height="100%" cellpadding="0" cellspacing="0">';
		var h=0,k=0;
		for(var i=0;i<8;i++){
			s+='<tr height="20" >';
			h=k;
			for(var j=0;j<4;j++){
				if(this.emoticons[(h+j)]){
					s+='<td align="center" width="30" height="25" title="'+this.emoticons[(h+j)][0]+'"><img src="'+this.emoticonPath+this.emoticons[(h+j)][2]+'" onclick="'+this.is+'.insertImage(\''+this.emoticonPath+this.emoticons[(h+j)][2]+'\');"></td>';
				}
				else{s+='<td>&nbsp;</td>';}
				k++;
			}
			s+='</tr>';
		}
		s+='</table>';
		this.sm('btnEmoticon',s);
	};
	
	this.cl=function(no){
		var s='<div><table border="0" bgcolor="#999999" cellspacing="0" cellpadding="0">';
		var m=0;
		for(var i=0;i<5;i++){
			s+='<tr>';
			for(var j=0;j<8;j++){
				s+='<td title="'+this.colors[m][1]+'"><'+(isIE?'button':'div')+' id="bcm_'+m+'_'+no+'" class="cOut" onmouseover="'+this.is+'.setStyle(\'bcm_'+m+'_'+no+'\',\'cOver\');" onmouseout="'+this.is+'.setStyle(\'bcm_'+m+'_'+no+'\',\'cOut\');" style="background-color:'+this.colors[m][0]+';" onclick="'+this.is+'.fmt(\''+(no==1?'forecolor':(isIE?'backcolor':'hilitecolor'))+'\',\''+this.colors[m][0]+'\');'+this.is+'.cm();">&nbsp;</'+(isIE?'button':'div')+'></td>';
				m++;
			}
			s+='</tr>';
		}
		s+='</table></div>';
		this.sm((no==1?'btnFontcolor':'btnBackcolor'),s);
	};
	
	this.fsl=function(){
		var z=0,s='<table border="0" cellpadding="0" cellspacing="1" width="20">';
		for(var i=0;i<this.fontSize.length;i++){
			z=i+1;
			s+='<tr><td><'+(isIE?'button':'div')+' id="fsm'+i+'" class="mOut" style="border:none;font-family:serif;width:100%;text-align:center;margin:0px;padding:0px;"  onclick="'+this.is+'.fmt(\'fontsize\',\''+this.fontSize[i]+'\');'+this.is+'.cm();" onmouseover="'+this.is+'.setStyle(\'fsm'+i+'\',\'mOn\');" onmouseout="'+this.is+'.setStyle(\'fsm'+i+'\',\'mOut\');" title="'+z+'"><font size="'+this.fontSize[i]+'">'+this.fontSize[i]+'</font></'+(isIE?'button':'div')+'></td></tr>';
		}
		s+='</table>';
		this.sm('btnFontsize',s);
	};
	
	this.ffl=function(){
		var s='<table cellpadding="0" cellspacing="0" width="100">';
		for(var i=0;i<this.fontFace.length;i++){
			s+='<tr><td><'+(isIE?'button':'div')+' id="ffm'+i+'" class="mOut" style="border:none;font-family:serif;width:100%;text-align:left;margin:0px;padding:0px;" onclick="'+this.is+'.fmt(\'fontname\',\''+this.fontFace[i]+'\');'+this.is+'.cm();" onmouseover="'+this.is+'.setStyle(\'ffm'+i+'\',\'mOn\');" onmouseout="'+this.is+'.setStyle(\'ffm'+i+'\',\'mOut\');" title="'+this.fontFace[i]+'"> &nbsp; <font face="'+this.fontFace[i]+'">'+this.fontFace[i]+'</font></'+(isIE?'button':'div')+'></td></tr>';
		}
		s+='</table>';
		this.sm('btnFontface',s);
	};
	this.undoClear=function(){
		if(this.cache!=''){
			this.cnt=this.cache;
			this.ed.body.innerHTML=this.cnt;
			this.cache='';
			this.clearTxt('undo');}
	};
	
	this.clearAll=function(){
		this.cache=this.getHTML();
		this.cnt="";
		this.ed.body.innerHTML='<br>';
		if(this.cache.length>5){
			this.gTxt('undo','<span class="ctr" id="btnUndoClear" title="Undo Clear">Undo</span>');
			this.sa('btnUndoClear','click',this.is+'.undoClear();');
		}
	};
	
	this.selectAll=function(){
		this.cm();
		this.fmt('selectall');
		this.UI.focus();
	};
	
	this.getHTML=function(){
		return this.ed.body.innerHTML;};
		
	this.setHTMLto = function(id)
	{
		//alert(id);
		this.rel(id).innerHTML = this.getHTML();
		//this.rel('pos').innerHTML = this.getHTML();
		//this.ed=this.UI.document;
		//var docum = document.getElementById(id);
		//.getElementById(id).innerHTML=this.getHTML();
		
	//	document.getElementById('str').innerHTML=document.getElementById(id).value;
		//(document.getElementById(id).value);
	};
	
	this.addHTML = function(){
		//this.ed.body.ad
	};
	
	this.c=function(){return this.getHTML();};
	
	this.getText=function(){return isIE?this.ed.body.innerText:this.ed.body.textContent;};
	
	this.iconPath= str_directory + 'pics/';
	this.emoticonPath= str_directory +'emoticons/';
	this.textColor='#000000';
	this.textFont='sans-serif';
	this.textSize='14px';
	this.backgroundImage=new Object();
	this.backgroundImage.url= str_directory +'pics/background.jpg';
	this.backgroundImage.repeat='no-repeat';
	this.backgroundImage.position='top right';
	this.backgroundColor='#ffffff';
	this.toolbarColor="#f2fff2";
	this.showFootbar=true;
	this.openCodeTag='[script]';
	this.closeCodeTag='[/script]';
	this.removeButton=function(btn){
		for(var k=0;k<arguments.length;k++){
			if(!isNaN(arguments[k])){
				if(arguments[k]>=0&&arguments[k]<this.bs.length){
					this.bs.splice(arguments[k],1);
				}
			}
			else{
				for(var i=0;i<this.bs.length;i++){
					if(arguments[k]==this.bs[i][0]){
						this.bs.splice(i,1);
						break;}
				}
			}
		}
		this.ltb();
	};
	
	this.ltb=function(){
		var s='<table border="0" cellpadding="1" cellspacing="0">';
		var tt=1;
		for(var i=0;i<this.bs.length;i++){
			if(this.bs[i][4]!=1){
				tt=2;break;}
		}
		if(tt==1){
			s+='<tr height="25">';
			for(var i=0;i<this.bs.length;i++){
				s+='<td width="20">';
				s+='<span style="position:relative;" id="'+this.is+'_'+this.bs[i][0]+'_menu"></span>';
				s+= '<div id="'+this.is+'_'+this.bs[i][0]+'" style="background-image:url('+this.iconPath+this.bs[i][2]+');background-repeat:no-repeat;background-position: center center;" class="bOut" title="'+this.bs[i][1]+'">';
				s+= '<img src="'+this.iconPath+'bg.gif" width="18" height="18">';
				s+= '</div>';
				s+='</td>';
			}
			s+='</tr>';
		}
		else if(tt==2){
			s+='<tr height="20">';
			var mx=m=n=0;
			r=[[],[]];
			for(var i=0;i<this.bs.length;i++){
				if(this.bs[i][4]==1){
					r[0].push(this.bs[i]);m++;}
				else{
					r[1].push(this.bs[i]);n++;}
			}
			mx=m>n?m:n;
			for(var i=0;i<mx;i++){
				if(i<r[0].length){
					s+='<td width="20">';s+='<span style="position:relative;" id="'+this.is+'_'+r[0][i][0]+'_menu"></span><div id="'+this.is+'_'+r[0][i][0]+'" style="background-image:url('+this.iconPath+r[0][i][2]+');background-repeat:no-repeat;background-position: center center;" class="bOut" title="'+r[0][i][1]+'"><img src="'+this.iconPath+'bg.gif" width="18" height="18"></div>';s+='</td>';
				}
				else{
					s+='<td width="20">&nbsp;</td>';
					}
			}
			s+='</tr>';
			s+='<tr height="25">';
			for(var i=0;i<mx;i++){
				if(i<r[1].length){
					s+='<td width="20">';
					s+='<span style="position:relative;" id="'+this.is+'_'+r[1][i][0]+'_menu"></span><div id="'+this.is+'_'+r[1][i][0]+'" style="background-image:url('+this.iconPath+r[1][i][2]+');background-repeat:no-repeat;background-position: center center;" class="bOut" title="'+r[1][i][1]+'"><img src="'+this.iconPath+'bg.gif" width="18" height="18"></div>';s+='</td>';
				}
				else{
					s+='<td width="20">&nbsp;</td>';}
			}
			s+='</tr>';
		}
		s+='</table>';
		this.gTxt(this.ToolBar,s);
		for(var i=0;i<this.bs.length;i++){
			if(this.bs[i].callback!=''){
				this.sa(this.is+'_'+this.bs[i][0],'click',this.bs[i][3]);
			}
			this.sa(this.is+'_'+this.bs[i][0],'mouseout', this.is + '.setStyle("'+this.is+'_'+this.bs[i][0]+'","bOut")');
			this.sa(this.is+'_'+this.bs[i][0], 'mouseover', this.is + '.setStyle("'+this.is+'_'+this.bs[i][0]+'","bOver")');
		}
	};
	
	this.sa=function(o,e,f){//thêm sự kiện 'e' vào đối tượng có id = 'o' và hàm xử lý là new Function(f)
		var el=this.rel(o);
		if(el!=null){
			if(el.addEventListener){
				el.addEventListener(e,new Function(f),false)}
			else 
				if(el.attachEvent){
					el.attachEvent('on'+e, new Function(f))
				}
			}
	};
	
	this.display=function(id){
		var sEditor='<iframe id="'+this.ID+'" style="width:'+((this.width==0)?'99%':(this.width-5)+'px')+';height:'+(this.height-(this.showFootbar?55:30))+'px;overflow:auto;margin:0px;padding:0px;"></iframe>'
			,sCB=''
			,s='<table id = "tbeditor" border="0" width="'+((this.width==0)?'100%':this.width)+'" height="'+this.height+'" cellpadding="1" cellspacing="0" style="background-color:#f7fff3;"><tr height="25" bgcolor="'+this.toolbarColor+'"><td colspan="2"><span id="'+this.is+'_subMenu" style="position:relative;top:0px;left:0px;"></span><span id="'+this.ToolBar+'">&nbsp;</span></td></tr><tr height="'+(this.height-(this.showFootbar?50:25))+'"><td colspan="2">'+sEditor+'</td></tr>';
		/*if(this.showFootbar){
			for(var i=0;i<this.controlButtons.length;i++){
				sCB+='<input type="button" name="'+this.is+'_'+this.controlButtons[i][0]+'" id="'+this.is+'_'+this.controlButtons[i][0]+'" value="'+this.controlButtons[i][1]+'" style="width:100px;" class="mouseOut" title="'+this.controlButtons[i][1]+'">';
			}
			s+='<tr height="25"><td colspan="2"><table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0"><tr><td width="30%">&nbsp; <span class="ctrE" title="Select All" onclick="'+this.is+'.selectAll();">Select All</span> &nbsp; <span class="ctrE" title=" Clear All " onclick="'+this.is+'.clearAll();">Clear All</span> &nbsp; &nbsp;<span id="undo" style="background-color:#ffff99;"></span></td><td width="70%" align="right">'+sCB+'</td></tr></table></td></tr>';
		}*/
		s+='</table>';
		this.gTxt(this.contain,s);
		this.ltb();
		this.sa('tbeditor', 'mouseover', this.is + '.setHTMLto("'+ this.contentplaceholder +'")');
		/*--------------------------------------- TEST BY DUCNH ---------------------------------------------*/
		//if(document.addEventListener){
		//	document.addEventListener('mouseover', new Function(this.is + '.setHTMLto("'+ this.contentplaceholder +'")'), false);
		//}
		//else if(document.attachEvent){
		//	document.attachEvent('onmouseover', new Function(this.is + '.setHTMLto("'+ this.contentplaceholder +'")'));
		//}
		/*--------------------------------------- END TEST FIELD ---------------------------------------------*/
		
		this.UI=this.rel(this.ID).contentWindow;
		this.ed=this.UI.document;
		with(this.ed){
			designMode='On';
			open();
			write('<html><head><style>p{margin:0px;padding:0px;}</style></head><body style="color:'+this.textColor+';font-family:'+this.textFont+';font-size:'+this.textSize+';margin:2px;padding:4px;background-color:'+this.backgroundColor+';'+((this.backgroundImage.url!='')?'background:'+this.backgroundColor+' url(\''+this.backgroundImage.url+'\') '+this.backgroundImage.repeat+' '+this.backgroundImage.position+' fixed;':'')+'"><br>'+this.cnt+'</body></html>'
				);
			close()
		;}
		this.UI.focus();
	};
	
	this.fmt=function(c,v){
		this.cm();
		if(this.ed.queryCommandEnabled(c)){
			if(!v){v=null;}
			this.ed.execCommand(c,false,v);
			this.UI.focus();}
		};
	
	this.addLink=function(){
	this.cm();
    var aLink=prompt('Enter or paste a link :', '');
      if(aLink){
        this.fmt('CreateLink', aLink);
      }
  };
	
	var new_window;
	function popup(url)
	{ 
		new_window=window.open(url,'name','height=800,width=600');
		if (window.focus) {new_window.focus();}
	
	}
	
  /*this.insertImage=function(url){
	this.cm();
	this.UI.focus();
	
	  var aLink=(url==null)?popup('http://localhost/Zends/link.so1vn.vn/admin/filemanager'):url;
	  if(aLink){
        this.fmt('InsertImage',  aLink);
	  }
  } */
  this.bs=[
		['btnBold', 'Bold', 'bold.gif', this.is+'.fmt("bold")', 1],
		['btnItalic', 'Italic', 'italic.gif', this.is+'.fmt("italic")', 1],
		['btnUnderline', 'Underline', 'underline.gif', this.is+'.fmt("underline")', 1],
		['btnFontface', 'Font Face', 'fontface.gif', this.is+'.ffl()', 1],
		['btnFontsize', 'Font Size', 'fontsize.gif', this.is+'.fsl()', 1],
		['btnFontcolor', 'Font Color', 'fontcolor.gif', this.is+'.cl(1)', 1],
		['btnBackcolor', 'Background Color', 'bgcolor.gif', this.is+'.cl(2)', 1],
		['btnSuperscript', 'Super Script', 'sup.gif', this.is+'.fmt("superscript")', 1],
		['btnSubscript', 'Sub Script', 'sub.gif', this.is+'.fmt("subscript")', 1],
		['btnInsertLink', 'Insert Link', 'link.gif', this.is+'.addLink()', 1],
		['btnInsertImage', 'Insert Image', 'image.gif', this.is+'.insertImage()', 1],
	//	['btnEmoticon', 'Emoticons', '8.gif', this.is+'.osl()', 1],
		['btnAlignLeft', 'Align Left', 'alignLeft.gif', this.is+'.fmt("justifyleft")', 1],
		['btnAlignCenter', 'Align Center', 'alignCenter.gif', this.is+'.fmt("justifycenter")', 1],
		['btnAlignRight', 'Align Right', 'alignRight.gif', this.is+'.fmt("justifyright")', 1],
		['btnAlignJustify', 'Align Justify', 'alignJustify.gif', this.is+'.fmt("justifyfull")', 1],
		['btnOrderedList', 'Ordered List', 'orderedList.gif', this.is+'.fmt("insertorderedlist")', 1],
		['btnBulletedList', 'Bulleted List', 'bulletedList.gif', this.is+'.fmt("insertunorderedlist")', 1],
		['btnIndentMore', 'Indent', 'indent.gif', this.is+'.fmt("indent")', 1],
		['btnOutdentMore', 'Outdent', 'outdent.gif', this.is+'.fmt("outdent")', 1],
		//['btnQuote', 'Quote', 'quote.png', this.is+'.quote()', 1],
		//['btnCode', 'Source Code', 'code.jpg', this.is+'.code()', 1],
		['btnUnformat', 'Remove Formatting', 'removeformatting.gif', this.is+'.unformat()', 1]
  ];
  this.fontSize=[1,2,3,4,5,6,7];
  this.fontFace=['Courier','Georgia','Cursive','Fixedsys','Impact','Serif','Sans-Serif','Elephant'];
  this.colors=[
	['#000000','Black'],
	['#A0522D','Sienna'],
	['#556B2F','Dark Olive Green'],
	['#006400','Dark Green'],
	['#483D8B','Dark Slate Blue'],
	['#000080','Navy'],
	['#4B0082','Indigo'],
	['#2F4F4F','Dark Slate Gray'],
	['#8B0000','Dark Red'],
	['#FF8C00','Dark Orange'],
	['#808000','Olive'],
	['#008000','Green'],
	['#008080','Teal'],
	['#0000FF','Blue'],
	['#708090','Slate Gray'],
	['#696969','Dim Gray'],
	['#FF0000','Red'],
	['#F4A460','Sandy Brown'],
	['#9ACD32','Yellow Green'],
	['#2E8B57','Sea Green'],
	['#48D1CC','Medium Turquoise'],
	['#4169E1','RoyalBlue'],
	['#800080','Purple'],
	['#808080','Gray'],
	['#FF00FF','Magenta'],
	['#FFA500','Orange'],
	['#FFFF00','Yellow'],
	['#00FF00','Lime'],
	['#00FFFF','Cyan'],
	['#00BFFF','Deep SkyBlue'],
	['#9932CC','Dark Orchid'],
	['#C0C0C0','Silver'],
	['#FFC0CB','Pink'],
	['#F5DEB3','Wheat'],
	['#FFFACD','Lemon Chiffon'],
	['#98FB98','Pale Green'],
	['#AFEEEE','Pale Turquoise'],
	['#ADD8E6','Light Blue'],
	['#DDA0DD','Plum'],
	['#FFFFFF','White'],
	['#DDA0DD','Plum'],
	['#FFFFFF','White']
  ];
 
}
$(function() {

//
	$(document).ready(function(){
	$('#insert-hyperlink-tab').hide();
		
	$('#RTE_btnInsertImage').live("click",function() {
		$( '<div id="insert-image-form" title="Chèn hình ảnh"><form><div id="tab-header"><ul id="tab-buttons"><li id="image-info" class="active-tab"><a href="javascript:void();">Thong tin hinh anh</a></li><li class="unactive-tab" id="insert-hyperlink"><a href="javascript:void();">Lien ket</a></li></ul></div> <div id="tab-content">'
		+ '<div id="image-info-tab">URL<br/><input type="text" size="45" name="url" id="url1"/><input type="button" name="btnBrowser" id="btnBrowser1" value="Duyet"/><br/>'
		+'<table border="2" cellpadding="0" cellspacing="1"> <tr> <td>' + 'Chú thích hình ảnh<br/><input type="text" size="14" name="image-alt" id="image-alt"/><br/>'
		+ 'Chiều rộng<br/><input type="text" size="14" id="image-width"/><br/>'
		+ 'Chiều cao<br/><input type="text" size="14" id="image-height"/><br/>'
		+ 'Đường viền<br/><input type="text" size="14" id="image-border"/><br/>'
		+ 'Khoảng đệm ngang<br/><input type="text" size="14" id="image-hmargin"/><br/>'
		+ 'Khoảng đệm dọc<br/><input type="text" size="14" id="image-vmargin"><br/>'
		+ ' Vị trí<br/><select name="float" >'
		+ '<option selected="selected">none</option>'
		+ '<option>left</option>'
		+ '<option>right</option>'
		+ '</select>'
		+ '</td>'
		+'<td valign="top"><div id="div-pre">josafoofja òa à jafjaj jafasjfi aafoij ậ faij ậ jfafjaf aaif à afaf <br/>osjfsjofsofjsfsfsjofjs<br/>jsofsfs</div></td></tr></table>'
		+'</div>'
		+ '<div id="insert-hyperlink-tab">URL<br/><input name="url" id="url"/><input type="button" name="btnBrowser" id="btnBrowser" value="Duyet"/></div>'
		+'</div></form></div>').dialog({
			height: 500,
			width: 500,
			modal: true,
			buttons: {
				"Đồng ý": function() {
						
						tEditor.cm();
						tEditor.UI.focus();
						var alt = $("#image-alt").val();
						var wid = $("#image-width").val();
						var heigh = $("#image-height").val();
						var bord = $("#image-border").val();
						var hmarg = $("#image-hmargin").val();
						var vmarg = $("#image-vmargin").val();
						var _float = $("select option:selected").text();
						var float = "";
						if(_float=="none"){float = ""}
						else
							{
								float = ' float: '+ _float + ';';
							}
						var sr = $("#url1").val();
						//var aLink = $("#url1").val() + '' + ' style="width: 20px; height: 16px; border-width: 5px; border-style: solid; margin: 3px 4px; float: left;"';
						  //var aLink=(url==null)?popup('http://localhost/Zends/link.so1vn.vn/admin/filemanager'):url;
						var aLink = '<img alt="' + alt + '" src= "' + sr + '" style="width: ' + wid + 'px; height: ' + heigh + 'px; border-width: ' + bord + 'px; border-style: solid; margin: ' + vmarg + 'px ' + hmarg + 'px;' + float + '" />';   
						//aLink = $("#url1").val();
						
						if(aLink){
							//alert(aLink);
							//tEditor.fmt('InsertImage',  $("#url1").val());
							if(!isIE){
								tEditor.fmt('inserthtml',aLink);
								}
							else{
								var ig=tEditor.ed.selection.createRange();
								ig.select();
								ig.pasteHTML(aLink);
								}
					     
					      // alert(tEditor.getHTML());
		                $(this).dialog("close");
						}
				},
				"Bỏ qua": function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});
	});
	
	
	$('#image-info').live("click",function(){
		if($(this).attr('class') == 'active-tab')
			return false;
		else{
			$('#image-info-tab').show();
			$('#insert-hyperlink-tab').hide();
			$(this).attr('class','active-tab');
			$('#insert-hyperlink').attr('class','unactive-tab');
		}
		
		
	});
	$('#insert-hyperlink').live("click",function(){
		if($(this).attr('class') == 'active-tab')
			return false;
		else{
			$('#image-info-tab').hide();
			$('#insert-hyperlink-tab').show();
			$(this).attr('class','active-tab');
			$('#image-info').attr('class','unactive-tab');
		}
		
		
	});	
	$('#btnBrowser1').live("click",function(){
		
		var url = $('#url1').val();
		var aLink=window.open('http://localhost/Zends/link.so1vn.vn/admin/filemanager','name','height=500,width=600');
		opener.location.toLocaleString();
		opener.close();
		if (window.focus) {new_window.focus()}
		//alert(aLink);
		$('#url1').val(aLink); 
		
	});
	//
	$("#url1").live("change",function(){
		var alt = $("#image-alt").val();
		var wid = $("#image-width").val();
		var heigh = $("#image-height").val();
		var bord = $("#image-border").val();
		var hmarg = $("#image-hmargin").val();
		var vmarg = $("#image-vmargin").val();
		var _float = $("select option:selected").text();
		var float = "";
		if(_float=="none"){float = ""}
		else
			{
				float = ' float: '+ _float + ';';
			}
		var sr = $("#url1").val();
		//var aLink = $("#url1").val() + '' + ' style="width: 20px; height: 16px; border-width: 5px; border-style: solid; margin: 3px 4px; float: left;"';
		  //var aLink=(url==null)?popup('http://localhost/Zends/link.so1vn.vn/admin/filemanager'):url;
		var aLink = '<img alt="' + alt + '" src= "' + sr + '" style="width: ' + wid + 'px; height: ' + heigh + 'px; border-width: ' + bord + 'px; border-style: solid; margin: ' + vmarg + 'px ' + hmarg + 'px;' + float + '" />';   
		//aLink = $("#url1").val();
		aLink += "josafoofja òa à jafjaj jafasjfi aafoij ậ faij ậ jfafjaf aaif à afaf <br/>osjfsjofsofjsfsfsjofjs<br/>jsofsfs";
		//var url = $('#url1').val();
		$('#div-pre').html(aLink);
		//alert($("#div-pre").val());		
	}	
	);
	$("#image-alt").live("change",function(){
		var alt = $("#image-alt").val();
		var wid = $("#image-width").val();
		var heigh = $("#image-height").val();
		var bord = $("#image-border").val();
		var hmarg = $("#image-hmargin").val();
		var vmarg = $("#image-vmargin").val();
		var _float = $("select option:selected").text();
		var float = "";
		if(_float=="none"){float = ""}
		else
			{
				float = ' float: '+ _float + ';';
			}
		var sr = $("#url1").val();
		//var aLink = $("#url1").val() + '' + ' style="width: 20px; height: 16px; border-width: 5px; border-style: solid; margin: 3px 4px; float: left;"';
		  //var aLink=(url==null)?popup('http://localhost/Zends/link.so1vn.vn/admin/filemanager'):url;
		var aLink = '<img alt="' + alt + '" src= "' + sr + '" style="width: ' + wid + 'px; height: ' + heigh + 'px; border-width: ' + bord + 'px; border-style: solid; margin: ' + vmarg + 'px ' + hmarg + 'px;' + float + '" />';   
		//aLink = $("#url1").val();
		aLink += "josafoofja òa à jafjaj jafasjfi aafoij ậ faij ậ jfafjaf aaif à afaf <br/>osjfsjofsofjsfsfsjofjs<br/>jsofsfs";
		//var url = $('#url1').val();
		$('#div-pre').html(aLink);
		//alert($("#div-pre").val());		
	}	
	);
	$("#image-width").live("change",function(){
		var alt = $("#image-alt").val();
		var wid = $("#image-width").val();
		var heigh = $("#image-height").val();
		var bord = $("#image-border").val();
		var hmarg = $("#image-hmargin").val();
		var vmarg = $("#image-vmargin").val();
		var _float = $("select option:selected").text();
		var float = "";
		if(_float=="none"){float = ""}
		else
			{
				float = ' float: '+ _float + ';';
			}
		var sr = $("#url1").val();
		//var aLink = $("#url1").val() + '' + ' style="width: 20px; height: 16px; border-width: 5px; border-style: solid; margin: 3px 4px; float: left;"';
		  //var aLink=(url==null)?popup('http://localhost/Zends/link.so1vn.vn/admin/filemanager'):url;
		var aLink = '<img alt="' + alt + '" src= "' + sr + '" style="width: ' + wid + 'px; height: ' + heigh + 'px; border-width: ' + bord + 'px; border-style: solid; margin: ' + vmarg + 'px ' + hmarg + 'px;' + float + '" />';   
		//aLink = $("#url1").val();
		aLink += "josafoofja òa à jafjaj jafasjfi aafoij ậ faij ậ jfafjaf aaif à afaf <br/>osjfsjofsofjsfsfsjofjs<br/>jsofsfs";
		//var url = $('#url1').val();
		$('#div-pre').html(aLink);
		//alert($("#div-pre").val());		
	}	
	);
	$("#image-height").live("change",function(){
		var alt = $("#image-alt").val();
		var wid = $("#image-width").val();
		var heigh = $("#image-height").val();
		var bord = $("#image-border").val();
		var hmarg = $("#image-hmargin").val();
		var vmarg = $("#image-vmargin").val();
		var _float = $("select option:selected").text();
		var float = "";
		if(_float=="none"){float = ""}
		else
			{
				float = ' float: '+ _float + ';';
			}
		var sr = $("#url1").val();
		//var aLink = $("#url1").val() + '' + ' style="width: 20px; height: 16px; border-width: 5px; border-style: solid; margin: 3px 4px; float: left;"';
		  //var aLink=(url==null)?popup('http://localhost/Zends/link.so1vn.vn/admin/filemanager'):url;
		var aLink = '<img alt="' + alt + '" src= "' + sr + '" style="width: ' + wid + 'px; height: ' + heigh + 'px; border-width: ' + bord + 'px; border-style: solid; margin: ' + vmarg + 'px ' + hmarg + 'px;' + float + '" />';   
		//aLink = $("#url1").val();
		aLink += "josafoofja òa à jafjaj jafasjfi aafoij ậ faij ậ jfafjaf aaif à afaf <br/>osjfsjofsofjsfsfsjofjs<br/>jsofsfs";
		//var url = $('#url1').val();
		$('#div-pre').html(aLink);
		//alert($("#div-pre").val());		
	}	
	);
	$("#image-border").live("change",function(){
		var alt = $("#image-alt").val();
		var wid = $("#image-width").val();
		var heigh = $("#image-height").val();
		var bord = $("#image-border").val();
		var hmarg = $("#image-hmargin").val();
		var vmarg = $("#image-vmargin").val();
		var _float = $("select option:selected").text();
		var float = "";
		if(_float=="none"){float = ""}
		else
			{
				float = ' float: '+ _float + ';';
			}
		var sr = $("#url1").val();
		//var aLink = $("#url1").val() + '' + ' style="width: 20px; height: 16px; border-width: 5px; border-style: solid; margin: 3px 4px; float: left;"';
		  //var aLink=(url==null)?popup('http://localhost/Zends/link.so1vn.vn/admin/filemanager'):url;
		var aLink = '<img alt="' + alt + '" src= "' + sr + '" style="width: ' + wid + 'px; height: ' + heigh + 'px; border-width: ' + bord + 'px; border-style: solid; margin: ' + vmarg + 'px ' + hmarg + 'px;' + float + '" />';   
		//aLink = $("#url1").val();
		aLink += "josafoofja òa à jafjaj jafasjfi aafoij ậ faij ậ jfafjaf aaif à afaf <br/>osjfsjofsofjsfsfsjofjs<br/>jsofsfs";
		//var url = $('#url1').val();
		$('#div-pre').html(aLink);
		//alert($("#div-pre").val());		
	}	
	);
	$("#image-hmargin").live("change",function(){
		var alt = $("#image-alt").val();
		var wid = $("#image-width").val();
		var heigh = $("#image-height").val();
		var bord = $("#image-border").val();
		var hmarg = $("#image-hmargin").val();
		var vmarg = $("#image-vmargin").val();
		var _float = $("select option:selected").text();
		var float = "";
		if(_float=="none"){float = ""}
		else
			{
				float = ' float: '+ _float + ';';
			}
		var sr = $("#url1").val();
		//var aLink = $("#url1").val() + '' + ' style="width: 20px; height: 16px; border-width: 5px; border-style: solid; margin: 3px 4px; float: left;"';
		  //var aLink=(url==null)?popup('http://localhost/Zends/link.so1vn.vn/admin/filemanager'):url;
		var aLink = '<img alt="' + alt + '" src= "' + sr + '" style="width: ' + wid + 'px; height: ' + heigh + 'px; border-width: ' + bord + 'px; border-style: solid; margin: ' + vmarg + 'px ' + hmarg + 'px;' + float + '" />';   
		//aLink = $("#url1").val();
		aLink += "josafoofja òa à jafjaj jafasjfi aafoij ậ faij ậ jfafjaf aaif à afaf <br/>osjfsjofsofjsfsfsjofjs<br/>jsofsfs";
		//var url = $('#url1').val();
		$('#div-pre').html(aLink);
		//alert($("#div-pre").val());		
	}	
	);
	$("#image-vmargin").live("change",function(){
		var alt = $("#image-alt").val();
		var wid = $("#image-width").val();
		var heigh = $("#image-height").val();
		var bord = $("#image-border").val();
		var hmarg = $("#image-hmargin").val();
		var vmarg = $("#image-vmargin").val();
		var _float = $("select option:selected").text();
		var float = "";
		if(_float=="none"){float = ""}
		else
			{
				float = ' float: '+ _float + ';';
			}
		var sr = $("#url1").val();
		//var aLink = $("#url1").val() + '' + ' style="width: 20px; height: 16px; border-width: 5px; border-style: solid; margin: 3px 4px; float: left;"';
		  //var aLink=(url==null)?popup('http://localhost/Zends/link.so1vn.vn/admin/filemanager'):url;
		var aLink = '<img alt="' + alt + '" src= "' + sr + '" style="width: ' + wid + 'px; height: ' + heigh + 'px; border-width: ' + bord + 'px; border-style: solid; margin: ' + vmarg + 'px ' + hmarg + 'px;' + float + '" />';   
		//aLink = $("#url1").val();
		aLink += "josafoofja òa à jafjaj jafasjfi aafoij ậ faij ậ jfafjaf aaif à afaf <br/>osjfsjofsofjsfsfsjofjs<br/>jsofsfs";
		//var url = $('#url1').val();
		$('#div-pre').html(aLink);
		//alert($("#div-pre").val());		
	}	
	);
	$("select").live("change",function(){
		var alt = $("#image-alt").val();
		var wid = $("#image-width").val();
		var heigh = $("#image-height").val();
		var bord = $("#image-border").val();
		var hmarg = $("#image-hmargin").val();
		var vmarg = $("#image-vmargin").val();
		var _float = $("select option:selected").text();
		var float = "";
		if(_float=="none"){float = ""}
		else
			{
				float = ' float: '+ _float + ';';
			}
		var sr = $("#url1").val();
		//var aLink = $("#url1").val() + '' + ' style="width: 20px; height: 16px; border-width: 5px; border-style: solid; margin: 3px 4px; float: left;"';
		  //var aLink=(url==null)?popup('http://localhost/Zends/link.so1vn.vn/admin/filemanager'):url;
		var aLink = '<img alt="' + alt + '" src= "' + sr + '" style="width: ' + wid + 'px; height: ' + heigh + 'px; border-width: ' + bord + 'px; border-style: solid; margin: ' + vmarg + 'px ' + hmarg + 'px;' + float + '" />';   
		//aLink = $("#url1").val();
		aLink += "josafoofja òa à jafjaj jafasjfi aafoij ậ faij ậ jfafjaf aaif à afaf <br/>osjfsjofsofjsfsfsjofjs<br/>jsofsfs";
		//var url = $('#url1').val();
		$('#div-pre').html(aLink);
		//alert($("#div-pre").val());		
	}	
	);
	});
	
});	