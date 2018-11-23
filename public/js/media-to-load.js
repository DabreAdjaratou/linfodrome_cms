 $(".folder").click(function(){
      var mediaId=$.trim($(this).attr('id')); 
        $.get(route('media-to-load',['folder']).replace('folder',mediaId), function(data, status){
            $('#mediaContainer').html(data);
        });
    }); 
        
