<?php
/**
 * Classe Validator - Validation des données
 */
class Validator
{
    private $errors = [];
    
    /**
     * Valider des données selon des règles
     */
    public static function validate($data, $rules)
    {
        $validator = new self();
        
        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;
            $fieldRules = explode('|', $fieldRules);
            
            foreach ($fieldRules as $rule) {
                $validator->applyRule($field, $value, $rule, $data);
            }
        }
        
        if (!empty($validator->errors)) {
            throw new ValidationException($validator->errors);
        }
        
        return true;
    }
    
    /**
     * Appliquer une règle de validation
     */
    private function applyRule($field, $value, $rule, $allData)
    {
        // Parser la règle (ex: min:3)
        $ruleParts = explode(':', $rule);
        $ruleName = $ruleParts[0];
        $ruleValue = $ruleParts[1] ?? null;
        
        switch ($ruleName) {
            case 'required':
                if (empty($value)) {
                    $this->addError($field, "Le champ {$field} est obligatoire");
                }
                break;
                
            case 'email':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "Le champ {$field} doit être un email valide");
                }
                break;
                
            case 'min':
                if (!empty($value) && strlen($value) < $ruleValue) {
                    $this->addError($field, "Le champ {$field} doit contenir au minimum {$ruleValue} caractères");
                }
                break;
                
            case 'max':
                if (!empty($value) && strlen($value) > $ruleValue) {
                    $this->addError($field, "Le champ {$field} doit contenir au maximum {$ruleValue} caractères");
                }
                break;
                
            case 'numeric':
                if (!empty($value) && !is_numeric($value)) {
                    $this->addError($field, "Le champ {$field} doit être numérique");
                }
                break;
                
            case 'integer':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_INT)) {
                    $this->addError($field, "Le champ {$field} doit être un entier");
                }
                break;
                
            case 'phone':
                if (!empty($value) && !preg_match('/^[0-9\s\.\-\+\(\)]+$/', $value)) {
                    $this->addError($field, "Le champ {$field} doit être un numéro de téléphone valide");
                }
                break;
                
            case 'url':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
                    $this->addError($field, "Le champ {$field} doit être une URL valide");
                }
                break;
                
            case 'date':
                if (!empty($value) && !strtotime($value)) {
                    $this->addError($field, "Le champ {$field} doit être une date valide");
                }
                break;
                
            case 'unique':
                // Format: unique:table,column
                $parts = explode(',', $ruleValue);
                $table = $parts[0];
                $column = $parts[1] ?? $field;
                $excludeId = $parts[2] ?? null;
                
                if (!empty($value) && $this->isUnique($table, $column, $value, $excludeId)) {
                    $this->addError($field, "Cette valeur existe déjà");
                }
                break;
                
            case 'confirmed':
                $confirmField = $field . '_confirmation';
                if ($value !== ($allData[$confirmField] ?? null)) {
                    $this->addError($field, "La confirmation ne correspond pas");
                }
                break;
                
            case 'in':
                $allowedValues = explode(',', $ruleValue);
                if (!empty($value) && !in_array($value, $allowedValues)) {
                    $this->addError($field, "La valeur n'est pas autorisée");
                }
                break;
        }
    }
    
    /**
     * Ajouter une erreur
     */
    private function addError($field, $message)
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        
        $this->errors[$field][] = $message;
    }
    
    /**
     * Vérifier l'unicité
     */
    private function isUnique($table, $column, $value, $excludeId = null)
    {
        $db = Database::getInstance();
        
        $sql = "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = ?";
        $params = [$value];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $stmt = $db->query($sql, $params);
        $result = $stmt->fetch();
        
        return $result['count'] > 0;
    }
    
    /**
     * Nettoyer les données
     */
    public static function sanitize($data)
    {
        if (is_array($data)) {
            return array_map([self::class, 'sanitize'], $data);
        }
        
        return trim(strip_tags($data));
    }
    
    /**
     * Valider un fichier uploadé
     */
    public static function validateFile($file, $rules = [])
    {
        $errors = [];
        
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            $errors[] = "Aucun fichier uploadé";
            return $errors;
        }
        
        // Vérifier la taille
        if (isset($rules['max_size']) && $file['size'] > $rules['max_size']) {
            $errors[] = "Le fichier est trop volumineux";
        }
        
        // Vérifier le type
        if (isset($rules['types'])) {
            $allowedTypes = $rules['types'];
            $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            
            if (!in_array($fileExt, $allowedTypes)) {
                $errors[] = "Type de fichier non autorisé";
            }
        }
        
        // Vérifier si c'est une image
        if (isset($rules['image']) && $rules['image']) {
            $imageInfo = getimagesize($file['tmp_name']);
            if (!$imageInfo) {
                $errors[] = "Le fichier n'est pas une image valide";
            }
        }
        
        return $errors;
    }
}

/**
 * Exception de validation
 */
class ValidationException extends Exception
{
    private $errors;
    
    public function __construct($errors)
    {
        $this->errors = $errors;
        parent::__construct('Erreur de validation');
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
}