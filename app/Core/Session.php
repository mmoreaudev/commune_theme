<?php
/**
 * Classe Session - Gestion des sessions
 */
class Session
{
    /**
     * Démarrer la session si pas déjà fait
     */
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Obtenir une valeur de session
     */
    public static function get($key, $default = null)
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }
    
    /**
     * Définir une valeur de session
     */
    public static function put($key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }
    
    /**
     * Vérifier si une clé existe
     */
    public static function has($key)
    {
        self::start();
        return isset($_SESSION[$key]);
    }
    
    /**
     * Supprimer une clé
     */
    public static function forget($key)
    {
        self::start();
        unset($_SESSION[$key]);
    }
    
    /**
     * Vider toute la session
     */
    public static function flush()
    {
        self::start();
        $_SESSION = [];
    }
    
    /**
     * Détruire la session
     */
    public static function destroy()
    {
        self::start();
        session_destroy();
        session_regenerate_id(true);
    }
    
    /**
     * Régénérer l'ID de session
     */
    public static function regenerate()
    {
        self::start();
        session_regenerate_id(true);
    }
    
    /**
     * Messages flash
     */
    public static function flash($key, $message)
    {
        self::put('flash_' . $key, $message);
    }
    
    /**
     * Obtenir un message flash
     */
    public static function getFlash($key)
    {
        $message = self::get('flash_' . $key);
        self::forget('flash_' . $key);
        return $message;
    }
    
    /**
     * Vérifier si un message flash existe
     */
    public static function hasFlash($key)
    {
        return self::has('flash_' . $key);
    }
    
    /**
     * Token CSRF
     */
    public static function csrfToken()
    {
        if (!self::has('csrf_token')) {
            self::put('csrf_token', bin2hex(random_bytes(32)));
        }
        
        return self::get('csrf_token');
    }
    
    /**
     * Vérifier le token CSRF
     */
    public static function verifyCsrf($token)
    {
        return hash_equals(self::csrfToken(), $token);
    }
}