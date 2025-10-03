<?php
/**
 * Modèle Service - Gestion des services municipaux
 */
class Service extends Model
{
    protected static $table = 'services';
    
    /**
     * Créer un service avec validation
     */
    public static function createService($data)
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
     * Rechercher des services
     */
    public static function search($query)
    {
        return parent::search($query, ['name', 'description', 'responsible']);
    }
}