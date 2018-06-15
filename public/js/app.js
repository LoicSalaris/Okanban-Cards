var app = {
    init: function(){
        // On récupère directement nos listes
        app.getLists();
        // Ecouteur sur list-add
        $('#list-add').on('click', app.createList);
        // Délégation, cf http://api.jquery.com/on/ tout en bas
        // Ecouteur sur le bouton edit list (icone edit)
        $('body').on('click', '.list .form-display', app.displayFormEdit);
        // Ecouteur sur les formulaires d'edit listes
        $('body').on('submit', '.list .form-edit', app.submitFormEdit);
    },
    displayFormEdit: function(){
        // https://learn.jquery.com/using-jquery-core/traversing/
        // On sélectionne le formulaire associé, qui est le sibling du parent
        var $form = $(this).parent().next();
        $form.show();
        // On masque le h3
        var $h3 = $(this).parent();
        $h3.hide();
    },
    submitFormEdit: function(e){
        // On récupère l'événement et on invalide son fonctionnement par défaut
        e.preventDefault();
        console.log($(this));
        // Accéder un élément "à la main"
        // var name = $('input[name="name"]', $(this)).val();
        // Avec serialize, qui nous renvoie : name=DoingDoing&id=6
        var formData = $(this).serialize();
        console.log(formData);
        // Requête d'update
        $.ajax('list/update', {
            // dataType: 'json',
            method: 'POST',
            data: formData
        })
        // Réponse
        .done(function(data) {
            console.log(data);
            // Si success
            // Sélectionne la liste concernée via Sélecteur balise + attribut
            var $list = $('div[data-list-id="' + data.id + '"]');
            // Si succès
            if(data.success) {
                // On met à jour le h3
                $('.title', $list).text(data.name);
            }
            // On masque le form et on affiche le h3
            $('.form-edit', $list).hide();
            $('h3', $list).show();
        });
    },
    createList: function() {
        var listName = prompt('Nom de la liste ?');
        // Si nom vide
        if(!listName) {
            return;
        }
        // On crée un objet XHR
        // Requête
        $.ajax('list/create', {
            dataType: 'json',
            method: 'POST',
            data: {
                name: listName
            }
        })
        // Réponse
        .done(function(data) {
            console.log(data);
            // On peut ici manipuler notre objet data en JS...
            if(data.id) {
                app.displayList(data);
            }
        });
    },
    displayList: function(listData) {
        // Aller chercher le template
        $.ajax('tpl/list.html', {
            dataType: 'html'
        })
        .done(function(response){
            // Convertit le template lu, en objet jQuery
            var $tpl = $(response);
            // On injecte les données reçues en paramètre
            // data-list-id
            $tpl.attr('data-list-id', listData.id);
            // texte du h3
            $('.title', $tpl).text(listData.name);
            // valeur du champ texte
            $('.name', $tpl).val(listData.name);
            // valeur du champ caché
            $('.id', $tpl).val(listData.id);
            // Insertion avant le bouton nouvelle liste
            $('#list-add').before($tpl);
        });
    },
    getLists: function(){
        // On crée un objet XHR
        $.ajax('list/get/all', {
            // dataType: 'json'
        })
        .done(function(data) {
            console.log(data);
            // On peut ici manipuler notre objet data en JS...
        })
        .fail(function() {
            console.log('fail');
            alert('Système cassé :/');
        });
    },
}

// Quand le DOM et son contenu est chargé, on éxécute app.init
$(app.init());
