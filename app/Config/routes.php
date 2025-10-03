<?php
/**
 * Configuration routes du CMS Mairie
 */

// Routes Frontend (site public)
$router->get('/', 'HomeController@index');
$router->get('/actualites', 'PostController@index');
$router->get('/actualites/{slug}', 'PostController@show');
$router->get('/evenements', 'EventController@index');
$router->get('/evenements/{slug}', 'EventController@show');

// Votre Mairie
$router->get('/votre-mairie', 'PageController@yourMairie');
$router->get('/votre-mairie/conseil-municipal', 'TeamController@councilMembers');
$router->get('/votre-mairie/services', 'ServiceController@index');
$router->get('/votre-mairie/contact', 'ContactController@index');
$router->post('/votre-mairie/contact', 'ContactController@store', ['Csrf']);

// Publications
$router->get('/publications', 'DocumentController@index');
$router->get('/publications/bulletins', 'DocumentController@bulletins');
$router->get('/publications/magazines', 'DocumentController@magazines');
$router->get('/publications/deliberations', 'DocumentController@deliberations');
$router->get('/publications/download/{id}', 'DocumentController@download');

// Infos Pratiques
$router->get('/infos-pratiques', 'PageController@infos');
$router->get('/infos-pratiques/horaires', 'PageController@schedules');
$router->get('/infos-pratiques/demarches', 'PageController@demarches');
$router->get('/infos-pratiques/faq', 'PageController@faq');
$router->get('/infos-pratiques/numeros-utiles', 'PageController@usefulNumbers');

// Vie Locale
$router->get('/vie-locale', 'PageController@localLife');
$router->get('/vie-locale/associations', 'AssociationController@index');
$router->get('/vie-locale/evenements', 'EventController@localEvents');

// Pages dynamiques
$router->get('/page/{slug}', 'PageController@show');

// Recherche
$router->get('/recherche', 'SearchController@index');

// API/AJAX
$router->get('/api/search', 'SearchController@api');

// Routes Admin (panel d'administration)
$router->get('/admin', 'Admin\DashboardController@index', ['Auth']);
$router->get('/admin/login', 'Admin\AuthController@showLogin', ['Guest']);
$router->post('/admin/login', 'Admin\AuthController@login', ['Guest', 'Csrf']);
$router->get('/admin/logout', 'Admin\AuthController@logout', ['Auth']);

// Dashboard
$router->get('/admin/dashboard', 'Admin\DashboardController@index', ['Auth']);

// Gestion des actualités
$router->get('/admin/posts', 'Admin\PostController@index', ['Auth']);
$router->get('/admin/posts/create', 'Admin\PostController@create', ['Auth']);
$router->post('/admin/posts', 'Admin\PostController@store', ['Auth', 'Csrf']);
$router->get('/admin/posts/{id}/edit', 'Admin\PostController@edit', ['Auth']);
$router->post('/admin/posts/{id}', 'Admin\PostController@update', ['Auth', 'Csrf']);
$router->post('/admin/posts/{id}/delete', 'Admin\PostController@delete', ['Auth', 'Csrf']);

// Gestion des événements
$router->get('/admin/events', 'Admin\EventController@index', ['Auth']);
$router->get('/admin/events/create', 'Admin\EventController@create', ['Auth']);
$router->post('/admin/events', 'Admin\EventController@store', ['Auth', 'Csrf']);
$router->get('/admin/events/{id}/edit', 'Admin\EventController@edit', ['Auth']);
$router->post('/admin/events/{id}', 'Admin\EventController@update', ['Auth', 'Csrf']);
$router->post('/admin/events/{id}/delete', 'Admin\EventController@delete', ['Auth', 'Csrf']);

// Gestion de l'équipe
$router->get('/admin/team', 'Admin\TeamController@index', ['Auth']);
$router->get('/admin/team/create', 'Admin\TeamController@create', ['Auth']);
$router->post('/admin/team', 'Admin\TeamController@store', ['Auth', 'Csrf']);
$router->get('/admin/team/{id}/edit', 'Admin\TeamController@edit', ['Auth']);
$router->post('/admin/team/{id}', 'Admin\TeamController@update', ['Auth', 'Csrf']);
$router->post('/admin/team/{id}/delete', 'Admin\TeamController@delete', ['Auth', 'Csrf']);

