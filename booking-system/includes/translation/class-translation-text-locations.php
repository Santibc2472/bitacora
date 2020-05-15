<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.8
* File                    : includes/translation/class-translation-text-locations.php
* File Version            : 1.0.1
* Created / Last Modified : 17 March 2016
* Author                  : Dot on Paper
* Copyright               : © 2016 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Locations translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextLocations')){
        class DOPBSPTranslationTextLocations{
            /*
             * Constructor
             */
            function __construct(){
                /*
                 * Initialize locations text.
                 */
                add_filter('dopbsp_filter_translation_text', array(&$this, 'locations'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'locationsLocation'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'locationsAddLocation'));
                add_filter('dopbsp_filter_translation_text', array(&$this, 'locationsDeleteLocation'));
                
                add_filter('dopbsp_filter_translation_text', array(&$this, 'locationsHelp'));
            }
            
            /*
             * Locations text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function locations($text){
                array_push($text, array('key' => 'PARENT_LOCATIONS',
                                        'parent' => '',
                                        'text' => 'Locations'));
                
                array_push($text, array('key' => 'LOCATIONS_TITLE',
                                        'parent' => 'PARENT_LOCATIONS',
                                        'text' => 'Locations',
                                        'de' => 'Standorten', // !
                                        'es' => 'Ubicaciones', // !
                                        'fr' => 'Emplacements')); //!
                array_push($text, array('key' => 'LOCATIONS_CREATED_BY',
                                        'parent' => 'PARENT_LOCATIONS',
                                        'text' => 'Created by',
                                        'de' => 'Erstellt von', // !
                                        'es' => 'Creada por', // !
                                        'fr' => 'Créé par')); //!
                array_push($text, array('key' => 'LOCATIONS_LOAD_SUCCESS',
                                        'parent' => 'PARENT_LOCATIONS',
                                        'text' => 'Locations list loaded.',
                                        'de' => 'Standortliste geladen.', // !
                                        'es' => 'La lista de ubicaciones cargó.', // !
                                        'fr' => 'La liste d<<single-quote>>emplacements a chargé.')); //!
                array_push($text, array('key' => 'LOCATIONS_NO_LOCATIONS',
                                        'parent' => 'PARENT_LOCATIONS',
                                        'text' => 'No locations. Click the above "plus" icon to add a new one.',
                                        'de' => 'Keine Standorte. Klicken Sie auf das obige "Plus"-Symbol, um ein neues hinzuzufügen.', // !
                                        'es' => 'No hay ubicaciones. Haga clic en el icono "plus" de arriba para agregar uno nuevo.', // !
                                        'fr' => 'Aucun emplacement. Cliquez sur l<<single-quote>>icône "plus" ci-dessus pour en ajouter une nouvelle.')); //!
                
                return $text;
            }
            
            /*
             * Locations - Location text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function locationsLocation($text){
                array_push($text, array('key' => 'PARENT_LOCATIONS_LOCATION',
                                        'parent' => '',
                                        'text' => 'Locations - Location'));
                
                array_push($text, array('key' => 'LOCATIONS_LOCATION_NAME',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'Name',
                                        'de' => 'Name', // !
                                        'es' => 'Nombre', // !
                                        'fr' => 'Nom')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_MAP',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'Enter the address',
                                        'de' => 'Geben Sie die Adresse', // !
                                        'es' => 'Introducir la dirección', // !
                                        'fr' => 'Entrer l<<single-quote>>adresse')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_ADDRESS',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'Address',
                                        'de' => 'Adresse', // !
                                        'es' => 'Dirección', // !
                                        'fr' => 'Adresse')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_ALT_ADDRESS',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'Alternative address',
                                        'de' => 'Alternative Adresse', // !
                                        'es' => 'Dirección alternativa', // !
                                        'fr' => 'Autre adresse')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_CALENDARS',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'Add calendars to location',
                                        'de' => 'Kalender zum Speicherort hinzufügen', // !
                                        'es' => 'Añadir calendarios a la ubicación', // !
                                        'fr' => 'Ajouter des calendriers à l<<single-quote>>emplacement')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_NO_CALENDARS',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'There are no calendars created. Go to <a href="%s">calendars</a> page to create one.',
                                        'de' => 'Es wurden keine Kalender erstellt. Gehen Sie zur <a href="%s">Kalenderseite</a>, um eine zu erstellen.', // !
                                        'es' => 'No hay calendarios creados. Vaya a la página <a href="%s">calendarios</a>, para crear uno.', // !
                                        'fr' => 'Aucun calendrier n<<single-quote>>est créé. Allez à la page <a href="%s">calendriers</a> pour en créer un.')); //!
		
                array_push($text, array('key' => 'LOCATIONS_LOCATION_SHARE',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'Share your location with ',
                                        'de' => 'Teilen Sie Ihren Standort mit ', // !
                                        'es' => 'Comparta su ubicación con ', // !
                                        'fr' => 'Partagez votre emplacement avec ')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_LINK',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'Enter the link of your site',
                                        'de' => 'Geben Sie den Link Ihrer Website ein', // !
                                        'es' => 'Introduzca el link de su sitio', // !
                                        'fr' => 'Entrez le lien de votre site')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_IMAGE',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'Enter a link with an image',
                                        'de' => 'Geben Sie einen Link mit einem Bild ein', // !
                                        'es' => 'Introduzca un link con una imagen', // !
                                        'fr' => 'Entrer un lien avec une image')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESSES',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'Select what kind of businesses you have at this location',
                                        'de' => 'Wählen Sie aus, welche Art von Unternehmen Sie an diesem Standort haben', // !
                                        'es' => 'Seleccione qué tipo de negocios tiene en esta ubicación', // !
                                        'fr' => 'Sélectionnez le type d<<single-quote>>entreprises que vous avez à cet endroit')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESSES_OTHER',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'Enter businesses that are not in the list',
                                        'de' => 'Geben Sie Unternehmen ein, die nicht in der Liste aufgeführt sind', // !
                                        'es' => 'Introduzca los negocios que no están en la lista', // !
                                        'fr' => 'Entrez les entreprises qui ne sont pas dans la liste')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_LANGUAGES',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'Enter the languages that are spoken in your business',
                                        'de' => 'Geben Sie die Sprachen ein, die in Ihrem Unternehmen gesprochen werden', // !
                                        'es' => 'Introduzca los idiomas que se hablan en su negocio', // !
                                        'fr' => 'Entrez les langues parlées dans votre entreprise')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_EMAIL',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'Your email',
                                        'de' => 'Ihre E-Mail', // !
                                        'es' => 'Su correo electrónico', // !
                                        'fr' => 'Votre courrier électronique')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_SHARE_SUBMIT',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'Share to PINPOINT.WORLD',
                                        'de' => 'An PINPOINT.WORLD freigeben', // !
                                        'es' => 'Compartir con PINPOINT.WORLD', // !
                                        'fr' => 'Partager avec PINPOINT.WORLD')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_SHARE_SUBMIT_SUCCESS',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'Your location has been sent to PINPOINT.WORLD',
                                        'de' => 'Ihr Standort wurde an PINPOINT.WORLD gesendet', // !
                                        'es' => 'Su ubicación ha sido enviada a PINPOINT.WORLD', // !
                                        'fr' => 'Votre emplacement a été envoyé à PINPOINT.WORLD')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_SHARE_SUBMIT_ERROR',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'Please complete all location data. Only alternative address is mandatory and you need to select a business or enter another business.',
                                        'de' => 'Bitte füllen Sie alle Standortdaten aus. Es ist nur eine alternative Adresse erforderlich, und Sie müssen ein Unternehmen auswählen oder ein anderes Unternehmen eingeben.', // !
                                        'es' => 'Complete todos los datos de ubicación. Sólo la dirección alternativa es obligatoria y usted necesita para seleccionar un negocio o entrar en otro negocio.', // !
                                        'fr' => 'Veuillez remplir toutes les données sur l<<single-quote>>emplacement. Seule une autre adresse est obligatoire et vous devez sélectionner une entreprise ou entrer une autre entreprise.')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_SHARE_SUBMIT_ERROR_DUPLICATE',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'The location has already been submitted to PINPOINT.WORLD',
                                        'de' => 'Der Standort wurde bereits an PINPOINT.WORLD übermittelt', // !
                                        'es' => 'La ubicación ya ha sido enviada a PINPOINT.WORLD', // !
                                        'fr' => 'L<<single-quote>>emplacement a déjà été soumis à PINPOINT.WORLD')); //!
		
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_APARTMENT',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Apartment',
                                        'de' => 'Wohnung', // !
                                        'es' => 'Apartamento', // !
                                        'fr' => 'Appartement')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_BABY_SITTER',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Babysitter',
                                        'de' => 'Babysitter', // !
                                        'es' => 'Niñera', // !
                                        'fr' => 'Baby-sitter')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_BAR',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Bar',
                                        'de' => 'Bar', // !
                                        'es' => 'Bar', // !
                                        'fr' => 'Bar')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_BASKETBALL_COURT',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Basketball court(s)',
                                        'de' => 'Basketballplatz', // !
                                        'es' => 'Tribunal(es) de baloncesto', // !
                                        'fr' => 'Terrain(s) de basket-ball')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_BEAUTY_SALON',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Beauty salon',
                                        'de' => 'Schönheitssalon', // !
                                        'es' => 'Salón de belleza', // !
                                        'fr' => 'Salon de beauté')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_BIKES',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Bikes',
                                        'de' => 'Fahrräder', // !
                                        'es' => 'Bicicletas', // !
                                        'fr' => 'Vélos')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_BOAT',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Boat',
                                        'de' => 'Boot', // !
                                        'es' => 'Barco', // !
                                        'fr' => 'Bateau')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_BUSINESS',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Business',
                                        'de' => 'Unternehmen', // !
                                        'es' => 'Negocio', // !
                                        'fr' => 'Entreprise')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_CAMPING',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Camping',
                                        'de' => 'Camping', // !
                                        'es' => 'Camping', // !
                                        'fr' => 'Camping')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_CAMPING_GEAR',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Camping gear',
                                        'de' => 'Campingausrüstung', // !
                                        'es' => 'Equipo de camping', // !
                                        'fr' => 'Matériel de camping')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_CARS',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Cars',
                                        'de' => 'Wagen', // !
                                        'es' => 'Coches', // !
                                        'fr' => 'Voitures')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_CHEF',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Chef',
                                        'de' => 'Koch', // !
                                        'es' => 'Cocinero', // !
                                        'fr' => 'Chef')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_CINEMA',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Cinema',
                                        'de' => 'Kino', // !
                                        'es' => 'Cine', // !
                                        'fr' => 'Cinéma')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_CLOTHES',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Clothes',
                                        'de' => 'Kleidung', // !
                                        'es' => 'Ropa', // !
                                        'fr' => 'Vêtement')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_COSTUMES',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Costumes',
                                        'de' => 'Kostüme', // !
                                        'es' => 'Trajes', // !
                                        'fr' => 'Costumes')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_CLUB',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                       
					'text' => 'Club',
                                        'de' => 'Club', // !
                                        'es' => 'Club', // !
                                        'fr' => 'Club')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_DANCE_INSTRUCTOR',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Dance instructor',
                                        'de' => 'Tanzlehrer', // !
                                        'es' => 'Instructor de baile', // !
                                        'fr' => 'Professeur de danse')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_DENTIST',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Dentist',
                                        'de' => 'Zahnarzt', // !
                                        'es' => 'Dentista', // !
                                        'fr' => 'Dentiste')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_DESIGNER_HANDBAGS',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Designer handbags',
                                        'de' => 'Designer-Handtaschen', // !
                                        'es' => 'Bolsos de diseño', // !
                                        'fr' => 'Sacs à main de concepteur')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_DOCTOR',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Doctor',
                                        'de' => 'Doktor', // !
                                        'es' => 'Doctor', // !
                                        'fr' => 'Docteur')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_ESTHETICIAN',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Esthetician',
                                        'de' => 'Kosmetikerin', // !
                                        'es' => 'Esteticista', // !
                                        'fr' => 'Esthéticienne')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_FOOTBALL_COURT',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Football court(s)',
                                        'de' => 'Fußballplatz', // !
                                        'es' => 'Tribunal(es) de fútbol', // !
                                        'fr' => 'Terrain(s) de football')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_FISHING',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Fishing',
                                        'de' => 'Fischerei', // !
                                        'es' => 'Pesca', // !
                                        'fr' => 'Pêche')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_GADGETS',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Gadgets',
                                        'de' => 'Gadgets', // !
                                        'es' => 'Gadgets', // !
                                        'fr' => 'Gadgets')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_GAMES',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Games',
                                        'de' => 'Spiele', // !
                                        'es' => 'Juegos', // !
                                        'fr' => 'Jeux')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_GOLF',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Golf',
                                        'de' => 'Golf', // !
                                        'es' => 'Golf', // !
                                        'fr' => 'Golf')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_HAIRDRESSER',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Hairdresser',
                                        'de' => 'Friseur', // !
                                        'es' => 'Peluquería', // !
                                        'fr' => 'Coiffeur')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_HEALTH_CLUB',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Health club',
                                        'de' => 'Health Club', // !
                                        'es' => 'Gimnasio', // !
                                        'fr' => 'Centre de santé')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_HOSPITAL',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Hospital',
                                        'de' => 'Krankenhaus', // !
                                        'es' => 'hospital', // !
                                        'fr' => 'Hôpital')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_HOTEL',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Hotel',
                                        'de' => 'Hotel', // !
                                        'es' => 'Hotel', // !
                                        'fr' => 'Hôtel')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_HUNTING',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Hunting',
                                        'de' => 'Jagen', // !
                                        'es' => 'Caza', // !
                                        'fr' => 'Chasser')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_LAWYER',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Lawyer',
                                        'de' => 'Anwalt', // !
                                        'es' => 'Abogado', // !
                                        'fr' => 'Avocat')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_LIBRARY',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Library',
                                        'de' => 'Bibliothek', // !
                                        'es' => 'Biblioteca', // !
                                        'fr' => 'Bibliothèque')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_MASSAGE',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Massage',
                                        'de' => 'Massage', // !
                                        'es' => 'Masaje', // !
                                        'fr' => 'Massage')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_MUSIC_BAND',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Music band',
                                        'de' => 'Musikband', // !
                                        'es' => 'Banda de música', // !
                                        'fr' => 'Bande de musique')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_NAILS_SALON',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Nails salon',
                                        'de' => 'Nägel Salon', // !
                                        'es' => 'Salón de uñas', // !
                                        'fr' => 'Salon de manucure')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_PARTY_SUPPLIES',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Party supplies',
                                        'de' => 'Partyzubehör', // !
                                        'es' => 'Suministros para fiestas', // !
                                        'fr' => 'Provisions de parti')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_PERSONAL_TRAINER',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Personal trainer',
                                        'de' => 'Personal Trainer', // !
                                        'es' => 'Entrenador personal', // !
                                        'fr' => 'Coach sportif')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_PET_CARE',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Pet care',
                                        'de' => 'Tierpflege', // !
                                        'es' => 'Cuidado de mascotas', // !
                                        'fr' => 'Soins des animaux')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_PHOTO_EQUIPMENT',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Photo equipment',
                                        'de' => 'Fotoausrüstung', // !
                                        'es' => 'Equipo fotográfico', // !
                                        'fr' => 'Appareil photo')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_PHOTOGRAPHER',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Photographer',
                                        'de' => 'Fotograf', // !
                                        'es' => 'Fotógrafo', // !
                                        'fr' => 'Photographe')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_PILLATES_INSTRUCTOR',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Pilates instructor',
                                        'de' => 'Pilates-Lehrerin', // !
                                        'es' => 'Instructor de Pilates', // !
                                        'fr' => 'Instructeur de Pilates')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_PLANE_TICKETS',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Plane tickets',
                                        'de' => 'Flugtickets', // !
                                        'es' => 'Billetes de avión', // !
                                        'fr' => 'Billets d<<single-quote>>avion')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_PLANES',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Plane(s)',
                                        'de' => 'Flugzeug', // !
                                        'es' => 'Avión(es)', // !
                                        'fr' => 'Avion(s)')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_RESTAURANT',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Restaurant',
                                        'de' => 'Restaurant', // !
                                        'es' => 'Restaurante', // !
                                        'fr' => 'Restaurant')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_SHOES',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Shoes',
                                        'de' => 'Schuhe', // !
                                        'es' => 'Zapatos', // !
                                        'fr' => 'Chaussures')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_SNOW_EQUIPMENT',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Snow equipment',
                                        'de' => 'Schnee-Ausrüstung', // !
                                        'es' => 'Equipo de nieve', // !
                                        'fr' => 'Équipement de neige')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_SPA',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Spa',
                                        'de' => 'Spa', // !
                                        'es' => 'Spa', // !
                                        'fr' => 'Station thermale')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_SPORTS_COACH',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Sports coach',
                                        'de' => 'Sporttrainer', // !
                                        'es' => 'Entrenador deportivo', // !
                                        'fr' => 'Entraîneur sportif')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_TAXIES',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Taxies',
                                        'de' => 'Taxien', // !
                                        'es' => 'Taxis', // !
                                        'fr' => 'Taxis')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_TENIS_COURT',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Tennis court(s)',
                                        'de' => 'Tennisplätzen', // !
                                        'es' => 'Pista(s) de tenis', // !
                                        'fr' => 'Court(s) de tennis')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_THEATRE',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Theatre',
                                        'de' => 'Theater', // !
                                        'es' => 'Teatro', // !
                                        'fr' => 'Théâtre')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_VILLA',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Villa',
                                        'de' => 'Villa', // !
                                        'es' => 'Villa', // !
                                        'fr' => 'Villa')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_WEAPONS',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Weapons',
                                        'de' => 'Waffen', // !
                                        'es' => 'Armas', // !
                                        'fr' => 'Armes')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESS_WORKING_TOOLS',                                        
					'parent' => 'PARENT_LOCATIONS_LOCATION',                                        
					'text' => 'Working tools',
                                        'de' => 'Arbeitswerkzeuge', // !
                                        'es' => 'Instrumentos de trabajo', // !
                                        'fr' => 'Outils de travail')); //!
                
                array_push($text, array('key' => 'LOCATIONS_LOCATION_LOADED',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'Location loaded.',
                                        'de' => 'Standort geladen.', // !
                                        'es' => 'La ubicación cargó.', // !
                                        'fr' => 'L<<single-quote>>emplacement a chargé.')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_NO_GOOGLE_MAPS',
                                        'parent' => 'PARENT_LOCATIONS_LOCATION',
                                        'text' => 'Google maps did not load. Please refresh the page to try again.',
                                        'de' => 'Google Maps wurde nicht geladen. Aktualisieren Sie die Seite, um es erneut zu versuchen.', // !
                                        'es' => 'Los mapas de Google no se cargaron. Por favor, actualice la página para intentarlo de nuevo.', // !
                                        'fr' => 'Google Maps ne s<<single-quote>>est pas chargé. Veuillez rafraîchir la page pour essayer à nouveau.')); //!
                
                return $text;
            }
            
            /*
             * Locations - Add location text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function locationsAddLocation($text){
                array_push($text, array('key' => 'PARENT_LOCATIONS_ADD_LOCATION',
                                        'parent' => '',
                                        'text' => 'Locations - Add location'));
                
                array_push($text, array('key' => 'LOCATIONS_ADD_LOCATION_NAME',
                                        'parent' => 'PARENT_LOCATIONS_ADD_LOCATION',
                                        'text' => 'New location',
                                        'de' => 'Neuen Standort', // !
                                        'es' => 'Nueva ubicación', // !
                                        'fr' => 'Nouvel emplacement')); //!
                array_push($text, array('key' => 'LOCATIONS_ADD_LOCATION_SUBMIT',
                                        'parent' => 'PARENT_LOCATIONS_ADD_LOCATION',
                                        'text' => 'Add location',
                                        'de' => 'Standort hinzufügen', // !
                                        'es' => 'Añada ubicación', // !
                                        'fr' => 'Ajoutez l<<single-quote>>emplacement')); //!
                array_push($text, array('key' => 'LOCATIONS_ADD_LOCATION_ADDING',
                                        'parent' => 'PARENT_LOCATIONS_ADD_LOCATION',
                                        'text' => 'Adding a new location ...',
                                        'de' => 'Hinzufügen eines neuen Standorts ...', // !
                                        'es' => 'Añadir una nueva ubicación ...', // !
                                        'fr' => 'Ajout d<<single-quote>>un nouvel emplacement...')); //!
                array_push($text, array('key' => 'LOCATIONS_ADD_LOCATION_SUCCESS',
                                        'parent' => 'PARENT_LOCATIONS_ADD_LOCATION',
                                        'text' => 'You have successfully added a new location.',
                                        'de' => 'Sie haben einen neuen Standort hinzugefügt.', // !
                                        'es' => 'Usted ha añadido con éxito una nueva ubicación.', // !
                                        'fr' => 'Vous avez réussi à ajouter un nouvel emplacement.')); //!
                
                return $text;
            }
            
            /*
             * Locations - Delete location text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function locationsDeleteLocation($text){
                array_push($text, array('key' => 'PARENT_LOCATIONS_DELETE_LOCATION',
                                        'parent' => '',
                                        'text' => 'Locations - Delete location'));
                
                array_push($text, array('key' => 'LOCATIONS_DELETE_LOCATION_CONFIRMATION',
                                        'parent' => 'PARENT_LOCATIONS_DELETE_LOCATION',
                                        'text' => 'Are you sure you want to delete this location?',
                                        'de' => 'Möchten Sie diesen Speicherort wirklich löschen?', // !
                                        'es' => '¿Seguro que quieres borrar esta ubicación?', // !
                                        'fr' => 'Vous êtes sûr de vouloir supprimer cet endroit ?')); //!
                array_push($text, array('key' => 'LOCATIONS_DELETE_LOCATION_SUBMIT',
                                        'parent' => 'PARENT_LOCATIONS_DELETE_LOCATION',
                                        'text' => 'Delete location',
                                        'de' => 'Standort löschen', // !
                                        'es' => 'Suprima ubicación', // !
                                        'fr' => 'Supprimez emplacement')); //!
                array_push($text, array('key' => 'LOCATIONS_DELETE_LOCATION_DELETING',
                                        'parent' => 'PARENT_LOCATIONS_DELETE_LOCATION',
                                        'text' => 'Deleting location ...',
                                        'de' => 'Standort wird gelöscht ...', // !
                                        'es' => 'Supresión de ubicación...', // !
                                        'fr' => 'Suppression d<<single-quote>>emplacement ...')); //!
                array_push($text, array('key' => 'LOCATIONS_DELETE_LOCATION_SUCCESS',
                                        'parent' => 'PARENT_LOCATIONS_DELETE_LOCATION',
                                        'text' => 'You have successfully deleted the location.',
                                        'de' => 'Sie haben den Speicherort erfolgreich gelöscht.', // !
                                        'es' => 'Has eliminado con éxito la ubicación.', // !
                                        'fr' => 'Vous avez réussi à supprimer l<<single-quote>>emplacement.')); //!
                
                return $text;
            }
            
            /*
             * Locations - Help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function locationsHelp($text){
                array_push($text, array('key' => 'PARENT_LOCATIONS_HELP',
                                        'parent' => '',
                                        'text' => 'Locations - Help'));
                
                array_push($text, array('key' => 'LOCATIONS_HELP',
                                        'parent' => 'PARENT_LOCATIONS_HELP',
                                        'text' => 'Click on a location item to open the editing area.',
                                        'de' => 'Klicken Sie auf ein Standorte Element, um den Bearbeitungsbereich zu öffnen.', // !
                                        'es' => 'Haga clic en un elemento de ubicación para abrir el área de edición.', // !
                                        'fr' => 'Cliquez sur un élément de l<<single-quote>>emplacement pour ouvrir la zone d<<single-quote>>édition.')); //!
                array_push($text, array('key' => 'LOCATIONS_ADD_LOCATION_HELP',
                                        'parent' => 'PARENT_LOCATIONS_HELP',
                                        'text' => 'Click on the "plus" icon to add a location.',
                                        'de' => 'Klicken Sie auf das "Plus"-Symbol, um eine Standort hinzuzufügen.', // !
                                        'es' => 'Haga clic en el icono "plus" para añadir una ubicación.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "plus" pour ajouter un emplacement.')); //!
                
                /*
                 * Location help.
                 */
                array_push($text, array('key' => 'LOCATIONS_LOCATION_HELP',
                                        'parent' => 'PARENT_LOCATIONS_HELP',
                                        'text' => 'Click the "trash" icon to delete the location.',
                                        'de' => 'Klicken Sie auf das Symbol "Papierkorb", um den Speicherort zu löschen.', // !
                                        'es' => 'Haga clic en el icono "basura" para eliminar la ubicación.', // !
                                        'fr' => 'Cliquez sur l<<single-quote>>icône "corbeille" pour supprimer l<<single-quote>>emplacement.')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_NAME_HELP',
                                        'parent' => 'PARENT_LOCATIONS_HELP',
                                        'text' => 'Change location name.',
                                        'de' => 'Standortnamen ändern.', // !
                                        'es' => 'Cambio el nombre ubicación.', // !
                                        'fr' => 'Changer le nom de l<<single-quote>>emplacement.')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_ADDRESS_HELP',
                                        'parent' => 'PARENT_LOCATIONS_HELP',
                                        'text' => 'Enter location address or drag the marker on the map to select it.',
                                        'de' => 'Geben Sie die Adresse der Standorte ein, oder ziehen Sie die Markierung auf der Karte, um sie auszuwählen.', // !
                                        'es' => 'Introduzca la dirección de ubicación o arrastre el marcador en el mapa para seleccionarlo.', // !
                                        'fr' => 'Entrez l<<single-quote>>adresse de localisation ou faites glisser le marqueur sur la carte pour le sélectionner.')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_ALT_ADDRESS_HELP',
                                        'parent' => 'PARENT_LOCATIONS_HELP',
                                        'text' => 'Enter an alternative address if the marker is in the correct position but the address is not right.',
                                        'de' => 'Geben Sie eine alternative Adresse ein, wenn sich die Markierung an der richtigen Position befindet, die Adresse jedoch nicht richtig ist.', // !
                                        'es' => 'Introduzca una dirección alternativa si el marcador está en la posición correcta pero la dirección no es la correcta.', // !
                                        'fr' => 'Entrez une autre adresse si le marqueur est dans la bonne position mais que l<<single-quote>>adresse n<<single-quote>>est pas la bonne.')); //!
		
                array_push($text, array('key' => 'LOCATIONS_LOCATION_LINK_HELP',
                                        'parent' => 'PARENT_LOCATIONS_HELP',
                                        'text' => 'Enter the link of your site. Make sure it redirects to a page where people can make a booking or can view relevant content.',
                                        'de' => 'Geben Sie den Link Ihrer Website ein. Stellen Sie sicher, dass die Seite umgeleitet wird, auf der die Benutzer eine Buchung vornehmen oder relevante Inhalte anzeigen können.', // !
                                        'es' => 'Introduzca el enlace de su sitio. Asegúrese de que redirige a una página donde la gente puede hacer una reserva o puede ver el contenido relevante.', // !
                                        'fr' => 'Entrez le lien de votre site. Assurez-vous qu<<single-quote>>il redirige vers une page où les gens peuvent faire une réservation ou peuvent voir le contenu pertinent.')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_IMAGE_HELP',
                                        'parent' => 'PARENT_LOCATIONS_HELP',
                                        'text' => 'Make sure the image is relevant to your business.',
                                        'de' => 'Stellen Sie sicher, dass das Bild für Ihr Unternehmen relevant ist.', // !
                                        'es' => 'Asegúrese de que la imagen es relevante para su negocio.', // !
                                        'fr' => 'Assurez-vous que l<<single-quote>>image est pertinente pour votre entreprise.')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESSES_HELP',
                                        'parent' => 'PARENT_LOCATIONS_HELP',
                                        'text' => 'Select what kind of businesses you have at this location. You can select multiple businesses.',
                                        'de' => 'Wählen Sie aus, welche Art von Unternehmen Sie an diesem Standort haben. Sie können mehrere Unternehmen auswählen.', // !
                                        'es' => 'Seleccione qué tipo de negocios tiene en esta ubicación. Puede seleccionar múltiples negocios.', // !
                                        'fr' => 'Sélectionnez le type d<<single-quote>>entreprises que vous avez à cet endroit. Vous pouvez sélectionner plusieurs entreprises.')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_BUSINESSES_OTHER_HELP',
                                        'parent' => 'PARENT_LOCATIONS_HELP',
                                        'text' => 'We will add them in the list as soon as possible.',
                                        'de' => 'Wir werden sie so bald wie möglich in die Liste aufnehmen.', // !
                                        'es' => 'Los incluiremos en la lista lo antes posible.', // !
                                        'fr' => 'Nous les ajouterons à la liste dès que possible.')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_LANGUAGES_HELP',
                                        'parent' => 'PARENT_LOCATIONS_HELP',
                                        'text' => 'Enter the languages that are spoken in your business. You can select multiple languages.',
                                        'de' => 'Geben Sie die Sprachen ein, die in Ihrem Unternehmen gesprochen werden. Sie können mehrere Sprachen auswählen.', // !
                                        'es' => 'Introduzca los idiomas que se hablan en su negocio. Puede seleccionar varios idiomas.', // !
                                        'fr' => 'Entrez les langues parlées dans votre entreprise. Vous pouvez sélectionner plusieurs langues.')); //!
                array_push($text, array('key' => 'LOCATIONS_LOCATION_EMAIL_HELP',
                                        'parent' => 'PARENT_LOCATIONS_HELP',
                                        'text' => 'Enter the email where we can contact you if there are problems with your submission',
                                        'de' => 'Geben Sie die E-Mail-Adresse ein, über die wir Sie bei Problemen mit Ihrer Einreichung kontaktieren können', // !
                                        'es' => 'Escriba el email donde podemos contactarlo si hay problemas con su envío', // !
                                        'fr' => 'Entrez le courriel où nous pouvons communiquer avec vous s<<single-quote>>il y a des problèmes avec votre soumission')); //!
                
                return $text;
            }
        }
    }