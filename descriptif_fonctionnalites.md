# descriptif des fonctionnalités réalisées

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