// Gestion des documents
$router->get('/admin/documents', 'Admin\DocumentController@index', ['Auth']);
$router->get('/admin/documents/create', 'Admin\DocumentController@create', ['Auth']);
$router->post('/admin/documents', 'Admin\DocumentController@store', ['Auth', 'Csrf']);
$router->get('/admin/documents/{id}/edit', 'Admin\DocumentController@edit', ['Auth']);
$router->post('/admin/documents/{id}', 'Admin\DocumentController@update', ['Auth', 'Csrf']);
$router->post('/admin/documents/{id}/delete', 'Admin\DocumentController@delete', ['Auth', 'Csrf']);

// Gestion des services
$router->get('/admin/services', 'Admin\ServiceController@index', ['Auth']);
$router->get('/admin/services/create', 'Admin\ServiceController@create', ['Auth']);
$router->post('/admin/services', 'Admin\ServiceController@store', ['Auth', 'Csrf']);
$router->get('/admin/services/{id}/edit', 'Admin\ServiceController@edit', ['Auth']);
$router->post('/admin/services/{id}', 'Admin\ServiceController@update', ['Auth', 'Csrf']);
$router->post('/admin/services/{id}/delete', 'Admin\ServiceController@delete', ['Auth', 'Csrf']);

// Gestion des numéros utiles
$router->get('/admin/useful-numbers', 'Admin\UsefulNumberController@index', ['Auth']);
$router->get('/admin/useful-numbers/create', 'Admin\UsefulNumberController@create', ['Auth']);
$router->post('/admin/useful-numbers', 'Admin\UsefulNumberController@store', ['Auth', 'Csrf']);
$router->get('/admin/useful-numbers/{id}/edit', 'Admin\UsefulNumberController@edit', ['Auth']);
$router->post('/admin/useful-numbers/{id}', 'Admin\UsefulNumberController@update', ['Auth', 'Csrf']);
$router->post('/admin/useful-numbers/{id}/delete', 'Admin\UsefulNumberController@delete', ['Auth', 'Csrf']);

// Gestion des associations
$router->get('/admin/associations', 'Admin\AssociationController@index', ['Auth']);
$router->get('/admin/associations/create', 'Admin\AssociationController@create', ['Auth']);
$router->post('/admin/associations', 'Admin\AssociationController@store', ['Auth', 'Csrf']);
$router->get('/admin/associations/{id}/edit', 'Admin\AssociationController@edit', ['Auth']);
$router->post('/admin/associations/{id}', 'Admin\AssociationController@update', ['Auth', 'Csrf']);
$router->post('/admin/associations/{id}/delete', 'Admin\AssociationController@delete', ['Auth', 'Csrf']);

// Gestion des pages
$router->get('/admin/pages', 'Admin\PageController@index', ['Auth']);
$router->get('/admin/pages/create', 'Admin\PageController@create', ['Auth']);
$router->post('/admin/pages', 'Admin\PageController@store', ['Auth', 'Csrf']);
$router->get('/admin/pages/{id}/edit', 'Admin\PageController@edit', ['Auth']);
$router->post('/admin/pages/{id}', 'Admin\PageController@update', ['Auth', 'Csrf']);
$router->post('/admin/pages/{id}/delete', 'Admin\PageController@delete', ['Auth', 'Csrf']);

// Gestion des FAQs
$router->get('/admin/faqs', 'Admin\FaqController@index', ['Auth']);
$router->get('/admin/faqs/create', 'Admin\FaqController@create', ['Auth']);
$router->post('/admin/faqs', 'Admin\FaqController@store', ['Auth', 'Csrf']);
$router->get('/admin/faqs/{id}/edit', 'Admin\FaqController@edit', ['Auth']);
$router->post('/admin/faqs/{id}', 'Admin\FaqController@update', ['Auth', 'Csrf']);
$router->post('/admin/faqs/{id}/delete', 'Admin\FaqController@delete', ['Auth', 'Csrf']);

