<?php
/**
 * Modèle Widget - Gestion des widgets
 */
class Widget extends Model
{
    protected static $table = 'widgets';
    
    /**
     * Créer un widget avec validation
     */
    public static function createWidget($data)
    {
        // Valider les données
        Validator::validate($data, [
            'title' => 'required|min:2',
            'widget_type' => 'required|in:quick_links,emergency_numbers,schedule,featured_post,next_event,custom_html',
            'zone' => 'required'
        ]);
        
        return self::create($data);
    }
    
    /**
     * Obtenir les widgets d'une zone
     */
    public static function getByZone($zone)
    {
        $db = Database::getInstance();
        
        $sql = "SELECT * FROM widgets 
                WHERE zone = ? AND is_active = 1 
                ORDER BY order_position ASC";
        
        $stmt = $db->query($sql, [$zone]);
        return $stmt->fetchAll();
    }
    
    /**
     * Obtenir les types de widgets disponibles
     */
    public static function getTypes()
    {
        return [
            'quick_links' => 'Liens rapides',
            'emergency_numbers' => 'Numéros d\'urgence',
            'schedule' => 'Horaires',
            'featured_post' => 'Article mis en avant',
            'next_event' => 'Prochain événement',
            'custom_html' => 'HTML personnalisé'
        ];
    }
    
    /**
     * Obtenir les zones disponibles
     */
    public static function getZones()
    {
        return [
            'sidebar-main' => 'Sidebar principale',
            'sidebar-secondary' => 'Sidebar secondaire',
            'footer-1' => 'Footer colonne 1',
            'footer-2' => 'Footer colonne 2',
            'footer-3' => 'Footer colonne 3'
        ];
    }
}