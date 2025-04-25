<?php
header('Content-Type: application/json');

// Tableau de prévisions maritimes
$previsions = [
    [
        "id" => 1,
        "alerte" => "Vague de tempête",
        "niveau" => "Rouge",
        "description" => "Des vents violents et des vagues importantes sont attendus.",
        "zone" => "Côte Normande",
        "debut" => "2023-10-01 14:00:00",
        "fin" => "2023-10-02 18:00:00"
    ],
    [
        "id" => 2,
        "alerte" => "Marée haute",
        "niveau" => "Orange",
        "description" => "Attention aux risques d'inondation.",
        "zone" => "Côte Atlantique",
        "debut" => "2023-10-03 10:00:00",
        "fin" => "2023-10-03 16:00:00"
    ]
];

// Récupérer la méthode HTTP
$method = $_SERVER['REQUEST_METHOD'];


// Lire le payload JSON si nécessaire
$input = json_decode(file_get_contents('php://input'), true);

$response = [];

switch ($method) {
    case 'GET':
        if ($method === 'GET' && isset($input['id'])) {
            // Récupérer une prévision spécifique par ID
            $found = false;
            foreach ($previsions as $prevision) {
                if ($prevision['id'] == $input['id']) {
                    $response = $prevision;
                    $response['message'] = "Prévision récupérée avec succès.";
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                http_response_code(404);
                $response['message'] = "Prévision non trouvée.";
            }
        } else {
            // Retourner toutes les prévisions
            $response['message'] = "Toutes les prévisions récupérées avec succès.";
            $response['previsions'] = $previsions;
        }
        break;

    case 'POST':
        // Ajouter une nouvelle prévision (dummy)
        if (!$input) {
            http_response_code(400);
            $response['message'] = "Données invalides ou manquantes.";
            break;
        }
        $newPrevision = [
            "id" => count($previsions) + 1,
            "alerte" => $input['alerte'] ?? "Nouvelle alerte",
            "niveau" => $input['niveau'] ?? "Jaune",
            "description" => $input['description'] ?? "Description non fournie.",
            "zone" => $input['zone'] ?? "Zone inconnue",
            "debut" => $input['debut'] ?? "2023-10-04 00:00:00",
            "fin" => $input['fin'] ?? "2023-10-04 12:00:00"
        ];
        $previsions[] = $newPrevision;
        $response['message'] = "Nouvelle prévision ajoutée avec succès.";
        $response['nouvelle_prevision'] = $newPrevision;
        break;

    case 'PUT':
        // Mettre à jour une prévision (dummy)
        if (isset($input['id'])) {
            $updated = false;
            foreach ($previsions as &$prevision) {
                if ($prevision['id'] == $input['id']) {
                    $prevision = array_merge($prevision, $input);
                    $response['message'] = "Prévision mise à jour avec succès.";
                    $response['mise_a_jour'] = $prevision;
                    $updated = true;
                    break;
                }
            }
            if (!$updated) {
                http_response_code(404);
                $response['message'] = "Prévision non trouvée.";
            }
        } else {
            http_response_code(400);
            $response['message'] = "ID de la prévision manquant.";
        }
        break;

    case 'DELETE':
        // Supprimer une prévision par ID
        if (isset($input['id'])) {
            $deleted = false;
            foreach ($previsions as $key => $prevision) {
                if ($prevision['id'] == $input['id']) {
                    unset($previsions[$key]);
                    $response['message'] = "Prévision supprimée avec succès.";
                    $deleted = true;
                    break;
                }
            }
            if (!$deleted) {
                http_response_code(404);
                $response['message'] = "Prévision non trouvée.";
            }
        } else {
            http_response_code(400);
            $response['message'] = "ID de la prévision manquant.";
        }
        break;

    default:
        // Méthode non supportée
        http_response_code(405);
        $response['message'] = "Méthode non autorisée.";
        break;
}

// Restituer le JSON
echo json_encode($response, JSON_PRETTY_PRINT);
?>