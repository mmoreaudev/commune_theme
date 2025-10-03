<?php
/**
 * Modèle ActivityLog - Logs d'activité
 */
class ActivityLog extends Model
{
    protected static $table = 'activity_logs';
    
    /**
     * Logger une activité
     */
    public static function log($action, $entityType = null, $entityId = null, $details = null)
    {
        $data = [
            'user_id' => Auth::check() ? Auth::user()['id'] : null,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'details' => $details,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null
        ];
        
        return self::create($data);
    }
    
    /**
     * Obtenir les logs récents
     */
    public static function getRecent($limit = 50)
    {
        $db = Database::getInstance();
        
        $sql = "SELECT al.*, u.username, u.full_name 
                FROM activity_logs al 
                LEFT JOIN users u ON al.user_id = u.id 
                ORDER BY al.created_at DESC 
                LIMIT {$limit}";
        
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Obtenir les logs par utilisateur
     */
    public static function getByUser($userId, $limit = 50)
    {
        $db = Database::getInstance();
        
        $sql = "SELECT * FROM activity_logs 
                WHERE user_id = ? 
                ORDER BY created_at DESC 
                LIMIT {$limit}";
        
        $stmt = $db->query($sql, [$userId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Nettoyer les anciens logs
     */
    public static function cleanup($daysOld = 90)
    {
        $db = Database::getInstance();
        
        $sql = "DELETE FROM activity_logs 
                WHERE created_at < datetime('now', '-{$daysOld} days')";
        
        return $db->query($sql);
    }
}