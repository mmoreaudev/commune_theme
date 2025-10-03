<?php
/**
 * Classe Controller de base
 */
abstract class Controller
{
    protected $db;
    protected $view;
    
    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->view = new View();
    }
    
    /**
     * Rendre une vue
     */
    protected function view($template, $data = [])
    {
        return $this->view->render($template, $data);
    }
    
    /**
     * Rediriger avec message flash
     */
    protected function redirect($path, $message = null, $type = 'success')
    {
        if ($message) {
            Session::flash($type, $message);
        }
        
        Router::redirect($path);
    }
    
    /**
     * Retourner du JSON
     */
    protected function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
    
    /**
     * Valider les données
     */
    protected function validate($data, $rules)
    {
        return Validator::validate($data, $rules);
    }
    
    /**
     * Obtenir les données de la requête
     */
    protected function request()
    {
        return Request::getInstance();
    }
    
    /**
     * Vérifier si la requête est AJAX
     */
    protected function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    
    /**
     * Obtenir l'utilisateur connecté
     */
    protected function user()
    {
        return Auth::user();
    }
    
    /**
     * Vérifier l'authentification
     */
    protected function requireAuth()
    {
        if (!Auth::check()) {
            $this->redirect('/admin/login');
        }
    }
    
    /**
     * Vérifier les permissions
     */
    protected function requireRole($role)
    {
        $this->requireAuth();
        
        if (!Auth::hasRole($role)) {
            http_response_code(403);
            $this->view('admin/pages/403');
            exit();
        }
    }
    
    /**
     * Logger une activité
     */
    protected function logActivity($action, $entityType = null, $entityId = null, $details = null)
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::user()['id'],
                'action' => $action,
                'entity_type' => $entityType,
                'entity_id' => $entityId,
                'details' => $details,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}