<?php
/**
 * Modèle Category - Gestion des catégories
 */
class Category extends Model
{
    protected static $table = 'categories';
    
    /**
     * Créer une catégorie avec validation
     */
    public static function createCategory($data)
    {
        // Valider les données
        Validator::validate($data, [
            'name' => 'required|min:2',
            'description' => 'required|min:10'
        ]);
        
        // Générer le slug
        $data['slug'] = self::generateSlug($data['name']);
        
        return self::create($data);
    }
    
    /**
     * Obtenir les catégories avec le nombre d'articles
     */
    public static function getWithPostCount()
    {
        $db = Database::getInstance();
        
        $sql = "SELECT c.*, COUNT(p.id) as post_count 
                FROM categories c 
                LEFT JOIN posts p ON c.id = p.category_id AND p.status = 'published'
                GROUP BY c.id 
                ORDER BY c.name";
        
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Obtenir les catégories parentes
     */
    public static function getParents()
    {
        return self::where('parent_id', null);
    }
    
    /**
     * Obtenir les sous-catégories d'une catégorie
     */
    public static function getChildren($parentId)
    {
        return self::where('parent_id', $parentId);
    }
}