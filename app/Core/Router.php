<?php
/**
 * Classe Router - Gestion du routage URL
 */
class Router
{
    private $routes = [];
    private $currentRoute;
    
    /**
     * Ajouter une route GET
     */
    public function get($uri, $controller, $middleware = [])
    {
        $this->addRoute('GET', $uri, $controller, $middleware);
    }
    
    /**
     * Ajouter une route POST
     */
    public function post($uri, $controller, $middleware = [])
    {
        $this->addRoute('POST', $uri, $controller, $middleware);
    }
    
    /**
     * Ajouter une route PUT
     */
    public function put($uri, $controller, $middleware = [])
    {
        $this->addRoute('PUT', $uri, $controller, $middleware);
    }
    
    /**
     * Ajouter une route DELETE
     */
    public function delete($uri, $controller, $middleware = [])
    {
        $this->addRoute('DELETE', $uri, $controller, $middleware);
    }
    
    /**
     * Ajouter une route
     */
    private function addRoute($method, $uri, $controller, $middleware = [])
    {
        $this->routes[$method][$uri] = [
            'controller' => $controller,
            'middleware' => $middleware
        ];
    }
    
    /**
     * Résoudre la route actuelle
     */
    public function resolve()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $this->getUri();
        
        // Chercher une correspondance exacte
        if (isset($this->routes[$method][$uri])) {
            $this->currentRoute = $this->routes[$method][$uri];
            return $this->executeRoute();
        }
        
        // Chercher une route avec paramètres
        foreach ($this->routes[$method] ?? [] as $routeUri => $route) {
            if ($this->matchRoute($routeUri, $uri)) {
                $this->currentRoute = $route;
                return $this->executeRoute();
            }
        }
        
        // Route non trouvée - 404
        $this->handle404();
    }
    
    /**
     * Obtenir l'URI nettoyée
     */
    private function getUri()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/');
        return $uri === '' ? '/' : $uri;
    }
    
    /**
     * Vérifier si une route correspond avec des paramètres
     */
    private function matchRoute($routeUri, $uri)
    {
        // Convertir les paramètres {id} en regex
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routeUri);
        $pattern = str_replace('/', '\/', $pattern);
        $pattern = '/^' . $pattern . '$/';
        
        if (preg_match($pattern, $uri, $matches)) {
            // Extraire les paramètres
            array_shift($matches); // Retirer le match complet
            $_GET = array_merge($_GET, $matches);
            return true;
        }
        
        return false;
    }
    
    /**
     * Exécuter la route
     */
    private function executeRoute()
    {
        // Exécuter les middlewares
        foreach ($this->currentRoute['middleware'] as $middleware) {
            $middlewareClass = $middleware . 'Middleware';
            if (class_exists($middlewareClass)) {
                $middlewareInstance = new $middlewareClass();
                if (!$middlewareInstance->handle()) {
                    return;
                }
            }
        }
        
        // Exécuter le contrôleur
        $controller = $this->currentRoute['controller'];
        
        if (is_string($controller)) {
            // Format "Controller@method"
            if (strpos($controller, '@') !== false) {
                list($class, $method) = explode('@', $controller);
                
                if (class_exists($class)) {
                    $instance = new $class();
                    if (method_exists($instance, $method)) {
                        return $instance->$method();
                    }
                }
            }
        } elseif (is_callable($controller)) {
            // Fonction anonyme
            return $controller();
        }
        
        throw new Exception("Contrôleur non trouvé : " . $controller);
    }
    
    /**
     * Gérer les erreurs 404
     */
    private function handle404()
    {
        http_response_code(404);
        
        $view404 = __DIR__ . '/../Views/frontend/pages/404.php';
        if (file_exists($view404)) {
            include $view404;
        } else {
            echo "<h1>404 - Page non trouvée</h1>";
        }
    }
    
    /**
     * Générer une URL
     */
    public static function url($path = '')
    {
        $baseUrl = $_ENV['APP_URL'] ?? 'http://localhost:8024';
        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }
    
    /**
     * Redirection
     */
    public static function redirect($path)
    {
        header('Location: ' . self::url($path));
        exit();
    }
}