<?php
/**
 * Contrôleur Admin ContactMessage - Gestion des messages de contact (Admin)
 */
class ContactMessageController extends Controller
{
    /**
     * Liste des messages de contact
     */
    public function index()
    {
        $page = (int) ($_GET['page'] ?? 1);
        $status = $_GET['status'] ?? 'all';
        
        $conditions = [];
        if ($status !== 'all') {
            $conditions['status'] = $status;
        }
        
        $messages = ContactMessage::paginate($page, 15, $conditions, 'created_at', 'DESC');
        
        return $this->view('admin.pages.contact-messages.index', [
            'title' => 'Messages de contact',
            'messages' => $messages,
            'currentStatus' => $status
        ]);
    }
    
    /**
     * Afficher un message de contact
     */
    public function show()
    {
        $id = $_GET[0] ?? null;
        
        if (!$id) {
            return $this->redirect('/admin/contact-messages', 'Message introuvable', 'error');
        }
        
        $message = ContactMessage::find($id);
        
        if (!$message) {
            return $this->redirect('/admin/contact-messages', 'Message introuvable', 'error');
        }
        
        // Marquer comme lu si nouveau
        if ($message['status'] === 'new') {
            ContactMessage::update($id, ['status' => 'read']);
        }
        
        return $this->view('admin.pages.contact-messages.show', [
            'title' => 'Détail du message',
            'message' => $message
        ]);
    }
    
    /**
     * Marquer un message comme lu
     */
    public function markRead()
    {
        $id = $_GET[0] ?? null;
        
        if (!$id) {
            return $this->redirect('/admin/contact-messages', 'Message introuvable', 'error');
        }
        
        try {
            ContactMessage::update($id, ['status' => 'read']);
            return $this->redirect('/admin/contact-messages', 'Message marqué comme lu', 'success');
            
        } catch (Exception $e) {
            return $this->redirect('/admin/contact-messages', 'Erreur lors de la mise à jour', 'error');
        }
    }
    
    /**
     * Marquer un message comme traité
     */
    public function markReplied()
    {
        $id = $_GET[0] ?? null;
        
        if (!$id) {
            return $this->redirect('/admin/contact-messages', 'Message introuvable', 'error');
        }
        
        try {
            ContactMessage::update($id, ['status' => 'replied']);
            return $this->redirect('/admin/contact-messages', 'Message marqué comme traité', 'success');
            
        } catch (Exception $e) {
            return $this->redirect('/admin/contact-messages', 'Erreur lors de la mise à jour', 'error');
        }
    }
    
    /**
     * Archiver un message
     */
    public function archive()
    {
        $id = $_GET[0] ?? null;
        
        if (!$id) {
            return $this->redirect('/admin/contact-messages', 'Message introuvable', 'error');
        }
        
        try {
            ContactMessage::update($id, ['status' => 'archived']);
            return $this->redirect('/admin/contact-messages', 'Message archivé', 'success');
            
        } catch (Exception $e) {
            return $this->redirect('/admin/contact-messages', 'Erreur lors de l\'archivage', 'error');
        }
    }
}