// Gestion des démarches
$router->get('/admin/demarches', 'Admin\DemarcheController@index', ['Auth']);
$router->get('/admin/demarches/create', 'Admin\DemarcheController@create', ['Auth']);
$router->post('/admin/demarches', 'Admin\DemarcheController@store', ['Auth', 'Csrf']);
$router->get('/admin/demarches/{id}/edit', 'Admin\DemarcheController@edit', ['Auth']);
$router->post('/admin/demarches/{id}', 'Admin\DemarcheController@update', ['Auth', 'Csrf']);
$router->post('/admin/demarches/{id}/delete', 'Admin\DemarcheController@delete', ['Auth', 'Csrf']);

// Gestion des horaires
$router->get('/admin/schedules', 'Admin\ScheduleController@index', ['Auth']);
$router->get('/admin/schedules/create', 'Admin\ScheduleController@create', ['Auth']);
$router->post('/admin/schedules', 'Admin\ScheduleController@store', ['Auth', 'Csrf']);
$router->get('/admin/schedules/{id}/edit', 'Admin\ScheduleController@edit', ['Auth']);
$router->post('/admin/schedules/{id}', 'Admin\ScheduleController@update', ['Auth', 'Csrf']);
$router->post('/admin/schedules/{id}/delete', 'Admin\ScheduleController@delete', ['Auth', 'Csrf']);

// Gestion des widgets
$router->get('/admin/widgets', 'Admin\WidgetController@index', ['Auth']);
$router->get('/admin/widgets/create', 'Admin\WidgetController@create', ['Auth']);
$router->post('/admin/widgets', 'Admin\WidgetController@store', ['Auth', 'Csrf']);
$router->get('/admin/widgets/{id}/edit', 'Admin\WidgetController@edit', ['Auth']);
$router->post('/admin/widgets/{id}', 'Admin\WidgetController@update', ['Auth', 'Csrf']);
$router->post('/admin/widgets/{id}/delete', 'Admin\WidgetController@delete', ['Auth', 'Csrf']);

// Gestion des messages de contact
$router->get('/admin/contact-messages', 'Admin\ContactMessageController@index', ['Auth']);
$router->get('/admin/contact-messages/{id}', 'Admin\ContactMessageController@show', ['Auth']);
$router->post('/admin/contact-messages/{id}/mark-read', 'Admin\ContactMessageController@markRead', ['Auth', 'Csrf']);
$router->post('/admin/contact-messages/{id}/mark-replied', 'Admin\ContactMessageController@markReplied', ['Auth', 'Csrf']);
$router->post('/admin/contact-messages/{id}/archive', 'Admin\ContactMessageController@archive', ['Auth', 'Csrf']);

// Gestion des utilisateurs (admin uniquement)
$router->get('/admin/users', 'Admin\UserController@index', ['Admin']);
$router->get('/admin/users/create', 'Admin\UserController@create', ['Admin']);
$router->post('/admin/users', 'Admin\UserController@store', ['Admin', 'Csrf']);
$router->get('/admin/users/{id}/edit', 'Admin\UserController@edit', ['Admin']);
$router->post('/admin/users/{id}', 'Admin\UserController@update', ['Admin', 'Csrf']);
$router->post('/admin/users/{id}/delete', 'Admin\UserController@delete', ['Admin', 'Csrf']);

// Paramètres (admin uniquement)
$router->get('/admin/settings', 'Admin\SettingController@index', ['Admin']);
$router->get('/admin/settings/general', 'Admin\SettingController@general', ['Admin']);
$router->post('/admin/settings/general', 'Admin\SettingController@updateGeneral', ['Admin', 'Csrf']);
$router->get('/admin/settings/appearance', 'Admin\SettingController@appearance', ['Admin']);
$router->post('/admin/settings/appearance', 'Admin\SettingController@updateAppearance', ['Admin', 'Csrf']);

// Profil utilisateur
$router->get('/admin/profile', 'Admin\UserController@profile', ['Auth']);
$router->post('/admin/profile', 'Admin\UserController@updateProfile', ['Auth', 'Csrf']);
$router->post('/admin/profile/password', 'Admin\UserController@updatePassword', ['Auth', 'Csrf']);