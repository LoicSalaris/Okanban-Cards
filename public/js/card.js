// Objet de l'appli qui va gérer les cartes
var card = {
    init: function(){
        console.log('cards init');
        // Sur ajout carte
        // Délégation, cf http://api.jquery.com/on/ tout en bas
        // Ajout de carte
        $('body').on('click', '.card-add', card.create);
        // Suppression de carte
        $('body').on('click', '.card-delete', card.delete);
        // On chercher nos cartes en AJAX
        card.getAll();
        // Sortable
        $(".list").sortable({
            placeholder: "card-placeholder",
            stop: function(event, ui) {
                var $list = $(ui.item).parent();
                card.saveCardsOrderFromList($list);
            }
        });
        $(".list").disableSelection();
    },
    saveCardsOrderFromList: function($list){
        // On souhaite constituer la liste des cartes de la liste
        // et envoyer cette liste avec l'id de la liste
        console.log($list);
        var listId = $list.data('list-id');
        // Objet qui va contenir nos cards
        var cardsList = [];
        // Parcours des enfants .card de la liste concernée
        $('.card', $list).each(function(index, cardElement) {
            // On va pusher les id des cards dans un tableau
            var cardId = $(cardElement).data('card-id');
            cardsList[index] = cardId;
        });
        console.log(cardsList);
        // Objet à envoyer
        var dataList = {
            list_id: listId,
            cards: cardsList
        };
        // On envoie
        $.ajax('card/update/order', {
            method: 'POST',
            data: dataList
        })
        .fail(function() {
            console.log('fail');
            alert('Système cassé :/');
        });
    },
    delete: function(){
        var ok = confirm('Supprimer la carte ?');
        // Si nom vide
        if(!ok) {
            return;
        }
        // On récupère l'id de la carte
        var cardId = $(this).parent().data('card-id');
        // On va appeler une URL de la forme /card/delete/2
        $.ajax('card/delete/' + cardId, {
            method: 'POST'
        })
        .done(function(data){
            // Si carte supprimée en back
            if(data.id) {
                // On supprime la carte du DOM, via son data-card-id
                var $card = $('div[data-card-id="' + data.id + '"]');
                $card.remove();
            }
        });
    },
    getAll: function(){
        // On crée un objet XHR
        $.ajax('card/get/all')
        .done(function(data) {
            console.log(data);
            // On peut ici manipuler notre objet data en JS...
            $.each(data, function(index, cardData){
                console.log(cardData);
                card.displayCard(cardData);
            });
        })
        .fail(function() {
            console.log('fail');
            alert('Système cassé :/');
        });
    },
    create: function() {
        var cardContent = prompt('Contenu de la carte ?');
        // Si nom vide
        if(!cardContent) {
            return;
        }
        // Récupération du data-list-id de la liste parente
        // http://api.jquery.com/closest/
        var listId = $(this).closest('.list').data('list-id');
        // On crée un objet XHR
        // Requête
        $.ajax('card/create', {
            dataType: 'json',
            method: 'POST',
            data: {
                content: cardContent,
                list_id: listId
            }
        })
        // Réponse
        .done(function(data) {
            console.log(data);
            // Si un carte a bien été créée (sinon id vaut false)
            if(data.id) {
                card.displayCard(data);
            }
        });
    },
    displayCard: function(cardData) {
        // Aller chercher le template
        $.ajax('tpl/card.html', {
            dataType: 'html'
        })
        .done(function(response){
            // Convertit le template lu, en objet jQuery
            var $tpl = $(response);

            // On injecte les données reçues en paramètre
            // data-card-id
            $tpl.attr('data-card-id', cardData.id);
            // Contenu de la balise
            $('.content', $tpl).text(cardData.content);

            // Insertion en fin de liste, celle qui correspond à la carte créée
            var $list = $('div[data-list-id="' + cardData.list_id + '"]');
            $list.append($tpl);
        });
    }
}

// Quand le DOM et son contenu est chargé, on éxécute app.init
$(card.init());
