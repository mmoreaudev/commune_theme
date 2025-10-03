<?php
/**
 * Modèle TeamMember - Gestion des élus et employés
 */
class TeamMember extends Model
{
    protected static $table = 'team_members';
    
    /**
     * Créer un membre de l'équipe avec validation
     */
    public static function createMember($data)
    {
        // Valider les données
        Validator::validate($data, [
            'full_name' => 'required|min:2',
            'position' => 'required|min:2',
            'role_type' => 'required|in:maire,adjoint,conseiller,employe'
        ]);
        
        return self::create($data);
    }
    
    /**
     * Obtenir les membres par type de rôle
     */
    public static function getByRoleType($roleType)
    {
        return self::where('role_type', $roleType);
    }
    
    /**
     * Obtenir tous les membres organisés par rôle
     */
    public static function getAllOrganized()
    {
        $members = self::active('order_position', 'ASC');
        $organized = [];
        
        foreach ($members as $member) {
            $organized[$member['role_type']][] = $member;
        }
        
        return $organized;
    }
    
    /**
     * Obtenir les types de rôles
     */
    public static function getRoleTypes()
    {
        return [
            'maire' => 'Maire',
            'adjoint' => 'Adjoint au Maire',
            'conseiller' => 'Conseiller Municipal',
            'employe' => 'Employé Municipal'
        ];
    }
}