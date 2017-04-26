


var content_size = $("#main").height()+$("#menu").height();

function show_full_menu () {
	$("#menu").hide('fast', function() { $("#full_menu").slideDown('slow'); } );

}

function hide_full_menu () {
	$("#full_menu").slideUp('fast', function() { $("#menu").show('slow'); } );
}

function hide_menu () {
	$("#menu").hide('slow');
}
function show_menu () {
	$("#menu").show('slow');
}

$(document).ready(function() {
	$('#main').show('slow', function () {
		$("#menu").show(1000).css('display','table');
		resize_w2ui();
		if($('#volunteer_form').length > 0){
			w2ui['volunteer_form'].resize();
			content_size = $("#main").height()+$("#menu").height();
		}
	} ).css('display','table');
});

function reload_page() {

	$("#menu").hide();
	$("#main").hide();
	$('#main').show('slow', function () {
		if($( window ).height() >= screen.height*0.75){
			$("#menu").show('slow').css('display','table');
		}		
		resize_w2ui();
	}).css('display','table');

}

function resize_w2ui() {

	$.each(w2ui,function(k1,v1){
	  $.each(v1.box.classList,function(k2,v2){
		if(v2=='w2ui-form'){
		  v1.resize();
		}
	  });
	});

	if(w2popup.status=='open'){
		w2popup.resize(Math.min(screen.width,Math.max(500,$('#w2ui-popup').width()+2)),Math.min(screen.height,Math.max(300,$('#w2ui-popup').height()+2)),function(){
			$.each(w2ui,function(k1,v1){
			  $.each(v1.box.classList,function(k2,v2){
				if(v2=='w2ui-form'){
				  v1.resize();
				}
			  });
			});
		});	
	}                   

}

window.addEventListener("orientationchange", reload_page);
window.addEventListener("resize", reload_page);
