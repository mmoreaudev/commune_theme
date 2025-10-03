<?php
/**
 * Contrôleur Team - Gestion de l'équipe municipale
 */
class TeamController extends Controller
{
    /**
     * Membres du conseil municipal
     */
    public function councilMembers()
    {
        $members = TeamMember::where('type', 'council');
        
        // Trier par ordre de priorité (maire, adjoints, conseillers)
        usort($members, function($a, $b) {
            $order = ['maire' => 1, 'adjoint' => 2, 'conseiller' => 3];
            $aOrder = $order[$a['role']] ?? 4;
            $bOrder = $order[$b['role']] ?? 4;
            
            if ($aOrder === $bOrder) {
                return $a['order_position'] <=> $b['order_position'];
            }
            
            return $aOrder <=> $bOrder;
        });
        
        return $this->view('frontend.pages.council-members', [
            'title' => 'Le Conseil Municipal - ' . setting('city_name'),
            'members' => $members
        ]);
    }
    
    /**
     * Équipe administrative
     */
    public function staff()
    {
        $staff = TeamMember::where('type', 'staff');
        
        return $this->view('frontend.pages.staff', [
            'title' => 'Équipe administrative - ' . setting('city_name'),
            'staff' => $staff
        ]);
    }
}