<?php
/**
 * Contrôleur Page - Pages dynamiques
 */
class PageController extends Controller
{
    public function show()
    {
        $slug = $_GET[0] ?? null;

        if (!$slug) {
            http_response_code(404);
            return $this->view('frontend.pages.404');
        }

        $page = Page::bySlug($slug);

        if (!$page) {
            http_response_code(404);
            return $this->view('frontend.pages.404');
        }

        return $this->view('frontend.pages.page', [
            'title' => $page['title'] . ' - ' . setting('city_name'),
            'page' => $page
        ]);
    }

    public function yourMairie()
    {
        return $this->view('frontend.pages.your-mairie', [
            'title' => 'Votre Mairie - ' . setting('city_name')
        ]);
    }

    public function usefulNumbers()
    {
        $numbers = UsefulNumber::all();
        return $this->view('frontend.pages.useful-numbers', [
            'title' => 'Numéros utiles - ' . setting('city_name'),
            'numbers' => $numbers
        ]);
    }
}
