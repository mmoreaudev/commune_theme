<?php
/**
 * Contrôleur Document - Gestion des documents/publications
 */
class DocumentController extends Controller
{
    /**
     * Liste des documents
     */
    public function index()
    {
        $page = (int) ($_GET['page'] ?? 1);
        $category = $_GET['category'] ?? null;
        
        $conditions = ['is_active' => 1];
        if ($category) {
            $conditions['category'] = $category;
        }
        
        $documents = Document::paginate($page, 12, $conditions, 'created_at', 'DESC');
        
        return $this->view('frontend.pages.documents', [
            'title' => 'Publications - ' . setting('city_name'),
            'documents' => $documents,
            'currentCategory' => $category
        ]);
    }
    
    /**
     * Bulletins municipaux
     */
    public function bulletins()
    {
        $bulletins = Document::where('category', 'bulletin');
        
        return $this->view('frontend.pages.bulletins', [
            'title' => 'Bulletins municipaux - ' . setting('city_name'),
            'bulletins' => $bulletins
        ]);
    }
    
    /**
     * Magazines
     */
    public function magazines()
    {
        $magazines = Document::where('category', 'magazine');
        
        return $this->view('frontend.pages.magazines', [
            'title' => 'Magazines - ' . setting('city_name'),
            'magazines' => $magazines
        ]);
    }
    
    /**
     * Délibérations
     */
    public function deliberations()
    {
        $deliberations = Document::where('category', 'deliberation');
        
        return $this->view('frontend.pages.deliberations', [
            'title' => 'Délibérations - ' . setting('city_name'),
            'deliberations' => $deliberations
        ]);
    }
    
    /**
     * Télécharger un document
     */
    public function download()
    {
        $id = $_GET[0] ?? null;
        
        if (!$id) {
            http_response_code(404);
            return $this->view('frontend.pages.404');
        }
        
        $document = Document::find($id);
        
        if (!$document || !$document['is_active']) {
            http_response_code(404);
            return $this->view('frontend.pages.404');
        }
        
        $filePath = STORAGE_PATH . '/documents/' . $document['file_path'];
        
        if (!file_exists($filePath)) {
            http_response_code(404);
            return $this->view('frontend.pages.404');
        }
        
        // Incrémenter le compteur de téléchargements
        Document::update($id, ['downloads' => $document['downloads'] + 1]);
        
        // Forcer le téléchargement
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $document['title'] . '"');
        header('Content-Length: ' . filesize($filePath));
        
        readfile($filePath);
        exit;
    }
}