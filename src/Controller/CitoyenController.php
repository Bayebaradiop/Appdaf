<?php

namespace App\Controller;

use App\Service\CitoyenService;

class CitoyenController
{
    private CitoyenService $citoyenService;

    public function __construct()
    {
        $this->citoyenService = new CitoyenService();
    }

    private function setCorsHeaders()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
    }

    public function findByNci(string $nci)
    {
        $this->setCorsHeaders();
        header('Content-Type: application/json');
        $citoyen = $this->citoyenService->findByNci($nci);

        if ($citoyen) {
            http_response_code(200);
            echo json_encode([
                'data' => [
                    'nci' => $citoyen->getNci(),
                    'nom' => $citoyen->getNom(),
                    'prenom' => $citoyen->getPrenom(),
                    'date' => $citoyen->getDateNaissance(),
                    'lieu' => $citoyen->getLieuNaissance(),
                    'url_carte_recto' => $citoyen->getUrlCarteRecto(),
                    'url_carte_verso' => $citoyen->getUrlCarteVerso(),
                ],
                'statut' => 'success',
                'code' => 200,
                'message' => "Le numéro de carte d'identité a été retrouvé"
            ]);
            exit;
        } else {
            http_response_code(404);
            echo json_encode([
                'data' => null,
                'statut' => 'error',
                'code' => 404,
                'message' => "Le numéro de carte d'identité non retrouvé"
            ]);
            exit;
        }
    }

    public function findAll()
    {
        $this->setCorsHeaders();
        header('Content-Type: application/json');
        $citoyens = $this->citoyenService->findAll();

        http_response_code(200);
        echo json_encode([
            'data' => array_map(fn($citoyen) => $citoyen->toArray(), $citoyens ?: []),
            'statut' => 'success',
            'code' => 200,
            'message' => $citoyens ? "Liste des citoyens récupérée avec succès" : "Aucun citoyen trouvé"
        ]);
        exit;
    }
}
