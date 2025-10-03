-- Données par défaut pour le CMS Mairie
-- Date: 2025-10-03

-- Paramètres généraux du site
INSERT OR IGNORE INTO settings (setting_key, setting_value, setting_type, setting_group) VALUES
('city_name', 'Ma Commune', 'text', 'general'),
('slogan', 'Bienvenue dans notre commune', 'text', 'general'),
('address', '1 Place de la Mairie', 'text', 'general'),
('postal_code', '75000', 'text', 'general'),
('city', 'Paris', 'text', 'general'),
('phone', '01 23 45 67 89', 'text', 'general'),
('email', 'contact@mairie.fr', 'email', 'general'),
('opening_hours', 'Lundi-Vendredi: 9h-12h, 14h-17h\nSamedi: 9h-12h (sur rendez-vous)', 'textarea', 'general'),
('facebook', '', 'url', 'social'),
('twitter', '', 'url', 'social'),
('instagram', '', 'url', 'social'),
('youtube', '', 'url', 'social'),
('site_description', 'Site officiel de la commune', 'textarea', 'seo'),
('site_keywords', 'mairie, commune, municipalité', 'text', 'seo');

-- Catégories par défaut
INSERT OR IGNORE INTO categories (name, slug, description) VALUES
('Actualités générales', 'actualites-generales', 'Toutes les actualités de la commune'),
('Conseil Municipal', 'conseil-municipal', 'Actualités du conseil municipal'),
('Travaux', 'travaux', 'Informations sur les travaux en cours'),
('Événements', 'evenements', 'Les événements de la commune'),
('Vie associative', 'vie-associative', 'Actualités des associations locales');

-- Widgets par défaut
INSERT OR IGNORE INTO widgets (title, widget_type, content, zone, order_position, is_active) VALUES
('Liens pratiques', 'quick_links', '{"links":[{"title":"Horaires","url":"/horaires"},{"title":"Contact","url":"/contact"},{"title":"Démarches","url":"/demarches"},{"title":"Numéros utiles","url":"/numeros-utiles"}]}', 'sidebar-main', 1, 1),
('Numéros d''urgence', 'emergency_numbers', '{"numbers":[{"name":"Pompiers","phone":"18"},{"name":"Police","phone":"17"},{"name":"SAMU","phone":"15"},{"name":"Mairie","phone":"01 23 45 67 89"}]}', 'sidebar-main', 2, 1),
('Horaires d''ouverture', 'schedule', '{"schedule":{"lundi":"9h-12h, 14h-17h","mardi":"9h-12h, 14h-17h","mercredi":"9h-12h","jeudi":"9h-12h, 14h-17h","vendredi":"9h-12h, 14h-17h","samedi":"Sur rendez-vous","dimanche":"Fermé"}}', 'sidebar-main', 3, 1);

-- Pages par défaut
INSERT OR IGNORE INTO pages (title, slug, content, template, status) VALUES
('Mentions légales', 'mentions-legales', '<h2>Mentions légales</h2><p>Conformément aux dispositions des articles 6-III et 19 de la loi n° 2004-575 du 21 juin 2004 pour la Confiance dans l''économie numérique, dite L.C.E.N.</p>', 'default', 'published'),
('Politique de confidentialité', 'politique-confidentialite', '<h2>Politique de confidentialité</h2><p>Cette page décrit notre politique de confidentialité concernant les données personnelles.</p>', 'default', 'published'),
('Accessibilité', 'accessibilite', '<h2>Déclaration d''accessibilité</h2><p>Cette déclaration d''accessibilité s''applique au site web de la commune.</p>', 'default', 'published');

-- Numéros utiles par défaut
INSERT OR IGNORE INTO useful_numbers (category, name, phone, email, address, order_position) VALUES
('urgences', 'Pompiers', '18', '', '', 1),
('urgences', 'Police', '17', '', '', 2),
('urgences', 'SAMU', '15', '', '', 3),
('urgences', 'Numéro d''urgence européen', '112', '', '', 4),
('services_publics', 'Mairie', '01 23 45 67 89', 'contact@mairie.fr', '1 Place de la Mairie', 1),
('services_publics', 'Préfecture', '01 23 45 67 90', '', '', 2),
('sante', 'Centre médical', '01 23 45 67 91', '', '5 rue de la Santé', 1),
('sante', 'Pharmacie', '01 23 45 67 92', '', '10 rue principale', 2);

