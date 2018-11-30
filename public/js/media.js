$(document).ready(function() {

$('.display-type').on('click',function(){
var element=$(this).attr('id');
displayType(element);
  });

function displayType (element){
if (element == 'liste'){
$('#media-container').attr('class','media-container');
$('.media > div').attr('class','uk-display-inline');
$('.image-icon').attr('width','25px');

}else{
$('#media-container').attr('class','media-container uk-grid');
$('.media > div').attr('class','');
$('.image-icon').attr('width','45px');
};
$('.racine').attr('class','racine uk-display-block uk-margin-small-bottom');

}

displayType($('li.display-type.uk-active').attr('id'));
 $(".folder").click(function(){
      var mediaId=$.trim($(this).attr('id')); 
        $.get(route('media.open',['folder']).replace('folder',mediaId), function(data, status){
            $('#media-container').html(data);
        });
            

          }); 
        
});