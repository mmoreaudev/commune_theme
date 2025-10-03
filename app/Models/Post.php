<?php
/**
 * Modèle Post - Gestion des articles/actualités
 */
class Post extends Model
{
    protected static $table = 'posts';
    
    /**
     * Créer un article avec validation
     */
    public static function createPost($data)
    {
        // Valider les données
        Validator::validate($data, [
            'title' => 'required|min:3',
            'content' => 'required|min:10',
            'status' => 'required|in:draft,published,archived',
            'category_id' => 'required|integer'
        ]);
        
        // Générer le slug
        $data['slug'] = self::generateSlug($data['title']);
        
        // Générer l'extrait si non fourni
        if (empty($data['excerpt'])) {
            $data['excerpt'] = excerpt($data['content'], 200);
        }
        
        // Date de publication
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }
        
        return self::create($data);
    }
    
    /**
     * Mettre à jour un article
     */
    public static function updatePost($id, $data)
    {
        $rules = [
            'title' => 'required|min:3',
            'content' => 'required|min:10',
            'status' => 'required|in:draft,published,archived'
        ];
        
        Validator::validate($data, $rules);
        
        // Régénérer le slug si le titre a changé
        $current = self::find($id);
        if ($current && $current['title'] !== $data['title']) {
            $data['slug'] = self::generateSlug($data['title'], $id);
        }
        
        // Générer l'extrait si non fourni
        if (empty($data['excerpt'])) {
            $data['excerpt'] = excerpt($data['content'], 200);
        }
        
        // Date de publication
        if ($data['status'] === 'published' && $current['status'] !== 'published' && empty($data['published_at'])) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }
        
        return self::update($id, $data);
    }
    
    /**
     * Obtenir les articles publiés
     */
    public static function getPublished($limit = null)
    {
        $db = Database::getInstance();
        
        $sql = "SELECT p.*, c.name as category_name, u.full_name as author_name 
                FROM posts p 
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN users u ON p.author_id = u.id
                WHERE p.status = 'published' 
                ORDER BY p.published_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Obtenir les articles récents
     */
    public static function getRecent($limit = 5)
    {
        return self::getPublished($limit);
    }
    
    /**
     * Obtenir un article avec ses relations
     */
    public static function getWithRelations($id)
    {
        $db = Database::getInstance();
        
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug,
                       u.full_name as author_name, u.email as author_email
                FROM posts p 
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN users u ON p.author_id = u.id
                WHERE p.id = ?";
        
        $stmt = $db->query($sql, [$id]);
        return $stmt->fetch();
    }
    
    /**
     * Obtenir un article par slug avec relations
     */
    public static function getBySlugWithRelations($slug)
    {
        $db = Database::getInstance();
        
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug,
                       u.full_name as author_name, u.email as author_email
                FROM posts p 
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN users u ON p.author_id = u.id
                WHERE p.slug = ? AND p.status = 'published'";
        
        $stmt = $db->query($sql, [$slug]);
        return $stmt->fetch();
    }
    
    /**
     * Obtenir les articles par catégorie
     */
    public static function getByCategory($categoryId, $limit = null)
    {
        $db = Database::getInstance();
        
        $sql = "SELECT p.*, c.name as category_name, u.full_name as author_name 
                FROM posts p 
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN users u ON p.author_id = u.id
                WHERE p.category_id = ? AND p.status = 'published' 
                ORDER BY p.published_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        $stmt = $db->query($sql, [$categoryId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Incrémenter les vues
     */
    public static function incrementViews($id)
    {
        $db = Database::getInstance();
        $sql = "UPDATE posts SET views = views + 1 WHERE id = ?";
        $db->query($sql, [$id]);
    }
    
    /**
     * Rechercher des articles
     */
    public static function search($query)
    {
        $db = Database::getInstance();
        
        $sql = "SELECT p.*, c.name as category_name, u.full_name as author_name 
                FROM posts p 
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN users u ON p.author_id = u.id
                WHERE (p.title LIKE ? OR p.content LIKE ? OR p.excerpt LIKE ?) 
                AND p.status = 'published'
                ORDER BY p.published_at DESC";
        
        $searchTerm = "%{$query}%";
        $stmt = $db->query($sql, [$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    /**
     * Obtenir les statistiques des articles
     */
    public static function getStats()
    {
        $db = Database::getInstance();
        
        $stats = [];
        
        // Total articles
        $stats['total'] = self::count();
        
        // Par statut
        $stmt = $db->query("SELECT status, COUNT(*) as count FROM posts GROUP BY status");
        $statusStats = $stmt->fetchAll();
        
        foreach ($statusStats as $status) {
            $stats['status'][$status['status']] = $status['count'];
        }
        
        // Articles populaires
        $stmt = $db->query("SELECT title, views FROM posts WHERE status = 'published' ORDER BY views DESC LIMIT 5");
        $stats['popular'] = $stmt->fetchAll();
        
        // Total vues
        $stmt = $db->query("SELECT SUM(views) as total_views FROM posts WHERE status = 'published'");
        $result = $stmt->fetch();
        $stats['total_views'] = $result['total_views'] ?? 0;
        
        return $stats;
    }
}