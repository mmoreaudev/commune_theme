<?php
namespace Admin;

/**
 * Contrôleur Admin Page - Gestion des pages (Admin)
 */
class PageController extends \Controller
{
    /**
     * Liste des pages
     */
    public function index()
    {
        $page = (int) ($_GET['page'] ?? 1);
        $pages = Page::paginate($page, 10, [], 'created_at', 'DESC');
        
        return $this->view('admin.pages.pages.index', [
            'title' => 'Gestion des pages',
            'pages' => $pages
        ]);
    }
    
    /**
     * Formulaire de création de page
     */
    public function create()
    {
        return $this->view('admin.pages.pages.create', [
            'title' => 'Nouvelle page'
        ]);
    }
    
    /**
     * Enregistrer une nouvelle page
     */
    public function store()
    {
        try {
            $data = $this->request()->all();
            $data['status'] = $data['status'] ?? 'published';
            
            // Générer le slug
            if (empty($data['slug']) && !empty($data['title'])) {
                $data['slug'] = Page::generateSlug($data['title']);
            }
            
            $page = Page::create($data);
            
            return $this->redirect('/admin/pages', 'Page créée avec succès !', 'success');
            
        } catch (Exception $e) {
            return $this->redirect('/admin/pages/create', 'Erreur lors de la création : ' . $e->getMessage(), 'error');
        }
    }
    
    /**
     * Formulaire d'édition de page
     */
    public function edit()
    {
        $id = $_GET[0] ?? null;
        
        if (!$id) {
            return $this->redirect('/admin/pages', 'Page introuvable', 'error');
        }
        
        $page = Page::find($id);
        
        if (!$page) {
            return $this->redirect('/admin/pages', 'Page introuvable', 'error');
        }
        
        return $this->view('admin.pages.pages.edit', [
            'title' => 'Modifier la page',
            'page' => $page
        ]);
    }
    
    /**
     * Mettre à jour une page
     */
    public function update()
    {
        $id = $_GET[0] ?? null;
        
        if (!$id) {
            return $this->redirect('/admin/pages', 'Page introuvable', 'error');
        }
        
        try {
            $data = $this->request()->all();
            
            // Régénérer le slug si le titre a changé
            $current = Page::find($id);
            if ($current && $current['title'] !== $data['title']) {
                $data['slug'] = Page::generateSlug($data['title'], $id);
            }
            
            Page::update($id, $data);
            
            return $this->redirect('/admin/pages', 'Page mise à jour avec succès !', 'success');
            
        } catch (Exception $e) {
            return $this->redirect("/admin/pages/{$id}/edit", 'Erreur lors de la mise à jour : ' . $e->getMessage(), 'error');
        }
    }
    
    /**
     * Supprimer une page
     */
    public function delete()
    {
        $id = $_GET[0] ?? null;
        
        if (!$id) {
            return $this->redirect('/admin/pages', 'Page introuvable', 'error');
        }
        
        try {
            Page::delete($id);
            return $this->redirect('/admin/pages', 'Page supprimée avec succès !', 'success');
            
        } catch (Exception $e) {
            return $this->redirect('/admin/pages', 'Erreur lors de la suppression : ' . $e->getMessage(), 'error');
        }
    }
}