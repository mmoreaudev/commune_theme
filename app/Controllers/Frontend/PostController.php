<?php
/**
 * Contrôleur Post - Gestion des articles/actualités (Frontend)
 */
class PostController extends Controller
{
    /**
     * Afficher la liste des articles
     */
    public function index()
    {
        $page = (int) ($_GET['page'] ?? 1);
        $categoryId = $_GET['category'] ?? null;
        
        $conditions = ['status' => 'published'];
        if ($categoryId) {
            $conditions['category_id'] = $categoryId;
        }
        
        $posts = Post::paginate($page, 6, $conditions, 'published_at', 'DESC');
        
        // Enrichir avec les relations
        foreach ($posts['items'] as &$post) {
            $post = Post::getWithRelations($post['id']);
        }
        
        // Récupérer les catégories pour le filtre
        $categories = Category::getWithPostCount();
        
        return $this->view('frontend.pages.posts', [
            'title' => 'Actualités - ' . setting('city_name'),
            'posts' => $posts,
            'categories' => $categories,
            'currentCategory' => $categoryId
        ]);
    }
    
    /**
     * Afficher un article
     */
    public function show()
    {
        $slug = $_GET[0] ?? null;
        
        if (!$slug) {
            http_response_code(404);
            return $this->view('frontend.pages.404');
        }
        
        $post = Post::getBySlugWithRelations($slug);
        
        if (!$post) {
            http_response_code(404);
            return $this->view('frontend.pages.404');
        }
        
        // Incrémenter les vues
        Post::incrementViews($post['id']);
        
        // Articles similaires
        $relatedPosts = [];
        if ($post['category_id']) {
            $relatedPosts = Post::getByCategory($post['category_id'], 3);
            // Exclure l'article actuel
            $relatedPosts = array_filter($relatedPosts, function($related) use ($post) {
                return $related['id'] !== $post['id'];
            });
            $relatedPosts = array_slice($relatedPosts, 0, 2);
        }
        
        return $this->view('frontend.pages.post-single', [
            'title' => $post['title'] . ' - ' . setting('city_name'),
            'post' => $post,
            'relatedPosts' => $relatedPosts
        ]);
    }
}