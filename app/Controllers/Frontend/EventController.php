<?php
/**
 * Contrôleur Event - Gestion des événements (Frontend)
 */
class EventController extends Controller
{
    /**
     * Liste des événements
     */
    public function index()
    {
        $page = (int) ($_GET['page'] ?? 1);
        $events = Event::paginate($page, 10, ['status' => 'published'], 'start_date', 'ASC');

        return $this->view('frontend.pages.events', [
            'title' => 'Événements - ' . setting('city_name'),
            'events' => $events
        ]);
    }

    /**
     * Afficher un événement
     */
    public function show()
    {
        $slug = $_GET[0] ?? null;

        if (!$slug) {
            http_response_code(404);
            return $this->view('frontend.pages.404');
        }

        $event = Event::whereFirst('slug', $slug);

        if (!$event) {
            http_response_code(404);
            return $this->view('frontend.pages.404');
        }

        return $this->view('frontend.pages.event-single', [
            'title' => $event['title'] . ' - ' . setting('city_name'),
            'event' => $event
        ]);
    }
}
