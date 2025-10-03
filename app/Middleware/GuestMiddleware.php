<?php
/**
 * Middleware Guest - Rediriger si déjà connecté
 */
class GuestMiddleware
{
    /**
     * Gérer la requête
     */
    public function handle()
    {
        if (Auth::check()) {
            Router::redirect('/admin');
            return false;
        }
        
        return true;
    }
}