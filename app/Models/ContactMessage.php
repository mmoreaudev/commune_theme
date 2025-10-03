<?php
/**
 * Modèle ContactMessage - Gestion des messages de contact
 */
class ContactMessage extends Model
{
    protected static $table = 'contact_messages';
    
    /**
     * Créer un message de contact avec validation
     */
    public static function createMessage($data)
    {
        // Valider les données
        Validator::validate($data, [
            'name' => 'required|min:2',
            'email' => 'required|email',
            'subject' => 'required|min:3',
            'message' => 'required|min:10'
        ]);
        
        // Ajouter l'IP
        $data['ip_address'] = $_SERVER['REMOTE_ADDR'] ?? null;
        
        return self::create($data);
    }
    
    /**
     * Obtenir les messages par statut
     */
    public static function getByStatus($status)
    {
        return self::where('status', $status);
    }
    
    /**
     * Obtenir les nouveaux messages
     */
    public static function getNew()
    {
        return self::getByStatus('new');
    }
    
    /**
     * Marquer comme lu
     */
    public static function markAsRead($id)
    {
        return self::update($id, ['status' => 'read']);
    }
    
    /**
     * Marquer comme répondu
     */
    public static function markAsReplied($id)
    {
        return self::update($id, ['status' => 'replied']);
    }
    
    /**
     * Archiver un message
     */
    public static function archive($id)
    {
        return self::update($id, ['status' => 'archived']);
    }
    
    /**
     * Obtenir les statistiques des messages
     */
    public static function getStats()
    {
        $db = Database::getInstance();
        
        $stats = [];
        
        // Total messages
        $stats['total'] = self::count();
        
        // Par statut
        $stmt = $db->query("SELECT status, COUNT(*) as count FROM contact_messages GROUP BY status");
        $statusStats = $stmt->fetchAll();
        
        foreach ($statusStats as $status) {
            $stats['status'][$status['status']] = $status['count'];
        }
        
        // Messages du mois
        $stmt = $db->query("SELECT COUNT(*) as count FROM contact_messages WHERE created_at >= date('now', 'start of month')");
        $result = $stmt->fetch();
        $stats['this_month'] = $result['count'];
        
        return $stats;
    }
}