# Routes de notre appli


- En tant que user, on veut afficher les listes avec tous les post-it.
- En tant que user, on veut créer des listes afin de mettre des post-it.
- En tant que user, on veut pouvoir (re)nommer les listes.
- En tant que user, je veux pouvoir créer un post-it.
- En tant que user, je veux pouvoir écrire un texte dans le post-it.
- En tant que user, on veut pouvoir positionner les post-it où l'on veut dans les listes.
- En tant que user, on doit pouvoir éditer un post-it déja ecrit.

| Story | URL | Contrôleur | Méthode | Paramètre à prévoir (spoil) |
|-|-|-|-|-|
| Home | / | MainController | home | -
| Récupérer les listes | /list/get/all | ApiController | getAll | |
| Créer une nouvelle liste | /list/create | ApiController | create | nom de la liste |
| Renommer une liste | /list/update | ApiController | update | #id liste + nom |
| Supprimer une liste | /list/delete | ApiController | delete | #id liste |
| Ajouter une carte dans une liste | /card/create | CardController | create | #id liste + contenu carte |
| Modifier une carte | /card/update | CardController | update | #id liste |
| Supprimer une carte | /card/delete | CardController | delete | #id liste |
| Redéfinir l'ordre des cartes dans une liste | /list/order | ApiController | order |  #id liste + ordre des cartes |
