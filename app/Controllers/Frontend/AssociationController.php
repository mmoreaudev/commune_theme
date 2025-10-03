<?php
/**
 * Contrôleur Association - Gestion des associations
 */
class AssociationController extends Controller
{
    /**
     * Liste des associations
     */
    public function index()
    {
        $associations = Association::all('name', 'ASC');
        
        return $this->view('frontend.pages.associations', [
            'title' => 'Associations - ' . setting('city_name'),
            'associations' => $associations
        ]);
    }
    
    /**
     * Afficher une association
     */
    public function show()
    {
        $slug = $_GET[0] ?? null;
        
        if (!$slug) {
            http_response_code(404);
            return $this->view('frontend.pages.404');
        }
        
        $association = Association::bySlug($slug);
        
        if (!$association) {
            http_response_code(404);
            return $this->view('frontend.pages.404');
        }
        
        return $this->view('frontend.pages.association-single', [
            'title' => $association['name'] . ' - ' . setting('city_name'),
            'association' => $association
        ]);
    }
}