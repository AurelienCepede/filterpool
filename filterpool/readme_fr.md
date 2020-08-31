### SmartPool filtration par cycle

*Voici les différents champs à renseigner:*

* [Obligatoire] - Horaire de fonctionnement.
* [Obligatoire] - Volume d'eau de la piscine. 
* [Obligatoire] - Puissance en M3 de la pompe.  
* [Obligatoire] - Le temps de calibration de la sonde. 
  
## Le principe de base

 * Calcul du nombre et temps de filtration par rapport a la temperature de l'eau.
 * Etalage proportionelle des filtrations sur un temps de fonctionnement total. 
 * Calibration de la sonde avant le calcul. 
 * Ajout de 30 min pour les changements climatiques.
 * Mise en pause pour intervention sur le groupe de filtration.
 
 
  
## Nombre de cycle et temps de filtration.
  
La filtration automatique calcul le nombre de cycles par rapport a la temperature de l'eau lors de la premiere filtration.
Le calcul se base sur les valeurs suivantes : 

* Eau en dessous 15 = 1 cycle.
* Eau entre 15 et 19,9 = 2 cycles.
* Eau entre 20 et 24,9 = 3 cycles.
* Eau entre 25 et 29,9 = 4 cycles.
* Eau au dessus de 30 = Filtration continue

Le temps d'un cycle est base sur :  volume piscine / puissance pompe. 


Apres avoir choisi le nombre de cycles le plugin fait une variation sur chaque cycle selon la temperature de l'eau afin d'affiner son timer.
Il peut avoir plus ou moins 30 min sur l'horaire de fin du programme.



La Filtration X va doubler le nombre de filtration automatique mais divise le temps par 2. 
Cela permet d'eviter une monte trop brutale en produit.


## A Savoir 

- il est conseille d'utiliser ce plugin avec un temps de cycle inferieur a 4 H.

- Il est possible que lors de la premiere mise en route le plugin fasse qu'un seul cycle. C'est normal il a pas assez de temps total pour faire des cycles
il fera des cycles le lendemain.

- Les mini et maxi s'activent dans la nuit de la premiere mise en route du plugin.

- Vous ne pouvez pas ajouter 30min de filtration si vous n'avez pas au minimum 30 min de repos entre filtrations.
L'ajout est enleve sur le temps de repos.

- Le temps de la mise en pause est enleve sur le temps repos.

- La calibration de la sonde se fait sur chaque filtration cependant elle est annoncee que sur la premiere, les autres sont faites pendant le temps
d'attente  (ex : Si 4 vous avez 4 minutes de la calibration, la pompe doit se lancer 4 min avant la prochaine filtration).








  



 

 

  


