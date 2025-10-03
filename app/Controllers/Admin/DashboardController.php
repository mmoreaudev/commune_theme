<?php
/**
 * Contrôleur Dashboard Admin
 */
class DashboardController extends Controller
{
    /**
     * Afficher le tableau de bord
     */
    public function index()
    {
        // Statistiques générales
        $stats = [
            'posts' => Post::getStats(),
            'events' => [
                'total' => Event::count(),
                'upcoming' => count(Event::getUpcoming())
            ],
            'messages' => ContactMessage::getStats(),
            'users' => User::getStats()
        ];
        
        // Activités récentes
        $recentActivities = ActivityLog::getRecent(10);
        
        // Derniers messages de contact
        $recentMessages = ContactMessage::getByStatus('new');
        $recentMessages = array_slice($recentMessages, 0, 5);
        
        // Articles populaires
        $popularPosts = Post::all();
        usort($popularPosts, function($a, $b) {
            return $b['views'] <=> $a['views'];
        });
        $popularPosts = array_slice($popularPosts, 0, 5);
        
        // Prochains événements
        $upcomingEvents = Event::getUpcoming(5);
        
        return $this->view('admin.pages.dashboard', [
            'title' => 'Tableau de bord',
            'stats' => $stats,
            'recentActivities' => $recentActivities,
            'recentMessages' => $recentMessages,
            'popularPosts' => $popularPosts,
            'upcomingEvents' => $upcomingEvents
        ]);
    }
}