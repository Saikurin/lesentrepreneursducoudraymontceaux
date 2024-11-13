import {Controller} from "@hotwired/stimulus";
import Datatable from 'datatables.net';

export default class extends Controller {
    static values = {
        order: {type: Array, default: [[0, 'asc']]},
        id: String
    }

    connect() {
        this.initDatatable();
    }

    initDatatable() {
        console.log(this.idValue);
        this.dataTable = $("#" + this.idValue).DataTable({
            order: this.orderValue, // Ordre initial
            responsive: true,
            searching: false,
            language: {
                "decimal":        "",
                "emptyTable":     "Aucune donnée disponible dans le tableau",
                "info":           "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                "infoEmpty":      "Affichage de 0 à 0 sur 0 entrées",
                "infoFiltered":   "(filtré à partir de _MAX_ entrées au total)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Afficher _MENU_ entrées",
                "loadingRecords": "Chargement...",
                "processing":     "Traitement...",
                "search":         "Rechercher:",
                "zeroRecords":    "Aucun enregistrement correspondant trouvé",
                "paginate": {
                    "first":      "Premier",
                    "last":       "Dernier",
                    "next":       "Suivant",
                    "previous":   "Précédent"
                },
                "aria": {
                    "sortAscending":  ": activer pour trier la colonne par ordre croissant",
                    "sortDescending": ": activer pour trier la colonne par ordre décroissant"
                }
            },
            pageLength: 10,
            bLengthChange: false
        });
        this.dataTable.draw();
    }

    reload() {
        this.dataTable.ajax.reload();
    }

    disconnect() {
        if(this.dataTable) {
            this.dataTable.destroy();
        }
    }
}