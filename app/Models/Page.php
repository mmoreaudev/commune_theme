<?php
/**
 * Modèle Page - Gestion des pages statiques
 */
class Page extends Model
{
    protected static $table = 'pages';
    
    /**
     * Créer une page avec validation
     */
    public static function createPage($data)
    {
        // Valider les données
        Validator::validate($data, [
            'title' => 'required|min:2',
            'content' => 'required|min:10',
            'status' => 'required|in:published,draft'
        ]);
        
        // Générer le slug
        $data['slug'] = self::generateSlug($data['title']);
        
        return self::create($data);
    }
    
    /**
     * Obtenir les pages publiées
     */
    public static function getPublished()
    {
        return self::where('status', 'published');
    }
    
    /**
     * Obtenir une page par slug
     */
    public static function getBySlugPublished($slug)
    {
        $db = Database::getInstance();
        
        $sql = "SELECT * FROM pages WHERE slug = ? AND status = 'published' LIMIT 1";
        $stmt = $db->query($sql, [$slug]);
        return $stmt->fetch();
    }
    
    /**
     * Obtenir les pages parentes
     */
    public static function getParents()
    {
        return self::where('parent_id', null);
    }
    
    /**
     * Obtenir les sous-pages d'une page
     */
    public static function getChildren($parentId)
    {
        return self::where('parent_id', $parentId);
    }
}