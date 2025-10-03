<?php
/**
 * Modèle User - Gestion des utilisateurs
 */
class User extends Model
{
    protected static $table = 'users';
    
    /**
     * Créer un utilisateur avec validation
     */
    public static function createUser($data)
    {
        // Valider les données
        Validator::validate($data, [
            'username' => 'required|min:3|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'full_name' => 'required|min:2',
            'role' => 'required|in:admin,editor,viewer'
        ]);
        
        // Hasher le mot de passe
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        
        return self::create($data);
    }
    
    /**
     * Mettre à jour un utilisateur
     */
    public static function updateUser($id, $data)
    {
        $rules = [
            'username' => 'required|min:3|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'full_name' => 'required|min:2',
            'role' => 'required|in:admin,editor,viewer'
        ];
        
        // Si le mot de passe est fourni
        if (!empty($data['password'])) {
            $rules['password'] = 'required|min:6';
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']);
        }
        
        Validator::validate($data, $rules);
        
        return self::update($id, $data);
    }
    
    /**
     * Obtenir les utilisateurs actifs
     */
    public static function getActive()
    {
        return self::where('is_active', 1);
    }
    
    /**
     * Obtenir les utilisateurs par rôle
     */
    public static function getByRole($role)
    {
        return self::where('role', $role);
    }
    
    /**
     * Obtenir les statistiques des utilisateurs
     */
    public static function getStats()
    {
        $db = Database::getInstance();
        
        $stats = [];
        
        // Total utilisateurs
        $stats['total'] = self::count();
        
        // Utilisateurs actifs
        $stats['active'] = self::count(['is_active' => 1]);
        
        // Par rôle
        $stmt = $db->query("SELECT role, COUNT(*) as count FROM users GROUP BY role");
        $roleStats = $stmt->fetchAll();
        
        foreach ($roleStats as $role) {
            $stats['roles'][$role['role']] = $role['count'];
        }
        
        // Dernières connexions
        $stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE last_login >= datetime('now', '-30 days')");
        $result = $stmt->fetch();
        $stats['active_last_month'] = $result['count'];
        
        return $stats;
    }
    
    /**
     * Rechercher des utilisateurs
     * Signature compatible avec Model::search($query, $columns = [])
     */
    public static function search($query, $columns = [])
    {
        if (empty($columns)) {
            $columns = ['username', 'email', 'full_name'];
        }
        return parent::search($query, $columns);
    }
}