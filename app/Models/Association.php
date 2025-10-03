<?php
/**
 * Modèle Association - Gestion des associations
 */
class Association extends Model
{
    protected static $table = 'associations';
    
    /**
     * Créer une association avec validation
     */
    public static function createAssociation($data)
    {
        // Valider les données
        Validator::validate($data, [
            'name' => 'required|min:2',
            'description' => 'required|min:10',
            'category' => 'required|in:sport,culture,social,environnement,education,autre'
        ]);
        
        // Générer le slug
        $data['slug'] = self::generateSlug($data['name']);
        
        return self::create($data);
    }
    
    /**
     * Obtenir les associations par catégorie
     */
    public static function getByCategory($category)
    {
        return self::where('category', $category);
    }
    
    /**
     * Obtenir toutes les associations groupées par catégorie
     */
    public static function getAllGrouped()
    {
        $associations = self::active('name', 'ASC');
        $grouped = [];
        
        foreach ($associations as $association) {
            $grouped[$association['category']][] = $association;
        }
        
        return $grouped;
    }
    
    /**
     * Obtenir les catégories disponibles
     */
    public static function getCategories()
    {
        return [
            'sport' => 'Sport',
            'culture' => 'Culture',
            'social' => 'Social',
            'environnement' => 'Environnement',
            'education' => 'Éducation',
            'autre' => 'Autre'
        ];
    }
}