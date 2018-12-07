$(document).ready(function() {
	var editor = new Jodit('#fulltext');
$('.jodit_wysiwyg,#title,#introtext').on('keyup input click',function(e){
loadIframeContent();
 });

 	$('.jodit_toolbar').on('click',function(e){
 		loadIframeContent();
 	});	
function loadIframeContent(){
	var title='<h2>'+ $('#title').val() +'</h2>';
	var introtext='<div>'+  $('#introtext').val() +'</div>';
   	var html =title + introtext + $("#fulltext").val();
    var iframe = document.getElementById("previewIframe");
    iframe.src = 'data:text/html;charset=utf-8,' + encodeURI(html);
}; loadIframeContent();
});