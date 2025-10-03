<?php
/**
 * Modèle Demarche - Gestion des démarches administratives
 */
class Demarche extends Model
{
    protected static $table = 'demarches';
    
    /**
     * Créer une démarche avec validation
     */
    public static function createDemarche($data)
    {
        // Valider les données
        Validator::validate($data, [
            'title' => 'required|min:3',
            'description' => 'required|min:10',
            'procedure' => 'required|min:10'
        ]);
        
        return self::create($data);
    }
    
    /**
     * Obtenir les démarches par catégorie
     */
    public static function getByCategory($category)
    {
        return self::where('category', $category);
    }
    
    /**
     * Obtenir toutes les démarches groupées par catégorie
     */
    public static function getAllGrouped()
    {
        $demarches = self::active('order_position', 'ASC');
        $grouped = [];
        
        foreach ($demarches as $demarche) {
            $category = $demarche['category'] ?? 'autres';
            $grouped[$category][] = $demarche;
        }
        
        return $grouped;
    }
    
    /**
     * Rechercher dans les démarches
     * Signature compatible avec Model::search($query, $columns = [])
     */
    public static function search($query, $columns = [])
    {
        if (empty($columns)) {
            $columns = ['title', 'description', 'procedure'];
        }
        return parent::search($query, $columns);
    }
}