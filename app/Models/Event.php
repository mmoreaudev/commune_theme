<?php
/**
 * Modèle Event - Gestion des événements
 */
class Event extends Model
{
    protected static $table = 'events';
    
    /**
     * Créer un événement avec validation
     */
    public static function createEvent($data)
    {
        // Valider les données
        Validator::validate($data, [
            'title' => 'required|min:3',
            'description' => 'required|min:10',
            'start_date' => 'required|date',
            'location' => 'required|min:3'
        ]);
        
        // Générer le slug
        $data['slug'] = self::generateSlug($data['title']);
        
        return self::create($data);
    }
    
    /**
     * Obtenir les événements à venir
     */
    public static function getUpcoming($limit = null)
    {
        $db = Database::getInstance();
        
        $sql = "SELECT * FROM events 
                WHERE start_date >= datetime('now') 
                AND status = 'published' 
                ORDER BY start_date ASC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Obtenir les événements passés
     */
    public static function getPast($limit = null)
    {
        $db = Database::getInstance();
        
        $sql = "SELECT * FROM events 
                WHERE start_date < datetime('now') 
                AND status = 'published' 
                ORDER BY start_date DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Obtenir le prochain événement
     */
    public static function getNext()
    {
        $upcoming = self::getUpcoming(1);
        return !empty($upcoming) ? $upcoming[0] : null;
    }
    
    /**
     * Rechercher des événements
     * Signature compatible avec Model::search($query, $columns = [])
     */
    public static function search($query, $columns = [])
    {
        if (empty($columns)) {
            $columns = ['title', 'description', 'location'];
        }
        return parent::search($query, $columns);
    }
}