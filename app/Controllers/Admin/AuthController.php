<?php
namespace Admin;

/**
 * Contrôleur Auth Admin - Authentification
 */
class AuthController extends \Controller
{
    /**
     * Afficher la page de connexion
     */
    public function showLogin()
    {
        return $this->view('admin.pages.login', [
            'title' => 'Connexion - Administration'
        ]);
    }
    
    /**
     * Traiter la connexion
     */
    public function login()
    {
        try {
            $request = $this->request();
            
            // Validation
            $this->validate($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);
            
            $email = $request->get('email');
            $password = $request->get('password');
            
            // Vérification rate limiting
            if (!Auth::checkRateLimit($email)) {
                return $this->redirect('/admin/login', 'Trop de tentatives de connexion. Veuillez réessayer plus tard.', 'error');
            }
            
            // Tentative de connexion
            if (Auth::login($email, $password)) {
                // Réinitialiser les tentatives
                Auth::clearLoginAttempts($email);
                
                // Rediriger vers l'URL voulue ou dashboard
                $intendedUrl = Session::get('intended_url', '/admin');
                Session::forget('intended_url');
                
                return $this->redirect($intendedUrl, 'Connexion réussie !', 'success');
            } else {
                // Incrémenter les tentatives
                Auth::incrementLoginAttempts($email);
                
                return $this->redirect('/admin/login', 'Email ou mot de passe incorrect.', 'error');
            }
            
        } catch (ValidationException $e) {
            Session::flash('old', $request->all());
            Session::flash('errors', $e->getErrors());
            
            return $this->redirect('/admin/login', 'Veuillez corriger les erreurs ci-dessous.', 'error');
            
        } catch (Exception $e) {
            return $this->redirect('/admin/login', 'Une erreur est survenue. Veuillez réessayer.', 'error');
        }
    }
    
    /**
     * Déconnexion
     */
    public function logout()
    {
        Auth::logout();
        return $this->redirect('/', 'Vous avez été déconnecté.', 'success');
    }
}