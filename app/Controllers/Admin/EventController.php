<?php
namespace Admin;

/**
 * Contrôleur Admin Event - Gestion des événements (Admin)
 */
class EventController extends \Controller
{
    /**
     * Liste des événements
     */
    public function index()
    {
        $page = (int) ($_GET['page'] ?? 1);
        $events = \\Event::paginate($page, 10, [], 'start_date', 'DESC');
        
        return $this->view('admin.pages.events.index', [
            'title' => 'Gestion des événements',
            'events' => $events
        ]);
    }
    
    /**
     * Formulaire de création d'événement
     */
    public function create()
    {
        return $this->view('admin.pages.events.create', [
            'title' => 'Nouvel événement'
        ]);
    }
    
    /**
     * Enregistrer un nouvel événement
     */
    public function store()
    {
        try {
            $data = $this->request()->all();
            $data['status'] = $data['status'] ?? 'published';
            
            $event = \Event::createEvent($data);
            
            return $this->redirect('/admin/events', 'Événement créé avec succès !', 'success');
            
        } catch (Exception $e) {
            return $this->redirect('/admin/events/create', 'Erreur lors de la création : ' . $e->getMessage(), 'error');
        }
    }
    
    /**
     * Formulaire d'édition d'événement
     */
    public function edit()
    {
        $id = $_GET[0] ?? null;
        
        if (!$id) {
            return $this->redirect('/admin/events', 'Événement introuvable', 'error');
        }
        
        $event = \Event::find($id);
        
        if (!$event) {
            return $this->redirect('/admin/events', 'Événement introuvable', 'error');
        }
        
        return $this->view('admin.pages.events.edit', [
            'title' => 'Modifier l\'événement',
            'event' => $event
        ]);
    }
    
    /**
     * Mettre à jour un événement
     */
    public function update()
    {
        $id = $_GET[0] ?? null;
        
        if (!$id) {
            return $this->redirect('/admin/events', 'Événement introuvable', 'error');
        }
        
        try {
            $data = $this->request()->all();
            \Event::update($id, $data);
            
            return $this->redirect('/admin/events', 'Événement mis à jour avec succès !', 'success');
            
        } catch (Exception $e) {
            return $this->redirect("/admin/events/{$id}/edit", 'Erreur lors de la mise à jour : ' . $e->getMessage(), 'error');
        }
    }
    
    /**
     * Supprimer un événement
     */
    public function delete()
    {
        $id = $_GET[0] ?? null;
        
        if (!$id) {
            return $this->redirect('/admin/events', 'Événement introuvable', 'error');
        }
        
        try {
            \Event::delete($id);
            return $this->redirect('/admin/events', 'Événement supprimé avec succès !', 'success');
            
        } catch (Exception $e) {
            return $this->redirect('/admin/events', 'Erreur lors de la suppression : ' . $e->getMessage(), 'error');
        }
    }
}
