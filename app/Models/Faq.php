<?php
/**
 * Modèle Faq - Gestion des questions fréquentes
 */
class Faq extends Model
{
    protected static $table = 'faqs';
    
    /**
     * Créer une FAQ avec validation
     */
    public static function createFaq($data)
    {
        // Valider les données
        Validator::validate($data, [
            'question' => 'required|min:5',
            'answer' => 'required|min:10'
        ]);
        
        return self::create($data);
    }
    
    /**
     * Obtenir les FAQs par catégorie
     */
    public static function getByCategory($category)
    {
        return self::where('category', $category);
    }
    
    /**
     * Obtenir toutes les FAQs groupées par catégorie
     */
    public static function getAllGrouped()
    {
        $faqs = self::active('order_position', 'ASC');
        $grouped = [];
        
        foreach ($faqs as $faq) {
            $category = $faq['category'] ?? 'general';
            $grouped[$category][] = $faq;
        }
        
        return $grouped;
    }
    
    /**
     * Rechercher dans les FAQs
     * Signature compatible avec Model::search($query, $columns = [])
     */
    public static function search($query, $columns = [])
    {
        if (empty($columns)) {
            $columns = ['question', 'answer'];
        }
        return parent::search($query, $columns);
    }
}