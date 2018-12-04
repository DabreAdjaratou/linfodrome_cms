/*
*
*  https://github.com/pwnedgod/supercontextmenu
*
*/

$(document).ready(function() {
  var myMenu = [{

    // Menu Icon. 
    // This example uses Font Awesome Iconic Font.
    icon: 'fa fa-folder-open',   

    // Menu Label
    label: 'Ouvrir', 

    // Callback
    action: function(option, contextMenuIndex, optionIndex) { openMedia(); }, 

    // An array of submenu objects
    submenu: null,

    // is disabled?
    disabled: false   //Disabled status of the option
  },
  // {
  //   icon: 'fa fa-cut', 
  //   label: 'Couper',  
  //   action: function(option, contextMenuIndex, optionIndex) { }, 
  //   submenu: null, 
  //   disabled: false 
  // },
  // {
  //   icon: 'fa fa-copy', 
  //   label: 'Copier', 
  //   action: function(option, contextMenuIndex, optionIndex) {},
  //   submenu: null,  
  //   disabled: false  
  // },
  {
    icon: 'fa fa-eye', 
    label: '<a href="#modal-image" >Visualiser</a>',
    action: function(option, contextMenuIndex, optionIndex) {viewMedia();},
    submenu: null,  
    disabled: false  
  },
  // {
  //   icon: 'fa fa-download', 
  //   label: 'Telecharger', 
  //   action: function(option, contextMenuIndex, optionIndex) {downloadMedia();},
  //   submenu: null,  
  //   disabled: false  
  // },
  // {
  //   icon: 'fa fa-clone', 
  //   label: 'Dupliquer', 
  //   action: function(option, contextMenuIndex, optionIndex) {},
  //   submenu: null,  
  //   disabled: false  
  // },
  {
    icon: 'fa fa-edit', 
    label: 'Renommer', 
    action: function(option, contextMenuIndex, optionIndex) { renameMedia();},
    submenu: null,  
    disabled: false  
  },
  {
    icon: 'fa fa-trash-alt', 
    label: 'Supprimer', 
    action: function(option, contextMenuIndex, optionIndex) { deleteMedia();},
    submenu: null,  
    disabled: false  
  },
  {
    icon: 'fa fa-info-circle', 
    label: 'propriétés', 
    action: function(option, contextMenuIndex, optionIndex) { mediaProperties();},
    submenu: null,  
    disabled: false  
  },

  // {
  //   //Menu separator
  //   separator: true   
  // },
  // {
  //   icon: 'fa fa-share', 
  //   label: 'Social Share', 
  //   action: function(option, contextMenuIndex, optionIndex) {},
  //   submenu: [{ // sub menus
  //     icon: 'fa fa-facebook',  
  //     label: '<a href="https://www.jqueryscript.net/tags.php?/Facebook/">Facebook</a>',  
  //     action: function(option, contextMenuIndex, optionIndex) {}, 
  //     submenu: null,  
  //     disabled: false  
  //   },
  //   {
  //     icon: 'fa fa-<a href="https://www.jqueryscript.net/tags.php?/twitter/">twitter</a>',  
  //     label: 'Twitter', 
  //     action: function(option, contextMenuIndex, optionIndex) {}, 
  //     submenu: null,  
  //     disabled: false  
  //   },
  //   {
  //     icon: 'fa fa-google-plus',
  //     label: 'Google Plus',  
  //     action: function(option, contextMenuIndex, optionIndex) {}, 
  //     submenu: null,  
  //     disabled: false  
  //   }], 
  //   disabled: false
  // },
  ];

  $('.media').on('contextmenu', function(e) {
    e.preventDefault();
    var existingClass=$(this).attr('class');
    $(this).attr('class', existingClass+' '+'context-menu-active');
    superCm.createMenu(myMenu, e);

  });

  function openMedia(){
    var contextMenuActive=$('.context-menu-active').last().attr('id');
    if($('.context-menu-active').hasClass('folder')){

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route('media.open',[contextMenuActive]),
        dataType : 'html',
        type: 'POST',
        data:contextMenuActive,
        contentType: false, 
        processData: false,
        success:function(response) {
          $('#media-container').html(response);
        }
      });   
    }
    superCm.destroyMenu();
  };

  function deleteMedia(){
      // var confirmation = comfirm('Êtes vous bien sûre de vouloir supprimer cet élément ?');
      var contextMenuActive=$('.context-menu-active').last().attr('id');
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route('media.delete',[contextMenuActive]),
        dataType : 'text',
        // data: contextMenuActive,
        contentType: false, 
        processData: false,
        success:function(response) {
          if($('.uk-alert')){
            $('.uk-alert').remove();
          }
          $('#alert').html(response);
          $('.context-menu-active').remove();
        }
      });   

      superCm.destroyMenu();
    }

    function renameMedia(){
      var contextMenuActive=$('.context-menu-active').last().attr('id');
      $('.rename-folder-form > form').attr('class','');
      $('.oldName').val(contextMenuActive);
      superCm.destroyMenu();
    }

    function viewMedia(){
      var src=$('.context-menu-active > img').attr('src');
      if($('.context-menu-active').hasClass('files')){
       UIkit.modal.dialog('<div class="uk-modal-body"><button class="uk-modal-close-outside" type="button" uk-close></button><img  class="uk-width-auto uk-margin-auto-vertical" src="'+src+'" alt="" max-width="150px" ></div>');
     }
     superCm.destroyMenu();
   }

   function mediaProperties(){
    var src=$('.context-menu-active > img').attr('src');
    var contextMenuActive=$('.context-menu-active').last().attr('id');
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route('media.properties',[contextMenuActive]),
        dataType : 'text',
        // data: contextMenuActive,
        contentType: false, 
        processData: false,
        success:function(response) {
          response=JSON.parse(response);
           UIkit.modal.dialog('<div class="uk-modal-body"><button class="uk-modal-close-outside" type="button" uk-close></button><img  class="uk-width-auto uk-margin-auto-vertical" width="45px" src="'+src+'" alt="" >'
              +'<p>Nom: '+response.name+'</p><p>type : '+response.type+'</p><p>Taille : '+response.size+'</p><p>Dimension : '+response.dimension+' </p> <p>Path : '+response.path+' </p><p>Derniere modification : '+response.lastModified+'</p></div>');
        }
      });   
      superCm.destroyMenu();
    
        }

      //   function downloadMedia(){
      // var contextMenuActive=$('.context-menu-active').last().attr('id');
      // $.ajax({
      //   headers: {
      //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //   },
      //   url: route('media.download',[contextMenuActive]),
      //   dataType : 'text',
      //   // data: contextMenuActive,
      //   contentType: false, 
      //   processData: false,
      //   success:function(response) {
      //    }
      // });   
      // superCm.destroyMenu();
      //       } 
      });