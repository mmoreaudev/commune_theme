<?php
/**
 * Middleware CSRF - Vérifier le token CSRF
 */
class CsrfMiddleware
{
    /**
     * Gérer la requête
     */
    public function handle()
    {
        // Vérifier seulement pour les requêtes POST, PUT, DELETE
        $method = $_SERVER['REQUEST_METHOD'];
        
        if (in_array($method, ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            $token = $_POST['_token'] ?? $_GET['_token'] ?? null;
            
            if (!$token || !Session::verifyCsrf($token)) {
                http_response_code(419);
                echo "Token CSRF invalide. Veuillez rafraîchir la page.";
                return false;
            }
        }
        
        return true;
    }
}