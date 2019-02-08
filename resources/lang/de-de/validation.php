<?php

return [

    'confirmed' => __('Die :attribute Bestätigung stimmt nicht überein.'),
    'email' => __('Das :attribute Feld muss eine gültige E-Mail Adresse beinhalten.'),
    'required' => __('Das ":attribute" Feld wird benötigt.'),
    'present' => __('Das :attribute Feld wird benötigt.'),
    'min' => [
        'string' => __('Das :attribute Feld muss mindestens :min Zeichen lang sein.'),
    ],
    'unique' => __('Der eingegebene Wert darf nur einmal verwendet werden.'),
    'date_format' => __('Das :attribute Feld entspricht nicht dem gewünschten Format (:format).'),

    'custom' => [
        'password' => [
            'min' => __('Wählen Sie mindestens :min Zeichen.'),
            'regex' => __('Bitte wählen Sie ein stärkeres Passwort aus Groß-, Kleinbuchstaben und Zahlen.'),
        ],
        'email' => [
            'unique' => __('Die E-Mail existiert bereits.'),
        ],
        'start_at' => [
            'before' => __('Das Datum von "Von" muss vor "Bis" liegen.'),
        ],
        'end_at' => [
            'after' => __('Das Datum von "Bis" muss nach "Vor" liegen.'),
        ],
    ],

    'attributes' => [
        'email' => __('E-Mail'),
        'password' => __('Passwort'),
        'password_confirmation' => __('Passwort bestätigen'),
        'password_admin' => __('Administratoren Passwort'),
        'remember' => __('Login merken'),
        'language' => __('Sprache'),
        'display_name' => __('Bezeichnung'),
        'firstname' => __('Vorname'),
        'lastname' => __('Nachname'),
        'reason' => __('Grund'),
        'color' => __('Farbe'),
        'start_at' => __('Von'),
        'end_at' => __('Bis'),
        'description' => __('Beschreibung'),
        'admin' => __('Admin')
    ],

];
