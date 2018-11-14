 $(document).ready(function() {

$('#dataTable').DataTable({
  "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false,
        responsive: true
});
    function searchAndSort(sortField){
      var entries=$('#entries').val();
      var searchByTitle=$('#searchByTitle').val();
      var searchByCategory=$('#searchByCategory').val();
      var searchByFeaturedState=$('#searchByFeaturedState').val();
      var searchByPublishedState=$('#searchByPublishedState').val();
      var searchByUser=$('#searchByUser').val();
      var order=$('#order').val();
      var fromDate=$('#fromDate').val();
      var toDate=$('#toDate').val();
      var itemType=$('#itemType').val();
if(itemType=='articles' || itemType=='article-trash' || itemType=='article-draft'){
    var routeUrl=route('articles.search-and-sort');
};
if (itemType=='article-archives'|| itemType=='article-archive-trash' || itemType=='article-archive-draft' ) {
    var routeUrl=route('article-archives.search-and-sort');
};

if(itemType=='billets' || itemType=='billet-trash' || itemType=='billet-draft'){
    var routeUrl=route('billets.search-and-sort');
};
if (itemType=='billet-archives'|| itemType=='billet-archive-trash' || itemType=='billet-archive-draft' ) {
    var routeUrl=route('billet-archives.search-and-sort');
};

if(itemType=='videos' || itemType=='video-trash' || itemType=='video-draft'){
    var routeUrl=route('videos.search-and-sort');
};
if (itemType=='video-archives'|| itemType=='video-archive-trash' || itemType=='video-archive-draft' ) {
    var routeUrl=route('video-archives.search-and-sort');
};





      var data= '{"entries":"'+ entries + '","searchByTitle":"'+ searchByTitle + '","searchByCategory":"'+ searchByCategory + '","searchByFeaturedState":'+ searchByFeaturedState + ',"searchByPublishedState":'+ searchByPublishedState + ',"searchByUser":"'+ searchByUser + '","sortField":"'+ sortField+'","order":"'+ order+'","fromDate":"'+ fromDate+'","toDate":"'+ toDate+'","itemType":"'+ itemType+'"}'; 
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: routeUrl,
        dataType : 'html',
        type: 'POST',
        data: data,
        contentType: false, 
        processData: false,
        success:function(response) {
          $('#tableContainer').html(response);
          tableSort();
        }
      });   

    };

    $('.searchValue').on('change',function(e){
      e.preventDefault();
      searchAndSort(sortField='id');        

    });

    $('#searchButton').on('click',function(e){
      e.preventDefault();
      searchAndSort(sortField='id');        

    });

function tableSort (){

    $('.tableSort').on('click',function(e){
      e.preventDefault();
      var sortField=e.target.id;
      var order=$('#order').val();
      searchAndSort(sortField);        
      if(order=='asc'){
        $('#order').val('desc')
      }
      if (order=='desc') {
       $('#order').val('asc')
     }
   });
  };tableSort();
    $("#searchByUser").select2();
  });