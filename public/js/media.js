$('.displayType').on('click',function(){
var element=$(this).attr('id');
displayType(element);
  });

function displayType (element){
if (element == 'liste'){
$('#mediaContainer').attr('class','mediaContainer');
$('.media > div').attr('class','uk-display-inline');
$('.imageIcon').attr('width','15px');

}else{
$('#mediaContainer').attr('class','mediaContainer uk-grid');
$('.media > div').attr('class','');
$('.imageIcon').attr('width','45px');

};
}

displayType($('li.displayType.uk-active').attr('id'));
 $(".folder").click(function(){
      var mediaId=$.trim($(this).attr('id')); 
        $.get(route('media-to-load',['folder']).replace('folder',mediaId), function(data, status){
            $('#mediaContainer').html(data);
        });
          }); 
        
