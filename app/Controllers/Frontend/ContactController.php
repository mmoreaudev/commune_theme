<?php
/**
 * Contrôleur Contact - Gestion du formulaire de contact
 */
class ContactController extends Controller
{
    /**
     * Afficher le formulaire de contact
     */
    public function index()
    {
        // Récupérer les services pour les contacts
        $services = Service::active();
        
        return $this->view('frontend.pages.contact', [
            'title' => 'Contact - ' . setting('city_name'),
            'services' => $services
        ]);
    }
    
    /**
     * Traiter l'envoi du formulaire
     */
    public function store()
    {
        try {
            $request = $this->request();
            
            // Validation et création du message
            $messageId = ContactMessage::createMessage($request->all());
            
            // Logger l'activité
            ActivityLog::log('contact_message_sent', 'contact_message', $messageId, 'Nouveau message de contact reçu');
            
            // Message de succès
            return $this->redirect('/votre-mairie/contact', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.', 'success');
            
        } catch (ValidationException $e) {
            // Sauvegarder les anciennes données
            Session::flash('old', $this->request()->all());
            Session::flash('errors', $e->getErrors());
            
            return $this->redirect('/votre-mairie/contact', 'Veuillez corriger les erreurs ci-dessous.', 'error');
            
        } catch (Exception $e) {
            return $this->redirect('/votre-mairie/contact', 'Une erreur est survenue. Veuillez réessayer.', 'error');
        }
    }
}