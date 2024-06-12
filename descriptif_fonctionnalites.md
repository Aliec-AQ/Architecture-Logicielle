# descriptif des fonctionnalités réalisées


# APP: 
## Afficher la liste des prestations
Pour afficher la liste des prestations, il y a 2 moyens,
le premier est d'y accéder par la route "/listePrestations" et
l'autre moyen est de cliquer sur l'option 
"prestations" du menu de l'application.
Toutes les prestations vont alors s'afficher de façon
identique avec nom, prix, catégorie et image.
Les prestations sont triales par prix croissant et décroissant
et par ordre alphabétique sur le nom de la prestation 
et par ordre alphabétique inversé sur le nom de la prestation. 

## Afficher le détail d'une prestation 
Pour afficher une prestation en détail, il y a 2 moyen,
le premier est d'y accéder par la route "/prestation/?id={id de la prestation}"
et le deuxieme moyen est de cliquer sur l'une
des prestations dans la liste des prestations.
Toutes les informations de la prestation vont alors s'afficher
sur cette page et la photo sera dans sa taille normale.

## liste de prestations par catégories
Pour afficher la liste des prestations par catégories,
il y a 2 moyens, le premier est d'y accéder directement par 
la route "/categorie/{id categorie}/prestations" et 
le deuxieme moyen est de cliquer sur le bouton "voir prestations"
sur la page de détail d'une catégorie. Une fois sur la page,
la liste des prestations s'affiche de la même manière que 
que pour la fonctionnalité d'affichage des prestations,
on peut donc cliquer sur les prestations pour en afficher le detail.

## liste des catégories
Pour afficher la liste des catégories, il y a 2 moyens, 
aller directement sur la route "/categories" ou en s'y faisant 
rediriger par l'option "categories" du menu.
Il est possible d'afficher le detail d'une catégorie en cliquant dessus,
page sur laquelle se trouve le bouton pour accéder à la liste 
des prestations de cette catégorie.

## Tri par prix
Il est possible de trier les prestations par prix croissant et décroissant,
pour cela, il suffit de cliquer sur la liste déroulante et sélectionner l'option souhaitée.
La première option : <<Prix (Croissant)>> permet de trier les prestations par prix croissant
et la deuxième option : <<Prix (Décroissant)>> permet de trier les prestations par prix décroissant.
Après avoir sélectionné l'option souhaitée, la liste des prestations se met à jour automatiquement.
L'opération peut prendre un moment, veuillez patienter.

## Création d'un coffret vide
Pour créer un coffret vide, il faut d'abord aller sur la page de création de coffret,
pour cela, il faut cliquer sur le bouton "Créer une box" dans le menu.
Une fois sur la page, il faudra spécifier plusieurs informations pour la création du coffret.
Il faudra donner un nom au coffret, sa description, si le coffret sera un cadeau en cochant la case correspondante et 
si le coffret est un cadeau, un message pour le destinataire.
Il faudra ensuite cliquer sur le bouton "Créer" pour valider la création du coffret.

## Ajout d'une prestation à un coffret
Pour ajouter une prestation à un coffret, il faut d'abord aller sur la page de détail de la prestation,
pour cela, il faut cliquer sur la prestation souhaitée.
Une fois sur la page, il faudra cliquer sur le bouton "Ajouter au coffret" pour ajouter la prestation au coffret.
Une foie ajoutée, vous serez tout de suite redirigé vers la page de détail de liste de prestations.

## Affichage d'un coffret
Pour afficher un coffret, il y a plusieurs moyens de le faire,
Le premier est d'y accéder par la route "box/courante", un autre est le bouton "Box Courante" du menu.
Une fois sur la page, toutes les informations du coffret s'affichent,
ainsi que les prestations qui le composent.

## Validation d'un coffret
Pour valider un coffret, il faut d'abord aller sur la page de détail de la boite à valider,
ensuite, il faut cliquer sur le bouton "Valider" sur la page de détail de la boite.
Pour valider la boite, il faut au moins deux prestations de deux catégories différentes dans le coffret. 
Une fois cliqué, le coffret est validé et toute modification de prestations devient impossible.
Vous aurez alors accès au bouton "Payer la box" pour payer le coffret.

## Paiement d'un coffret
Pour payer un coffret, il faut d'abord aller sur la page de détail de la boite,
si vous ne l'avez pas déjà fait, il faudra valider la boite pour pouvoir payer.
Une fois sur la page, il faudra cliquer sur le bouton "Payer la box" pour payer.

## Suppression d'une prestation d'un coffret
Pour supprimer une prestation d'un coffret, il faut d'abord aller sur la page de détail de la boite,
pour cela, il faut cliquer sur le bouton "Box Courante" dans le menu.
Pour supprimer une prestation, il suffit de cliquer sur le bouton "X" à côté du nom de la prestation à supprimer.

