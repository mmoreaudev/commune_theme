<?php
/**
 * Modèle Setting - Gestion des paramètres
 */
class Setting extends Model
{
    protected static $table = 'settings';
    
    /**
     * Obtenir un paramètre par clé
     */
    public static function get($key, $default = null)
    {
        $setting = self::whereFirst('setting_key', $key);
        return $setting ? $setting['setting_value'] : $default;
    }
    
    /**
     * Définir un paramètre
     */
    public static function set($key, $value, $type = 'text', $group = 'general')
    {
        $existing = self::whereFirst('setting_key', $key);
        
        if ($existing) {
            return self::update($existing['id'], [
                'setting_value' => $value,
                'setting_type' => $type,
                'setting_group' => $group
            ]);
        } else {
            return self::create([
                'setting_key' => $key,
                'setting_value' => $value,
                'setting_type' => $type,
                'setting_group' => $group
            ]);
        }
    }
    
    /**
     * Obtenir tous les paramètres d'un groupe
     */
    public static function getByGroup($group)
    {
        return self::where('setting_group', $group);
    }
    
    /**
     * Obtenir tous les paramètres sous forme de tableau key => value
     */
    public static function getAllAsArray()
    {
        $settings = self::all();
        $array = [];
        
        foreach ($settings as $setting) {
            $array[$setting['setting_key']] = $setting['setting_value'];
        }
        
        return $array;
    }
}