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
  {
    icon: 'fa fa-cut', 
    label: 'Couper',  
    action: function(option, contextMenuIndex, optionIndex) { }, 
    submenu: null, 
    disabled: false 
  },
  {
    icon: 'fa fa-copy', 
    label: 'Copier', 
    action: function(option, contextMenuIndex, optionIndex) {},
    submenu: null,  
    disabled: false  
  },
  {
    icon: 'fa fa-eye', 
    label: 'Visualiser', 
    action: function(option, contextMenuIndex, optionIndex) {viewMedia();},
    submenu: null,  
    disabled: false  
  },
  {
    icon: 'fa fa-download', 
    label: 'Telecharger', 
    action: function(option, contextMenuIndex, optionIndex) {},
    submenu: null,  
    disabled: false  
  },
  {
    icon: 'fa fa-clone', 
    label: 'Dupliquer', 
    action: function(option, contextMenuIndex, optionIndex) {},
    submenu: null,  
    disabled: false  
  },
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
    action: function(option, contextMenuIndex, optionIndex) {},
    submenu: null,  
    disabled: false  
  },

  {
    //Menu separator
    separator: true   
  },
  {
    icon: 'fa fa-share', 
    label: 'Social Share', 
    action: function(option, contextMenuIndex, optionIndex) {},
    submenu: [{ // sub menus
      icon: 'fa fa-facebook',  
      label: '<a href="https://www.jqueryscript.net/tags.php?/Facebook/">Facebook</a>',  
      action: function(option, contextMenuIndex, optionIndex) {}, 
      submenu: null,  
      disabled: false  
    },
    {
      icon: 'fa fa-<a href="https://www.jqueryscript.net/tags.php?/twitter/">twitter</a>',  
      label: 'Twitter', 
      action: function(option, contextMenuIndex, optionIndex) {}, 
      submenu: null,  
      disabled: false  
    },
    {
      icon: 'fa fa-google-plus',
      label: 'Google Plus',  
      action: function(option, contextMenuIndex, optionIndex) {}, 
      submenu: null,  
      disabled: false  
    }], 
    disabled: false
  },
];

$('.media').on('contextmenu', function(e) {
  e.preventDefault();
  var existingClass=$(this).attr('class');
  $(this).attr('class', existingClass+' '+'context-menu-active');
  superCm.createMenu(myMenu, e);

});

function openMedia(){
  var contextMenuActive=$('.context-menu-active').attr('id');
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
        var contextMenuActive=$('.context-menu-active').attr('id');
         $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route('media.delete',[contextMenuActive]),
        dataType : 'html',
        // data: contextMenuActive,
        contentType: false, 
        processData: false,
        success:function(response) {alert('Supprimé')}
      });   
          $('.context-menu-active').remove();

              superCm.destroyMenu();
      }

      function renameMedia(){
        var contextMenuActive=$('.context-menu-active').attr('id');
        $('.rename-folder-form > form').attr('class','');
        $('.oldName').val(contextMenuActive);
        superCm.destroyMenu();
      }

      function viewMedia(){
        var contextMenuActive=$('.context-menu-active').attr('id');
        var src=$('.context-menu-active > img').attr('src');
        alert(src);
        superCm.destroyMenu();
      }
});