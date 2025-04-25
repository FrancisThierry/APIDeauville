# API de Prévisions Maritimes

Ce document décrit les points de terminaison de l'API de prévisions maritimes et comment les tester à l'aide de `curl`.

**URL de base :** `http://domain/votre_script.php` (remplacez `votre_script.php` par le nom de votre fichier PHP)

## Points de terminaison

### Récupérer toutes les prévisions (GET)

Récupère la liste complète des prévisions maritimes.

```bash
curl http://domain/api
```
### Exemple de réponse

```
{
    "message": "Toutes les prévisions récupérées avec succès.",
    "previsions": [
        {
            "id": 1,
            "alerte": "Vague de tempête",
            "niveau": "Rouge",
            "description": "Des vents violents et des vagues importantes sont attendus.",
            "zone": "Côte Normande",
            "debut": "2023-10-01 14:00:00",
            "fin": "2023-10-02 18:00:00"
        },
        {
            "id": 2,
            "alerte": "Marée haute",
            "niveau": "Orange",
            "description": "Attention aux risques d'inondation.",
            "zone": "Côte Atlantique",
            "debut": "2023-10-03 10:00:00",
            "fin": "2023-10-03 16:00:00"
        }
    ]
}
````
### POST

```bash
curl -X POST -H "Content-Type: application/json" -d '{"alerte": "Brouillard", "niveau": "Jaune", "description": "Visibilité réduite attendue.", "zone": "Manche Ouest", "debut": "2025-04-26 06:00:00", "fin": "2025-04-26 10:00:00"}' http://localhost:8080/api
