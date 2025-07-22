<?php

use App\Core\App;
use App\Controller\CitoyenController;

return $routes = [
    // Méthode, URI, [Contrôleur, méthode]
    ['GET', '/api/citoyen/{nci}', [CitoyenController::class, 'findByNci']],
    ['GET', '/api/citoyens', [CitoyenController::class, 'findAll']],
];
