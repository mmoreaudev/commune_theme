<?php
/**
 * Middleware Admin - Vérifier les permissions administrateur
 */
class AdminMiddleware
{
    /**
     * Gérer la requête
     */
    public function handle()
    {
        if (!Auth::check()) {
            Router::redirect('/admin/login');
            return false;
        }
        
        if (!Auth::hasRole('admin')) {
            http_response_code(403);
            echo "Accès interdit. Permissions administrateur requises.";
            return false;
        }
        
        return true;
    }
}