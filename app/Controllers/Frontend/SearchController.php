<?php
/**
 * Contrôleur Search - Recherche
 */
class SearchController extends Controller
{
    /**
     * Page de recherche
     */
    public function index()
    {
        $query = $_GET['q'] ?? '';
        $results = [];
        
        if (!empty($query)) {
            // Rechercher dans les posts
            $posts = Post::search($query, ['title', 'content', 'excerpt']);
            foreach ($posts as $post) {
                $results[] = [
                    'type' => 'article',
                    'title' => $post['title'],
                    'url' => '/actualites/' . $post['slug'],
                    'excerpt' => $post['excerpt'] ?? excerpt($post['content']),
                    'date' => $post['published_at'] ?? $post['created_at']
                ];
            }
            
            // Rechercher dans les événements
            $events = Event::search($query, ['title', 'description', 'location']);
            foreach ($events as $event) {
                $results[] = [
                    'type' => 'événement',
                    'title' => $event['title'],
                    'url' => '/evenements/' . $event['slug'],
                    'excerpt' => $event['description'],
                    'date' => $event['start_date'] ?? $event['created_at']
                ];
            }
            
            // Rechercher dans les pages
            if (class_exists('Page')) {
                $pages = Page::search($query, ['title', 'content']);
                foreach ($pages as $page) {
                    $results[] = [
                        'type' => 'page',
                        'title' => $page['title'],
                        'url' => '/page/' . $page['slug'],
                        'excerpt' => excerpt($page['content']),
                        'date' => $page['updated_at'] ?? $page['created_at']
                    ];
                }
            }
        }
        
        return $this->view('frontend.pages.search', [
            'title' => 'Recherche - ' . setting('city_name'),
            'query' => $query,
            'results' => $results
        ]);
    }
    
    /**
     * API de recherche (AJAX)
     */
    public function api()
    {
        header('Content-Type: application/json');
        
        $query = $_GET['q'] ?? '';
        $results = [];
        
        if (!empty($query) && strlen($query) >= 2) {
            // Recherche rapide dans les titres seulement
            $posts = Post::search($query, ['title']);
            foreach (array_slice($posts, 0, 5) as $post) {
                $results[] = [
                    'title' => $post['title'],
                    'url' => '/actualites/' . $post['slug'],
                    'type' => 'article'
                ];
            }
            
            $events = Event::search($query, ['title']);
            foreach (array_slice($events, 0, 3) as $event) {
                $results[] = [
                    'title' => $event['title'],
                    'url' => '/evenements/' . $event['slug'],
                    'type' => 'événement'
                ];
            }
        }
        
        echo json_encode($results);
        exit;
    }
}