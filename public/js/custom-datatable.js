
$(document).ready(function() {
    
$('#dataTable').DataTable({
	"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
	"language": {
            "lengthMenu": "Affiché _MENU_ lignes",
            "zeroRecords": "Aucun donnée correspondant - desolé",
           "info": "Affichage de _START_ à _END_ sur _TOTAL_ entries",
           "infoEmpty": "Affichage de 0 à  0 sur 0 entries",
            "infoEmpty": "Aucun resultat disponible",
            "infoFiltered": "",
            "search":         "Recherche:",

        },
        "columnDefs": [
        { "orderable": false, "targets": [2,3] },
         { "searchable": false, "targets" : [2,3] 
                },

  ]
				 }); 

 }); 
 