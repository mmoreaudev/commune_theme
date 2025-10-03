<?php
/**
 * Classe Model de base
 */
abstract class Model
{
    protected static $db;
    protected static $table;
    
    public function __construct()
    {
        if (!self::$db) {
            self::$db = Database::getInstance();
        }
    }
    
    /**
     * Obtenir tous les enregistrements
     */
    public static function all($orderBy = 'id', $order = 'ASC')
    {
        self::initDb();
        return self::$db->findAll(static::$table, $orderBy, $order);
    }
    
    /**
     * Trouver un enregistrement par ID
     */
    public static function find($id)
    {
        self::initDb();
        return self::$db->find(static::$table, $id);
    }
    
    /**
     * Trouver un enregistrement par condition
     */
    public static function where($column, $value)
    {
        self::initDb();
        $sql = "SELECT * FROM " . static::$table . " WHERE {$column} = ?";
        $stmt = self::$db->query($sql, [$value]);
        return $stmt->fetchAll();
    }
    
    /**
     * Trouver un seul enregistrement par condition
     */
    public static function whereFirst($column, $value)
    {
        self::initDb();
        $sql = "SELECT * FROM " . static::$table . " WHERE {$column} = ? LIMIT 1";
        $stmt = self::$db->query($sql, [$value]);
        return $stmt->fetch();
    }
    
    /**
     * Créer un nouvel enregistrement
     */
    public static function create($data)
    {
        self::initDb();
        
        // Ajouter les timestamps
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        if (!isset($data['updated_at'])) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        
        return self::$db->insert(static::$table, $data);
    }
    
    /**
     * Mettre à jour un enregistrement
     */
    public static function update($id, $data)
    {
        self::initDb();
        
        // Mettre à jour le timestamp
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return self::$db->update(static::$table, $id, $data);
    }
    
    /**
     * Supprimer un enregistrement
     */
    public static function delete($id)
    {
        self::initDb();
        return self::$db->delete(static::$table, $id);
    }
    
    /**
     * Compter les enregistrements
     */
    public static function count($conditions = [])
    {
        self::initDb();
        return self::$db->count(static::$table, $conditions);
    }
    
    /**
     * Pagination
     */
    public static function paginate($page = 1, $perPage = 10, $conditions = [], $orderBy = 'id', $order = 'DESC')
    {
        self::initDb();
        return self::$db->paginate(static::$table, $page, $perPage, $conditions, $orderBy, $order);
    }
    
    /**
     * Recherche
     */
    public static function search($query, $columns = [])
    {
        self::initDb();
        
        if (empty($columns)) {
            return [];
        }
        
        $whereParts = [];
        $params = [];
        
        foreach ($columns as $column) {
            $whereParts[] = "{$column} LIKE ?";
            $params[] = "%{$query}%";
        }
        
        $whereClause = implode(' OR ', $whereParts);
        $sql = "SELECT * FROM " . static::$table . " WHERE {$whereClause}";
        
        $stmt = self::$db->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    /**
     * Obtenir les enregistrements actifs
     */
    public static function active($orderBy = 'id', $order = 'ASC')
    {
        self::initDb();
        
        $sql = "SELECT * FROM " . static::$table . " WHERE is_active = 1 ORDER BY {$orderBy} {$order}";
        $stmt = self::$db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Obtenir par slug
     */
    public static function bySlug($slug)
    {
        return self::whereFirst('slug', $slug);
    }
    
    /**
     * Générer un slug unique
     */
    public static function generateSlug($title, $id = null)
    {
        $slug = Helper::slugify($title);
        $originalSlug = $slug;
        $counter = 1;
        
        while (self::slugExists($slug, $id)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
    
    /**
     * Vérifier si un slug existe
     */
    public static function slugExists($slug, $excludeId = null)
    {
        self::initDb();
        
        $sql = "SELECT COUNT(*) as count FROM " . static::$table . " WHERE slug = ?";
        $params = [$slug];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $stmt = self::$db->query($sql, $params);
        $result = $stmt->fetch();
        
        return $result['count'] > 0;
    }
    
    /**
     * Initialiser la base de données
     */
    private static function initDb()
    {
        if (!self::$db) {
            self::$db = Database::getInstance();
        }
    }
}