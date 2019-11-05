# Vehicle fleet parking management

* `composer install`
* `vendor/bin/behat`

## Notes

Je n'avais jamais utilisé Behat ou autres outils de BDD auparavant, j'ai donc tâtonné un peu.  
Selon la doc, j'ai l'impression que la CLI aurait du créer les test suites automatiquement à partir des *.feature, mais il y a eu des râtés et j'imagine qu'avoir tous les tests dans la même classe n'est pas génial. Chaque scénario devrait probablement être joué en isolation sans partager de state avec les autres.  

## Code

* aggregates Fleet & Vehicle dans `MyFleet\Domain`
* Commands+Queries dans `MyFleet\App\*\*Commands` et `MyFleet\App\*\*Queries`
* les exceptions sont dans `MyFleet\Domain\Exception` mais seraient sans doute mieux directement dans `MyFleet\Exception`