## Modification d'une prestation d'un coffret
Pour modifier une prestation d'un coffret, il faut d'abord aller sur la page de détail de la boite,
pour cela, il faut cliquer sur le bouton "Box Courante" dans le menu.
Une fois sur la page, vous pourrez modifier les quantités des prestations en modifiant le nombre dans le champ de texte
et en cliquant sur le bouton d'actualisation (sous la forme d'une flèche) pour valider la modification.

## génération de l'URL d'accès
Pour générer l'URL d'accès à un coffret, il faut d'abord aller sur la page de détail de la boite,
Puis il faut s'assurer que la boite est validée et payée.
Une fois sur la page, il faudra cliquer sur le bouton "Générer l'URL d'accès" pour générer l'URL.
Vous serrez alors redirigé vers une page où vous pourrez voir l'URL générée.

## Accès à un coffret 
Pour accéder à un coffret, il faut d'abord avoir l'URL d'accès à la boite,
ensuite, il faut coller l'URL dans la barre de recherche de votre navigateur.
Une fois sur la page, vous pourrez voir toutes les informations de la boite,
ainsi que les prestations qui la composent.

## Sign in
Pour se connecter, l'on peut cliquer sur le bouton "Connexion" dans le menu.
Une fois sur la page, il faudra renseigner son adresse mail et son mot de passe.
Ou alors, il est possible de se connecter en cliquant essayant de créer un coffret,
il faudra alors se connecter ou créer un compte pour pouvoir continuer.
Une fois sur la page, il faudra renseigner son adresse mail et son mot de passe.

## Register
Pour s'inscrire, l'on peut cliquer sur le bouton "Connexion" dans le menu.
Ou essayant de créer un coffret, il faudra alors se connecter ou créer un compte pour pouvoir continuer.
Une fois sur la page, il faudra cliquer sur le bouton "Register" pour accéder au formulaire d'inscription.
Il faudra ensuite renseigner son adresse mail et son mot de passe deux fois.
Une fois le formulaire rempli, il faudra cliquer sur le bouton "Register" pour valider l'inscription.

## Accèder à ces coffrets
Pour accéder à ces coffrets, il faut d'abord être connecté,
ensuite, il faut cliquer sur le bouton "Mes coffrets" dans le menu.
Une fois sur la page, vous pourrez voir tous les coffrets que vous avez créés.
Ou alors, il est possible d'ajouter "/boxs/liste/" à la fin de l'URL d'acceuil pour accéder à la page directement.


## Afficher les box prédéfinies
Pour afficher les box prédéfinies, il y a 2 moyens,
le premier est d'y accéder par la route "/boxsPredefinies" et
l'autre moyen est de cliquer sur l'option "box prédéfinies" du menu de l'application.
Toutes les box prédéfinies vont alors s'afficher de façon identique avec nom, prix.
Vous pouvez cliquer sur une box pour en afficher le détail.

## créer un coffret prérempli à partir d'une box
Pour créer un coffret à partir d'une box prédéfinie, il faut d'abord aller sur la page de détail de la box prédéfinie,
pour cela, il faut cliquer sur la box souhaitée.
Une fois sur la page, il faudra cliquer sur le bouton "Créer une box à partir de cette box" pour créer la box.
Vous serez alors redirigé vers la page de création d'une nouvelle boite.
Il faudra ensuite créer la boite normalement.

## créer un coffret prérempli à partir d'une box affichée
Pour créer une box à partir d'une box prédéfinie, il faut aller créer une box normalement,
puis il faut selectionner une box prédéfinie dans la liste déroulante.

# API :

## Liste des prestations 
Pour recevoir la liste des prestations au format JSON, il faut faire une requête GET sur la route "/api/prestations".
Les prestations contiennent un lien vers la prestation par rapport à son id ainsi qu'un lien vers l'image qui lui est associée.

## Liste des catégories
Pour recevoir la liste des catégories au format JSON, il faut faire une requête GET sur la route "/api/categories".
Les catégories contiennent un lien vers la catégorie par rapport à son id ainsi qu'un lien vers la liste des prestations
de la catégorie.

## Liste des prestations par catégorie
Pour recevoir la liste des prestations d'une catégorie au format JSON, il faut faire une requête GET sur la route "/api/categorie/{id catégorie}/prestations".
La liste des prestations se présente de la même manière que la liste des prestations de la route "/api/prestations".

## Accès à un coffret
Pour accéder à un coffret, il faut faire une requête GET sur la route "/api/boxes/{id box}".
Le coffret contient directement la liste des prestations qui le composent.

## Affichage d'une presation par son id
Pour afficher une prestation par son id, il faut faire une requête GET sur la route "/api/prestation/{id prestation}".
Le contenu de la prestation contient unee uri pour accéder à son image.

## Affichage d'une catégorie par son id
Pour afficher une catégorie par son id, il faut faire une requête GET sur la route "/api/categorie/{id catégorie}".
Le contenu de la catégorie contient une uri pour accéder à la liste des prestations de la catégorie.