-- FAQ par défaut
INSERT OR IGNORE INTO faqs (question, answer, category, order_position) VALUES
('Comment obtenir un certificat d''urbanisme ?', 'Vous devez déposer une demande en mairie avec les pièces justificatives requises. Le délai de traitement est de 2 mois.', 'urbanisme', 1),
('Quels sont les horaires d''ouverture de la mairie ?', 'La mairie est ouverte du lundi au vendredi de 9h à 12h et de 14h à 17h. Le samedi matin sur rendez-vous uniquement.', 'general', 1),
('Comment s''inscrire sur les listes électorales ?', 'Vous pouvez vous inscrire en ligne sur service-public.fr ou directement en mairie avec une pièce d''identité et un justificatif de domicile.', 'elections', 1);

-- Démarches par défaut
INSERT OR IGNORE INTO demarches (title, description, required_documents, procedure, contact_service, delay, cost, category, order_position) VALUES
('Carte d''identité', 'Demande ou renouvellement de carte nationale d''identité', 'Formulaire de demande, photo d''identité, justificatif de domicile, acte de naissance', 'Prendre rendez-vous en mairie, déposer le dossier complet, retirer la carte sur présentation du récépissé', 'État civil', '3 semaines', 'Gratuit (1ère demande)', 'etat_civil', 1),
('Passeport', 'Demande ou renouvellement de passeport', 'Formulaire de demande, photo d''identité, justificatif de domicile, ancienne carte d''identité', 'Prendre rendez-vous en mairie, déposer le dossier complet avec timbres fiscaux', 'État civil', '3 semaines', '86€ (adulte)', 'etat_civil', 2),
('Certificat d''urbanisme', 'Renseignement sur les règles d''urbanisme applicables à un terrain', 'Formulaire de demande, plan de situation du terrain', 'Déposer le dossier en mairie ou l''envoyer par courrier', 'Urbanisme', '2 mois', 'Gratuit', 'urbanisme', 1);

-- Horaires par défaut
INSERT OR IGNORE INTO schedules (title, service_name, monday, tuesday, wednesday, thursday, friday, saturday, sunday, is_active) VALUES
('Horaires Mairie', 'Accueil général', '9h-12h / 14h-17h', '9h-12h / 14h-17h', '9h-12h', '9h-12h / 14h-17h', '9h-12h / 14h-17h', 'Sur RDV', 'Fermé', 1),
('État Civil', 'Service État Civil', '9h-12h / 14h-16h', '9h-12h / 14h-16h', '9h-12h', '9h-12h / 14h-16h', '9h-12h / 14h-16h', '9h-12h', 'Fermé', 1);

-- Services municipaux par défaut
INSERT OR IGNORE INTO services (name, slug, description, responsible, email, phone, order_position, is_active) VALUES
('État Civil', 'etat-civil', 'Délivrance des actes d''état civil, cartes d''identité, passeports', 'Marie MARTIN', 'etatcivil@mairie.fr', '01 23 45 67 89', 1, 1),
('Urbanisme', 'urbanisme', 'Certificats d''urbanisme, permis de construire, déclarations de travaux', 'Pierre DURAND', 'urbanisme@mairie.fr', '01 23 45 67 90', 2, 1),
('Action Sociale', 'action-sociale', 'Aide sociale, logement, insertion professionnelle', 'Sophie BERNARD', 'social@mairie.fr', '01 23 45 67 91', 3, 1);

-- Exemple d'article
INSERT OR IGNORE INTO posts (title, slug, content, excerpt, status, category_id, views, published_at) VALUES
('Bienvenue sur le nouveau site de la commune', 'bienvenue-nouveau-site', '<p>Nous sommes heureux de vous présenter le nouveau site internet de notre commune.</p><p>Ce site a été conçu pour vous offrir un accès simple et rapide à toutes les informations utiles de votre commune.</p><p>Vous y trouverez :</p><ul><li>Les actualités municipales</li><li>Les démarches administratives</li><li>Les horaires des services</li><li>Les contacts utiles</li><li>Les événements à venir</li></ul><p>N''hésitez pas à nous faire part de vos remarques et suggestions.</p>', 'Découvrez le nouveau site internet de la commune avec toutes les informations pratiques et actualités municipales.', 'published', 1, 0, '2025-10-03 12:00:00');

-- Exemple d'événement
INSERT OR IGNORE INTO events (title, slug, description, location, start_date, end_date, status, organizer) VALUES
('Marché de Noël', 'marche-de-noel', 'Venez découvrir notre traditionnel marché de Noël avec ses nombreux exposants locaux.', 'Place de la Mairie', '2025-12-15 10:00:00', '2025-12-15 18:00:00', 'published', 'Commune');