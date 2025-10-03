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
    
    public function demarches()
    {
        $demarches = Demarche::getAllGrouped();
        return $this->view('frontend.pages.demarches', [
            'title' => 'Démarches administratives - ' . setting('city_name'),
            'demarches' => $demarches
        ]);
    }
    
    public function infos()
    {
        return $this->view('frontend.pages.infos-pratiques', [
            'title' => 'Infos pratiques - ' . setting('city_name')
        ]);
    }
    
    public function schedules()
    {
        $schedules = Schedule::all();
        return $this->view('frontend.pages.schedules', [
            'title' => 'Horaires - ' . setting('city_name'),
            'schedules' => $schedules
        ]);
    }
    
    public function faq()
    {
        $faqs = Faq::getAllGrouped();
        return $this->view('frontend.pages.faq', [
            'title' => 'FAQ - ' . setting('city_name'),
            'faqs' => $faqs
        ]);
    }
    
    public function localLife()
    {
        return $this->view('frontend.pages.local-life', [
            'title' => 'Vie locale - ' . setting('city_name')
        ]);
    }
}
