var myMenu = [{

    // Menu Icon. 
    // This example uses Font Awesome Iconic Font.
    icon: 'fa fa-folder-open',   

    // Menu Label
    label: 'Ouvrir', 

    // Callback
    action: function(option, contextMenuIndex, optionIndex) {}, 

    // An array of submenu objects
    submenu: null,

    // is disabled?
    disabled: false   //Disabled status of the option
},
  {
    icon: 'fa fa-cut', 
    label: 'Couper',  
    action: function(option, contextMenuIndex, optionIndex) { alert()}, 
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
    action: function(option, contextMenuIndex, optionIndex) {},
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
    action: function(option, contextMenuIndex, optionIndex) {},
    submenu: null,  
    disabled: false  
  },
  {
    icon: 'fa fa-trash-alt', 
    label: 'Supprimer', 
    action: function(option, contextMenuIndex, optionIndex) {},
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
  superCm.createMenu(myMenu, e);

});