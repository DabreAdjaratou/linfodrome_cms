$(document).ready(function() {
$(function () {
    // create an instance when the DOM is ready
    $('#jstree').jstree();
    // bind to events triggered on the tree
    $('#jstree').on("changed.jstree", function (e, data) {
      var media=$.parseHTML(data.node.text);
      var mediaId=media[0].id;
      var urlToLoad=route('media-to-load',['folder']).replace('folder',mediaId);
      $.get(urlToLoad, function(data, status){
            $('#mediaContainer').html(data);
        });
    });

   });

});