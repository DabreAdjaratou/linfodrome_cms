 $(document).ready(function() {

// $('#dataTable').DataTable({
//   "paging":   false,
//         "ordering": false,
//         "info":     false,
//         "searching": false,
//         responsive: true
// });

/**
*
*search and sort the table
*@param $tring sortField
*@return Illuminate\Http\response
*/
    function searchAndSort(sortField){

      var entries="";
      var searchByTitle="";
      var searchByCategory="";
      var searchByFeaturedState="";
      var searchByPublishedState="";
      var searchByUser="";
      var fromDate="";
      var toDate="";
      var order=$('#order').val();
      var itemType=$('#itemType').val();
      
      if($('#entries')){entries=$('#entries').val();};
      if($('#searchByTitle')){searchByTitle=$('#searchByTitle').val();};
      if($('#searchByCategory')){searchByCategory=$('#searchByCategory').val();};
      if($('#searchByFeaturedState')){searchByFeaturedState=$('#searchByFeaturedState').val();};
      if($('#searchByPublishedState')){searchByPublishedState=$('#searchByPublishedState').val();};
      if($('#searchByUser')){searchByUser=$('#searchByUser').val();};
      if($('#fromDate')){fromDate=$('#fromDate').val();};
      if($('#toDate')){toDate=$('#toDate').val();};
      
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

/**
*
*sort the table
*@param $tring sortField
*@return 
*/
function tableSort (){

    $('.tableSort').on('click',function(e){
      e.preventDefault();
      var sortField=e.target.id;
      var order=$('#order').val();
      searchAndSort(sortField);  
      var url=window.location.href;
         
      if(order=='asc'){
// $('.tableSort > i').attr('class','fas fa-sort uk-margin-left');
// $("#"+sortField+' > i').attr('class','fas fa-sort-up uk-margin-left');
        $('#order').val('desc')
      }
      if (order=='desc') {
// $('.tableSort > i').attr('class','fas fa-sort uk-margin-left');
// $("#"+sortField+' > i').attr('class','fas fa-sort-down uk-margin-left');
       $('#order').val('asc')
     }
changeUrl(url)
   });
  };tableSort();
  
/**
*
*set url of a page 
*@param $tring url
*@return Illuminate\Http\response
*/
function changeUrl(url)
{
  var newUrl=url.split('?');
 window.history.pushState("data","Title",newUrl[0]);
 document.title=newUrl[0];
}

// jquery plugin select2
    $("#searchByUser").select2();
  });

