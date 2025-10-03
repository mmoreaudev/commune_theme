<?php
/**
 * Classe View - Moteur de template simple
 */
class View
{
    private $viewPath;
    
    public function __construct()
    {
        $this->viewPath = __DIR__ . '/../Views/';
    }
    
    /**
     * Rendre une vue
     */
    public function render($template, $data = [])
    {
        // Extraire les variables pour la vue
        extract($data);
        
        // Démarrer la capture de sortie
        ob_start();
        
        try {
            // Déterminer le chemin du template
            $templatePath = $this->getTemplatePath($template);
            
            if (!file_exists($templatePath)) {
                throw new Exception("Template not found: {$template}");
            }
            
            // Inclure le template
            include $templatePath;
            
            // Obtenir le contenu
            $content = ob_get_contents();
            
        } catch (Exception $e) {
            // Nettoyer le buffer en cas d'erreur
            ob_end_clean();
            throw $e;
        }
        
        // Nettoyer et retourner le contenu
        ob_end_clean();
        echo $content;
    }
    
    /**
     * Obtenir le chemin du template
     */
    private function getTemplatePath($template)
    {
        // Supprimer l'extension si présente
        $template = str_replace('.php', '', $template);
        
        // Remplacer les points par des slashes
        $template = str_replace('.', '/', $template);
        
        return $this->viewPath . $template . '.php';
    }
    
    /**
     * Inclure un partial
     */
    public static function partial($partial, $data = [])
    {
        extract($data);
        
        $partialPath = __DIR__ . '/../Views/' . str_replace('.', '/', $partial) . '.php';
        
        if (file_exists($partialPath)) {
            include $partialPath;
        }
    }
    
    /**
     * Inclure un composant
     */
    public static function component($component, $data = [])
    {
        extract($data);
        
        $componentPath = __DIR__ . '/../Views/frontend/components/' . str_replace('.', '/', $component) . '.php';
        
        if (file_exists($componentPath)) {
            include $componentPath;
        }
    }
    
    /**
     * Échapper les données HTML
     */
    public static function escape($data)
    {
        if (is_array($data)) {
            return array_map([self::class, 'escape'], $data);
        }
        
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Afficher du HTML brut (attention XSS!)
     */
    public static function raw($html)
    {
        echo $html;
    }
}