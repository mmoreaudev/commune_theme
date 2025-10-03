<?php
/**
 * Classe Request - Gestion des requêtes HTTP
 */
class Request
{
    private static $instance = null;
    private $data = [];
    
    private function __construct()
    {
        $this->parseRequest();
    }
    
    /**
     * Obtenir l'instance singleton
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**
     * Parser la requête
     */
    private function parseRequest()
    {
        // Données GET
        $this->data = array_merge($this->data, $_GET);
        
        // Données POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->data = array_merge($this->data, $_POST);
            
            // Données JSON
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            if (strpos($contentType, 'application/json') !== false) {
                $json = json_decode(file_get_contents('php://input'), true);
                if ($json) {
                    $this->data = array_merge($this->data, $json);
                }
            }
        }
        
        // Méthodes PUT/DELETE simulées
        if (isset($this->data['_method'])) {
            $_SERVER['REQUEST_METHOD'] = strtoupper($this->data['_method']);
        }
    }
    
    /**
     * Obtenir une valeur
     */
    public function get($key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }
    
    /**
     * Obtenir toutes les données
     */
    public function all()
    {
        return $this->data;
    }
    
    /**
     * Vérifier si une clé existe
     */
    public function has($key)
    {
        return isset($this->data[$key]);
    }
    
    /**
     * Obtenir seulement certaines clés
     */
    public function only($keys)
    {
        $result = [];
        foreach ($keys as $key) {
            if (isset($this->data[$key])) {
                $result[$key] = $this->data[$key];
            }
        }
        return $result;
    }
    
    /**
     * Obtenir toutes les données sauf certaines clés
     */
    public function except($keys)
    {
        $result = $this->data;
        foreach ($keys as $key) {
            unset($result[$key]);
        }
        return $result;
    }
    
    /**
     * Obtenir la méthode HTTP
     */
    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    
    /**
     * Vérifier si c'est une requête POST
     */
    public function isPost()
    {
        return $this->method() === 'POST';
    }
    
    /**
     * Vérifier si c'est une requête GET
     */
    public function isGet()
    {
        return $this->method() === 'GET';
    }
    
    /**
     * Vérifier si c'est une requête AJAX
     */
    public function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    
    /**
     * Obtenir l'URL actuelle
     */
    public function url()
    {
        return $_SERVER['REQUEST_URI'];
    }
    
    /**
     * Obtenir l'IP du client
     */
    public function ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'] ?? null;
        }
    }
    
    /**
     * Obtenir l'User-Agent
     */
    public function userAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? null;
    }
    
    /**
     * Obtenir les fichiers uploadés
     */
    public function files()
    {
        return $_FILES;
    }
    
    /**
     * Obtenir un fichier uploadé
     */
    public function file($key)
    {
        return $_FILES[$key] ?? null;
    }
    
    /**
     * Vérifier si un fichier a été uploadé
     */
    public function hasFile($key)
    {
        return isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK;
    }
}