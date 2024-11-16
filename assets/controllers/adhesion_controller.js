import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    static values = {
        url: String,
        method: String,
        confirm: String,
        success: String,
        refuse: String,
        error: String,
        refusesuccess:String
    }

    async validateAdhesion(event) {
        // Récupère l'ID de la demande depuis l'attribut `data-id` du bouton cliqué
        const id = $(event.currentTarget).data("id");

        // Affiche la boîte de confirmation avant d'envoyer la requête
        if (!confirm(this.confirmValue)) return;

        try {
            // Envoie de la requête AJAX
            await $.ajax({
                url: this.urlValue,
                type: this.methodValue,
                data: {id: id, type: 'accept'},
            });

            // Modifie le bouton si la requête a réussi
            const $button = $(event.currentTarget);
            $button.removeClass("btn-outline-success").addClass("btn-success");

            // Affiche un message de succès
            alert(this.successValue);
        } catch (error) {
            // Affiche un message d'erreur en cas d'échec
            alert(this.errorValue);
        }
    }

    async refuseAdhesion(event) {
        // Récupère l'ID de la demande depuis l'attribut `data-id` du bouton cliqué
        const id = $(event.currentTarget).data("id");

        // Affiche la boîte de confirmation avant d'envoyer la requête
        if (!confirm(this.refuseValue)) return;

        try {
            // Envoie de la requête AJAX
            await $.ajax({
                url: this.urlValue,
                type: this.methodValue,
                data: {id: id, type: 'refuse'},
            });

            // Modifie le bouton si la requête a réussi
            const $button = $(event.currentTarget);
            $button.removeClass("btn-outline-danger").addClass("btn-danger");

            // Affiche un message de succès
            alert(this.refusesuccessValue);
        } catch (error) {
            // Affiche un message d'erreur en cas d'échec
            alert(this.errorValue);
        }
    }
}
