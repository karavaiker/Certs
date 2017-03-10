/*$(document).ready(function(){

	$("a[rel='gal']").colorbox({opacity:0.5, scalePhotos:true, maxWidth:"90%", maxHeight:"90%", current:"{current} / {total}", slideshow:true, slideshowAuto:false, slideshowStart:"начать слайдшоу", slideshowStop:"остановить слайдшоу"});
	
	$("a.gal").colorbox({opacity:0.5, scalePhotos:true, maxWidth:"90%", maxHeight:"90%", current:"{current} / {total}", slideshow:false, slideshowAuto:false, slideshowStart:"", slideshowStop:""});
	
});*/
$(document).ready(function () {
	theRotator();
	
	$(function() {   
        var theWindow = $(window),
            $bg = $("#bg"),
            aspectRatio = $bg.width() / $bg.height();
        function resizeBg() {
                if ( (theWindow.width() / theWindow.height()) < aspectRatio ) {
                    $bg
                        .removeClass()
                        .addClass('bgheight');
                } else {
                    $bg
                        .removeClass()
                        .addClass('bgwidth');
                }
        }
        theWindow.resize(function() {
                resizeBg();
        }).trigger("resize");
	});
	
	$("#bg").height($('#main').height()+60);
			
});// end ready

// визуал
function theRotator() {
	$('div.visualImage ul li').css({opacity: 0}).hide();
	$('div.visualImage ul li.show').css({opacity: 1}).show();
	rotateVar = setInterval('rotate()',5000)	
}
var current = "";
var next = "";
var visualhideVar;
function rotate() {	
	clearInterval(rotateVar);
	current = $('div.visualImage ul li.show');
	next = ((current.next().length) ? current.next() : $('div.visualImage ul li:first'));	
	
	if (!(current.next().length)) {
		next.addClass('show').show().css({zIndex:2}).animate({opacity:1},800);
	} else {
		next.addClass('show').show().animate({opacity:1},800);
	}
 
	visialhideVar = setInterval('visual_hide()',800);
};

function visual_hide() { 
	clearInterval(visialhideVar);
	next.css({zIndex:1})
	current.removeClass('show').css({opacity: 0}).hide();
	rotateVar = setInterval('rotate()',5000)
}

// Реактив

var ShowReaktiveFlag = false;

function ShowReaktiveStart(){ ShowReaktiveFlag = true; setTimeout("ShowReaktive()",50); }
function ShowReaktive(){
	if ((ShowReaktiveFlag) && ($("#reaktive_block").css('display')=='none')){
		$("#reaktive_block").css({display: "block"});
		$("#reaktive_block IMG").css({width: 0, height: 0, left: 75, top: 50});
		$("#reaktive_block IMG").animate({width: 274, height: 131, left:-5, top: -60}, 300);
	}
}

function HideReaktiveStart(){ ShowReaktiveFlag = false; setTimeout("HideReaktive()",50); }
function HideReaktive(){
	if ((!ShowReaktiveFlag) && ($("#reaktive_block").css('display')!='none')){
		if ($.browser.msie) $("#reaktive_block").css('display','none');
		else $("#reaktive_block").fadeOut(300);
	}
}
function trim(s){
	return 	s.replace(/^(\s*)/,"$`").replace(/(\s*)$/,"$'");
}
function	SendTheFeed(frm){
	var phoneobj = $("#"+frm.id+" #phone");
	var waitobj = $("#"+frm.id+" #wait");
	var buttobj = $("#"+frm.id+" #mail-send");
	var sentobj = $("#"+frm.id+" #mail-sent");
	var errobj = $("#"+frm.id+" #err");
	var phone = trim(frm.elements.namedItem("phone").value);
	if (phone==''){
		$(waitobj).hide();
		$(sentobj).hide();
		$(errobj).show();
		return false; 
	}
/*	phone = phone.replace(' ', '');	
	phone = phone.replace(' ', '');	
	phone = phone.replace(' ', '');	
	phone = phone.replace(' ', '');	
	phone = phone.replace('-', '');	
	phone = phone.replace('-', '');	
	phone = phone.replace('-', '');	
	phone = phone.replace('(', '');	
	phone = phone.replace(')', '');	
	phone = phone.replace('+', '');	
	var intphone = parseInt(phone);
	if (isNaN(intphone)) {
		$(waitobj).hide();
		$(sentobj).hide();
		$(errobj).show();
		return false; 
	} else {	
		if (intphone<70000000000 || intphone>=90000000000){
			$(waitobj).hide();
			$(sentobj).hide();
			$(errobj).show();
			return false; 
		} else if (intphone>=80000000000) {
			intphone = intphone-10000000000;
		}
	}
	phone = ""+intphone;
*/
	var date=new Date();
	$(phoneobj).hide();
	$(buttobj).hide();
	$(sentobj).hide();
	$(errobj).hide();
	$(waitobj).show();
	requrl = "/inc/sendmail.php?phone="+phone+"&uniq="+date.getTime();
//alert(requrl);
	$.ajax({
		url: requrl,
		success: function(data) {
			$(buttobj).hide();
			$(waitobj).hide();
			$(sentobj).show();
			$(errobj).hide();
		}
	});
}