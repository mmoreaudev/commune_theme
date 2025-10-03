<?php
/**
 * Classe Upload - Gestion des uploads de fichiers
 */
class Upload
{
    private static $uploadDir = '/uploads/';
    
    /**
     * Uploader une image
     */
    public static function image($file, $directory = 'images', $maxSize = 5242880, $resize = true)
    {
        // Valider le fichier
        $errors = Validator::validateFile($file, [
            'max_size' => $maxSize,
            'types' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
            'image' => true
        ]);
        
        if (!empty($errors)) {
            throw new Exception(implode(', ', $errors));
        }
        
        // Générer un nom unique
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = uniqid() . '_' . time() . '.' . $extension;
        
        // Créer le répertoire de destination
        $uploadPath = self::getUploadPath($directory);
        self::createDirectory($uploadPath);
        
        $destination = $uploadPath . '/' . $filename;
        
        // Déplacer le fichier
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception("Erreur lors de l'upload");
        }
        
        // Redimensionner si nécessaire
        if ($resize && in_array($extension, ['jpg', 'jpeg', 'png'])) {
            self::resizeImage($destination, 1200, 800);
        }
        
        return self::$uploadDir . $directory . '/' . $filename;
    }
    
    /**
     * Uploader un document
     */
    public static function document($file, $directory = 'documents', $maxSize = 10485760)
    {
        // Valider le fichier
        $errors = Validator::validateFile($file, [
            'max_size' => $maxSize,
            'types' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'odt', 'ods']
        ]);
        
        if (!empty($errors)) {
            throw new Exception(implode(', ', $errors));
        }
        
        // Générer un nom unique
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = uniqid() . '_' . time() . '.' . $extension;
        
        // Créer le répertoire de destination
        $uploadPath = self::getUploadPath($directory);
        self::createDirectory($uploadPath);
        
        $destination = $uploadPath . '/' . $filename;
        
        // Déplacer le fichier
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception("Erreur lors de l'upload");
        }
        
        return self::$uploadDir . $directory . '/' . $filename;
    }
    
    /**
     * Supprimer un fichier
     */
    public static function delete($filePath)
    {
        if (!$filePath) {
            return true;
        }
        
        $fullPath = self::getPublicPath() . $filePath;
        
        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }
        
        return true;
    }
    
    /**
     * Redimensionner une image
     */
    private static function resizeImage($imagePath, $maxWidth, $maxHeight)
    {
        $imageInfo = getimagesize($imagePath);
        
        if (!$imageInfo) {
            return false;
        }
        
        list($width, $height, $type) = $imageInfo;
        
        // Vérifier si redimensionnement nécessaire
        if ($width <= $maxWidth && $height <= $maxHeight) {
            return true;
        }
        
        // Calculer les nouvelles dimensions
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = intval($width * $ratio);
        $newHeight = intval($height * $ratio);
        
        // Créer l'image source
        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($imagePath);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($imagePath);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($imagePath);
                break;
            default:
                return false;
        }
        
        // Créer l'image de destination
        $destination = imagecreatetruecolor($newWidth, $newHeight);
        
        // Préserver la transparence pour PNG
        if ($type === IMAGETYPE_PNG) {
            imagealphablending($destination, false);
            imagesavealpha($destination, true);
        }
        
        // Redimensionner
        imagecopyresampled(
            $destination, $source,
            0, 0, 0, 0,
            $newWidth, $newHeight,
            $width, $height
        );
        
        // Sauvegarder
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($destination, $imagePath, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($destination, $imagePath);
                break;
            case IMAGETYPE_GIF:
                imagegif($destination, $imagePath);
                break;
        }
        
        // Libérer la mémoire
        imagedestroy($source);
        imagedestroy($destination);
        
        return true;
    }
    
    /**
     * Obtenir le chemin d'upload
     */
    private static function getUploadPath($directory)
    {
        return self::getPublicPath() . self::$uploadDir . $directory;
    }
    
    /**
     * Obtenir le chemin public
     */
    private static function getPublicPath()
    {
        return __DIR__ . '/../../public';
    }
    
    /**
     * Créer un répertoire s'il n'existe pas
     */
    private static function createDirectory($path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }
    
    /**
     * Obtenir la taille formatée d'un fichier
     */
    public static function formatFileSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
    
    /**
     * Vérifier si un fichier est une image
     */
    public static function isImage($filePath)
    {
        $imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        
        return in_array($extension, $imageTypes);
    }
    
    /**
     * Obtenir l'icône d'un type de fichier
     */
    public static function getFileIcon($filePath)
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        
        $icons = [
            'pdf' => '📄',
            'doc' => '📝',
            'docx' => '📝',
            'xls' => '📊',
            'xlsx' => '📊',
            'jpg' => '🖼️',
            'jpeg' => '🖼️',
            'png' => '🖼️',
            'gif' => '🖼️',
            'zip' => '🗜️',
            'rar' => '🗜️',
        ];
        
        return $icons[$extension] ?? '📁';
    }
}