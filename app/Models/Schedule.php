<?php
/**
 * Modèle Schedule - Gestion des horaires
 */
class Schedule extends Model
{
    protected static $table = 'schedules';
    
    /**
     * Créer un horaire avec validation
     */
    public static function createSchedule($data)
    {
        // Valider les données
        Validator::validate($data, [
            'title' => 'required|min:2',
            'service_name' => 'required|min:2'
        ]);
        
        return self::create($data);
    }
    
    /**
     * Obtenir les horaires actifs
     */
    public static function getActive()
    {
        return self::active('title', 'ASC');
    }
}