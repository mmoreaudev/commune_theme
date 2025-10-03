<?php
/**
 * Classe Database - Gestion de la connexion SQLite
 */
class Database
{
    private static $instance = null;
    private $connection;
    
    private function __construct()
    {
        $dbPath = $_ENV['DB_PATH'] ?? __DIR__ . '/../../database/mairie.db';
        
        try {
            $this->connection = new PDO("sqlite:$dbPath");
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // Activer les foreign keys
            $this->connection->exec('PRAGMA foreign_keys = ON;');
            
        } catch (PDOException $e) {
            error_log("Erreur connexion DB: " . $e->getMessage());
            throw new Exception("Erreur de connexion à la base de données");
        }
    }
    
    /**
     * Obtenir l'instance singleton
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Obtenir la connexion PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }
    
    /**
     * Exécuter une requête préparée
     */
    public function query($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    /**
     * Obtenir un enregistrement par ID
     */
    public function find($table, $id)
    {
        $sql = "SELECT * FROM {$table} WHERE id = ? LIMIT 1";
        $stmt = $this->query($sql, [$id]);
        return $stmt->fetch();
    }
    
    /**
     * Obtenir tous les enregistrements d'une table
     */
    public function findAll($table, $orderBy = 'id', $order = 'ASC')
    {
        $sql = "SELECT * FROM {$table} ORDER BY {$orderBy} {$order}";
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Insérer un enregistrement
     */
    public function insert($table, $data)
    {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->query($sql, $data);
        
        return $this->connection->lastInsertId();
    }
    
    /**
     * Mettre à jour un enregistrement
     */
    public function update($table, $id, $data)
    {
        $setParts = [];
        foreach (array_keys($data) as $key) {
            $setParts[] = "{$key} = :{$key}";
        }
        $setClause = implode(', ', $setParts);
        
        $sql = "UPDATE {$table} SET {$setClause} WHERE id = :id";
        $data['id'] = $id;
        
        return $this->query($sql, $data);
    }
    
    /**
     * Supprimer un enregistrement
     */
    public function delete($table, $id)
    {
        $sql = "DELETE FROM {$table} WHERE id = ?";
        return $this->query($sql, [$id]);
    }
    
    /**
     * Compter les enregistrements
     */
    public function count($table, $conditions = [])
    {
        $sql = "SELECT COUNT(*) as count FROM {$table}";
        $params = [];
        
        if (!empty($conditions)) {
            $whereParts = [];
            foreach ($conditions as $column => $value) {
                $whereParts[] = "{$column} = :{$column}";
                $params[$column] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $whereParts);
        }
        
        $stmt = $this->query($sql, $params);
        $result = $stmt->fetch();
        
        return (int) $result['count'];
    }
    
    /**
     * Pagination
     */
    public function paginate($table, $page = 1, $perPage = 10, $conditions = [], $orderBy = 'id', $order = 'DESC')
    {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT * FROM {$table}";
        $params = [];
        
        if (!empty($conditions)) {
            $whereParts = [];
            foreach ($conditions as $column => $value) {
                $whereParts[] = "{$column} = :{$column}";
                $params[$column] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $whereParts);
        }
        
        $sql .= " ORDER BY {$orderBy} {$order} LIMIT {$perPage} OFFSET {$offset}";
        
        $stmt = $this->query($sql, $params);
        $items = $stmt->fetchAll();
        
        $total = $this->count($table, $conditions);
        $totalPages = ceil($total / $perPage);
        
        return [
            'items' => $items,
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages,
            'has_next' => $page < $totalPages,
            'has_prev' => $page > 1
        ];
    }
}