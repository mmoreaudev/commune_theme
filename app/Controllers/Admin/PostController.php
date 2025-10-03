<?php
namespace Admin;

/**
 * Contrôleur Admin Post - Gestion des articles (Admin)
 */
class PostController extends \Controller
{
    /**
     * Liste des articles
     */
    public function index()
    {
        $page = (int) ($_GET['page'] ?? 1);
        $posts = \\Post::paginate($page, 10, [], 'created_at', 'DESC');
        
        return $this->view('admin.pages.posts.index', [
            'title' => 'Gestion des articles',
            'posts' => $posts
        ]);
    }
    
    /**
     * Formulaire de création d'article
     */
    public function create()
    {
        return $this->view('admin.pages.posts.create', [
            'title' => 'Nouvel article'
        ]);
    }
    
    /**
     * Enregistrer un nouvel article
     */
    public function store()
    {
        try {
            $data = $this->request()->all();
            $data['author_id'] = auth()['id'] ?? 1;
            $data['status'] = $data['status'] ?? 'draft';
            
            $post = \Post::createPost($data);
            
            return $this->redirect('/admin/posts', 'Article créé avec succès !', 'success');
            
        } catch (Exception $e) {
            return $this->redirect('/admin/posts/create', 'Erreur lors de la création : ' . $e->getMessage(), 'error');
        }
    }
    
    /**
     * Formulaire d'édition d'article
     */
    public function edit()
    {
        $id = $_GET[0] ?? null;
        
        if (!$id) {
            return $this->redirect('/admin/posts', 'Article introuvable', 'error');
        }
        
        $post = \Post::find($id);
        
        if (!$post) {
            return $this->redirect('/admin/posts', 'Article introuvable', 'error');
        }
        
        return $this->view('admin.pages.posts.edit', [
            'title' => 'Modifier l\'article',
            'post' => $post
        ]);
    }
    
    /**
     * Mettre à jour un article
     */
    public function update()
    {
        $id = $_GET[0] ?? null;
        
        if (!$id) {
            return $this->redirect('/admin/posts', 'Article introuvable', 'error');
        }
        
        try {
            $data = $this->request()->all();
            \Post::updatePost($id, $data);
            
            return $this->redirect('/admin/posts', 'Article mis à jour avec succès !', 'success');
            
        } catch (Exception $e) {
            return $this->redirect("/admin/posts/{$id}/edit", 'Erreur lors de la mise à jour : ' . $e->getMessage(), 'error');
        }
    }
    
    /**
     * Supprimer un article
     */
    public function delete()
    {
        $id = $_GET[0] ?? null;
        
        if (!$id) {
            return $this->redirect('/admin/posts', 'Article introuvable', 'error');
        }
        
        try {
            \Post::delete($id);
            return $this->redirect('/admin/posts', 'Article supprimé avec succès !', 'success');
            
        } catch (Exception $e) {
            return $this->redirect('/admin/posts', 'Erreur lors de la suppression : ' . $e->getMessage(), 'error');
        }
    }
}
