<?php
/**
 * Contrôleur Home - Page d'accueil
 */
class HomeController extends Controller
{
    /**
     * Afficher la page d'accueil
     */
    public function index()
    {
        // Récupérer les dernières actualités
        $recentPosts = Post::getRecent(3);
        
        // Récupérer les prochains événements
        $upcomingEvents = Event::getUpcoming(3);
        
        // Statistiques du site
        $stats = [
            'posts_count' => Post::count(['status' => 'published']),
            'events_count' => Event::count(),
            'services_count' => Service::count(['is_active' => 1])
        ];
        
        return $this->view('frontend.pages.home', [
            'title' => setting('city_name') . ' - ' . setting('slogan'),
            'recentPosts' => $recentPosts,
            'upcomingEvents' => $upcomingEvents,
            'stats' => $stats
        ]);
    }
}