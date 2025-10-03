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
     * Signature compatible avec Model::search($query, $columns = [])
     */
    public static function search($query, $columns = [])
    {
        if (empty($columns)) {
            $columns = ['name', 'description', 'responsible'];
        }
        return parent::search($query, $columns);
    }
}