<?php
/**
 * Modèle Document - Gestion des publications
 */
class Document extends Model
{
    protected static $table = 'documents';
    
    /**
     * Créer un document avec validation
     */
    public static function createDocument($data)
    {
        // Valider les données
        Validator::validate($data, [
            'title' => 'required|min:3',
            'file_path' => 'required',
            'document_type' => 'required|in:bulletin,magazine,deliberation,other'
        ]);
        
        // Générer le slug
        $data['slug'] = self::generateSlug($data['title']);
        
        return self::create($data);
    }
    
    /**
     * Obtenir les documents par type
     */
    public static function getByType($type)
    {
        return self::where('document_type', $type);
    }
    
    /**
     * Obtenir les documents publics
     */
    public static function getPublic($limit = null)
    {
        $db = Database::getInstance();
        
        $sql = "SELECT * FROM documents 
                WHERE is_public = 1 
                ORDER BY publication_date DESC, created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Incrémenter le nombre de téléchargements
     */
    public static function incrementDownloads($id)
    {
        $db = Database::getInstance();
        $sql = "UPDATE documents SET downloads = downloads + 1 WHERE id = ?";
        $db->query($sql, [$id]);
    }
    
    /**
     * Obtenir les types de documents
     */
    public static function getTypes()
    {
        return [
            'bulletin' => 'Bulletin Municipal',
            'magazine' => 'Magazine',
            'deliberation' => 'Délibération',
            'other' => 'Autre'
        ];
    }
}