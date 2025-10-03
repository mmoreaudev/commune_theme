<?php
/**
 * Contrôleur Admin Settings - Gestion des paramètres du site (Admin)
 */
class SettingController extends Controller
{
    /**
     * Affichage des paramètres généraux
     */
    public function index()
    {
        $settings = Setting::all();
        $settingsData = [];
        
        // Organiser les paramètres par catégorie
        foreach ($settings as $setting) {
            $category = $setting['category'] ?: 'general';
            $settingsData[$category][] = $setting;
        }
        
        return $this->view('admin.pages.settings.index', [
            'title' => 'Paramètres du site',
            'settings' => $settingsData
        ]);
    }
    
    /**
     * Mise à jour des paramètres
     */
    public function update()
    {
        if (!$this->validateCSRF()) {
            return $this->redirect('/admin/settings', 'Token CSRF invalide', 'error');
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect('/admin/settings', 'Méthode non autorisée', 'error');
        }
        
        try {
            foreach ($_POST as $key => $value) {
                if ($key === '_token') continue;
                
                // Vérifier si le paramètre existe
                $setting = Setting::findByKey($key);
                
                if ($setting) {
                    // Traitement spécial pour les fichiers (logo, etc.)
                    if (isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK) {
                        $value = $this->handleFileUpload($_FILES[$key], $key);
                    }
                    
                    Setting::updateValue($key, $value);
                } else {
                    // Créer un nouveau paramètre
                    Setting::create([
                        'key' => $key,
                        'value' => $value,
                        'category' => 'general',
                        'type' => $this->detectSettingType($value)
                    ]);
                }
            }
            
            return $this->redirect('/admin/settings', 'Paramètres mis à jour avec succès', 'success');
            
        } catch (Exception $e) {
            return $this->redirect('/admin/settings', 'Erreur lors de la mise à jour : ' . $e->getMessage(), 'error');
        }
    }
    
    /**
     * Gestion des widgets
     */
    public function widgets()
    {
        $widgets = Widget::all();
        $activeWidgets = Widget::where('is_active', '1');
        
        return $this->view('admin.pages.settings.widgets', [
            'title' => 'Gestion des widgets',
            'widgets' => $widgets,
            'activeWidgets' => $activeWidgets
        ]);
    }
    
    /**
     * Activation/désactivation d'un widget
     */
    public function toggleWidget()
    {
        if (!$this->validateCSRF()) {
            return $this->redirect('/admin/settings/widgets', 'Token CSRF invalide', 'error');
        }
        
        $id = $_GET[0] ?? null;
        
        if (!$id) {
            return $this->redirect('/admin/settings/widgets', 'Widget introuvable', 'error');
        }
        
        try {
            $widget = Widget::find($id);
            
            if (!$widget) {
                return $this->redirect('/admin/settings/widgets', 'Widget introuvable', 'error');
            }
            
            $newStatus = $widget['is_active'] ? 0 : 1;
            Widget::update($id, ['is_active' => $newStatus]);
            
            $message = $newStatus ? 'Widget activé' : 'Widget désactivé';
            return $this->redirect('/admin/settings/widgets', $message, 'success');
            
        } catch (Exception $e) {
            return $this->redirect('/admin/settings/widgets', 'Erreur lors de la modification', 'error');
        }
    }
    
    /**
     * Gestion du cache
     */
    public function cache()
    {
        return $this->view('admin.pages.settings.cache', [
            'title' => 'Gestion du cache'
        ]);
    }
    
    /**
     * Vider le cache
     */
    public function clearCache()
    {
        if (!$this->validateCSRF()) {
            return $this->redirect('/admin/settings/cache', 'Token CSRF invalide', 'error');
        }
        
        try {
            // Supprimer les fichiers de cache s'ils existent
            $cacheDir = ROOT_PATH . '/storage/cache';
            if (is_dir($cacheDir)) {
                $files = glob($cacheDir . '/*');
                foreach ($files as $file) {
                    if (is_file($file)) {
                        unlink($file);
                    }
                }
            }
            
            return $this->redirect('/admin/settings/cache', 'Cache vidé avec succès', 'success');
            
        } catch (Exception $e) {
            return $this->redirect('/admin/settings/cache', 'Erreur lors du vidage du cache', 'error');
        }
    }
    
    /**
     * Gestion des fichiers uploadés pour les paramètres
     */
    private function handleFileUpload($file, $settingKey)
    {
        $uploadDir = ROOT_PATH . '/public/uploads/settings';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $settingKey . '_' . time() . '.' . $extension;
        $targetPath = $uploadDir . '/' . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return '/uploads/settings/' . $filename;
        }
        
        throw new Exception('Erreur lors de l\'upload du fichier');
    }
    
    /**
     * Détecte le type d'un paramètre basé sur sa valeur
     */
    private function detectSettingType($value)
    {
        if (is_numeric($value)) {
            return 'number';
        }
        
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }
        
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return 'url';
        }
        
        if (in_array(strtolower($value), ['true', 'false', '1', '0'])) {
            return 'boolean';
        }
        
        if (strlen($value) > 255) {
            return 'textarea';
        }
        
        return 'text';
    }
}