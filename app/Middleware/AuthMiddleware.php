<?php
/**
 * Middleware Auth - Vérifier l'authentification
 */
class AuthMiddleware
{
    /**
     * Gérer la requête
     */
    public function handle()
    {
        if (!Auth::check()) {
            // Sauvegarder l'URL demandée
            Session::put('intended_url', $_SERVER['REQUEST_URI']);
            
            // Rediriger vers la page de connexion
            Router::redirect('/admin/login');
            return false;
        }
        
        return true;
    }
}