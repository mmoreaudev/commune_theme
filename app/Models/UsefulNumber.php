<?php
/**
 * Modèle UsefulNumber - Gestion des numéros utiles
 */
class UsefulNumber extends Model
{
    protected static $table = 'useful_numbers';
    
    /**
     * Créer un numéro utile avec validation
     */
    public static function createNumber($data)
    {
        // Valider les données
        Validator::validate($data, [
            'category' => 'required|in:urgences,sante,commerces,artisans,services_publics,autres',
            'name' => 'required|min:2',
            'phone' => 'required|phone'
        ]);
        
        return self::create($data);
    }
    
    /**
     * Obtenir les numéros par catégorie
     */
    public static function getByCategory($category)
    {
        return self::where('category', $category);
    }
    
    /**
     * Obtenir tous les numéros groupés par catégorie
     */
    public static function getAllGrouped()
    {
        $numbers = self::active('order_position', 'ASC');
        $grouped = [];
        
        foreach ($numbers as $number) {
            $grouped[$number['category']][] = $number;
        }
        
        return $grouped;
    }
    
    /**
     * Obtenir les catégories disponibles
     */
    public static function getCategories()
    {
        return [
            'urgences' => 'Numéros d\'urgence',
            'sante' => 'Santé',
            'services_publics' => 'Services publics',
            'commerces' => 'Commerces',
            'artisans' => 'Artisans',
            'autres' => 'Autres'
        ];
    }
    
    /**
     * Obtenir le nom de la catégorie
     */
    public static function getCategoryName($category)
    {
        $categories = self::getCategories();
        return $categories[$category] ?? $category;
    }
}