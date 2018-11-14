$( ".datepicker" ).datepicker(
    {
      monthNames: [ "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Decembre" ],
      monthNamesShort: [ "Jan", "Féb", "Mar", "Avr", "Mai", "Jui", "Juil", "Aoû", "Sep", "Oct", "Nov", "Dec" ],
      dayNames: [ "Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi" ],
      dayNamesMin: [ "Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ],
      dateFormat: "dd-mm-yy 00:00:00",
      nextText: "suivant",
      prevText: "précédent",
      showButtonPanel: true,
      currentText: "Aujourd'hui",
      closeText: "Fermer"
    });