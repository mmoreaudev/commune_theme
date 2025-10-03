<?php
/**
 * Classe Auth - Gestion de l'authentification
 */
class Auth
{
    /**
     * Connecter un utilisateur
     */
    public static function login($email, $password)
    {
        $user = User::whereFirst('email', $email);
        
        if (!$user) {
            return false;
        }
        
        if (!$user['is_active']) {
            return false;
        }
        
        if (!password_verify($password, $user['password'])) {
            return false;
        }
        
        // Logger la connexion
        User::update($user['id'], [
            'last_login' => date('Y-m-d H:i:s')
        ]);
        
        // Créer la session
        Session::put('user_id', $user['id']);
        Session::put('user_role', $user['role']);
        Session::regenerate();
        
        // Logger l'activité
        ActivityLog::create([
            'user_id' => $user['id'],
            'action' => 'login',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        return true;
    }
    
    /**
     * Déconnecter l'utilisateur
     */
    public static function logout()
    {
        if (self::check()) {
            // Logger la déconnexion
            ActivityLog::create([
                'user_id' => self::user()['id'],
                'action' => 'logout',
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        Session::destroy();
    }
    
    /**
     * Vérifier si l'utilisateur est connecté
     */
    public static function check()
    {
        return Session::has('user_id');
    }
    
    /**
     * Obtenir l'utilisateur connecté
     */
    public static function user()
    {
        if (!self::check()) {
            return null;
        }
        
        static $user = null;
        
        if ($user === null) {
            $userId = Session::get('user_id');
            $user = User::find($userId);
        }
        
        return $user;
    }
    
    /**
     * Vérifier si l'utilisateur a un rôle
     */
    public static function hasRole($role)
    {
        if (!self::check()) {
            return false;
        }
        
        $user = self::user();
        
        if (!$user) {
            return false;
        }
        
        // Admin a tous les droits
        if ($user['role'] === 'admin') {
            return true;
        }
        
        return $user['role'] === $role;
    }
    
    /**
     * Vérifier si l'utilisateur peut éditer
     */
    public static function canEdit()
    {
        return self::hasRole('admin') || self::hasRole('editor');
    }
    
    /**
     * Vérifier si l'utilisateur peut supprimer
     */
    public static function canDelete()
    {
        return self::hasRole('admin');
    }
    
    /**
     * Créer un nouvel utilisateur
     */
    public static function register($data)
    {
        // Vérifier si l'email existe déjà
        if (User::whereFirst('email', $data['email'])) {
            throw new Exception('Cet email est déjà utilisé');
        }
        
        // Vérifier si le nom d'utilisateur existe déjà
        if (User::whereFirst('username', $data['username'])) {
            throw new Exception('Ce nom d\'utilisateur est déjà utilisé');
        }
        
        // Hasher le mot de passe
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        
        // Rôle par défaut
        if (!isset($data['role'])) {
            $data['role'] = 'viewer';
        }
        
        // Créer l'utilisateur
        $userId = User::create($data);
        
        // Logger l'activité
        ActivityLog::create([
            'user_id' => $userId,
            'action' => 'register',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        return $userId;
    }
    
    /**
     * Changer le mot de passe
     */
    public static function changePassword($userId, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        
        User::update($userId, [
            'password' => $hashedPassword
        ]);
        
        // Logger l'activité
        ActivityLog::create([
            'user_id' => $userId,
            'action' => 'password_changed',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        return true;
    }
    
    /**
     * Limitation des tentatives de connexion
     */
    public static function checkRateLimit($email)
    {
        $cacheKey = 'login_attempts_' . md5($email);
        $attempts = Session::get($cacheKey, 0);
        
        if ($attempts >= 5) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Incrémenter les tentatives de connexion
     */
    public static function incrementLoginAttempts($email)
    {
        $cacheKey = 'login_attempts_' . md5($email);
        $attempts = Session::get($cacheKey, 0);
        Session::put($cacheKey, $attempts + 1);
    }
    
    /**
     * Réinitialiser les tentatives de connexion
     */
    public static function clearLoginAttempts($email)
    {
        $cacheKey = 'login_attempts_' . md5($email);
        Session::forget($cacheKey);
    }
}