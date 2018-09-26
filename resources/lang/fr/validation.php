<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute doit être accepté.',
    'active_url'           => ':attribute n\'est pas une URL valide.',
    'after'                => ':attribute doit être une date ultérieur à :date.',
    'after_or_equal'       => ':attribute doit être a date ultérieur ou correspondant à :date.',
    'alpha'                => ':attribute ne peut contenir que des lèttres.',
    'alpha_dash'           => ':attribute ne peut contenir que des lèttres, des chiffres et des tirets.',
    'alpha_num'            => ':attribute ne peut contenir que des lèttres et des chiffres.',
    'array'                => ':attribute doit être un tableau.',
    'before'               => ':attribute doit être doit être une date antérieur a :date.',
    'before_or_equal'      => ':attribute doit être doit être une date antérieur ou correspondant à :date.',
    'between'              => [
        'numeric' => ':attribute doit être compris entre :min et :max.',
        'file'    => ':attribute doit être compris entre :min et :max kilo-octets.',
        'string'  => ':attribute doit être compris entre :min et :max caractères.',
        'array'   => ':attribute doit avoir entre :min et :max éléments.',
    ],
    'boolean'              => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed'            => 'La confirmation du champs :attribute  ne correspond pas.',
    'date'                 => ':attribute n\'est pas une date valide.',
    'date_format'          => ':attribute ne correspond pas au format :format.',
    'different'            => 'Les champs :attribute et :other doivent être différents.',
    'digits'               => ':attribute doit être :digits chiffres.',
    'digits_between'       => ':attribute doit être compris entre :min et :max chiffres.',
    'dimensions'           => ':attribute a des dimensions d\'image non valides.',
    'distinct'             => 'Le champs :attribute à une valeur en double.',
    'email'                => ':attribute doit être une adresse email valide.',
    'exists'               => 'La valeur :attribute selectionnée est invalide.',
    'file'                 => ':attribute doit être un fichier.',
    'filled'               => 'Le champs :attribute doit avoir une valeur.',
    'gt'                   => [
        'numeric' => 'La valeur de :attribute doit être supérieure à :value.',
        'file'    => 'La valeur de :attribute doit être supérieure à :value kilo-octets.',
        'string'  => 'La valeur de :attribute doit être supérieure à :value caractères.',
        'array'   => 'La valeur de :attribute doit avoir plus de :value éléments.',
    ],
    'gte'                  => [
        'numeric' => 'La valeur de :attribute doit être supérieure ou égale à :value.',
        'file'    => 'La valeur de :attribute doit être supérieure ou égale à :value kilo-octets.',
        'string'  => 'La valeur de :attribute doit être supérieure ou égale à :value caractères.',
        'array'   => 'La valeur de :attribute doit avoir :value éléments ou plus.',
    ],
    'image'                => ':attribute doit être valide.',
    'in'                   => 'La valeur de :attribute selectionnée n\'est pas valide.',
    'in_array'             => 'Le champs :attribute n\'existe  pas dans :other.',
    'integer'              => ':attribute doit être un entier.',
    'ip'                   => ':attribute doit être une adresse IP valide.',
    'ipv4'                 => ':attribute doit être une adresse IPv4 valide.',
    'ipv6'                 => ':attribute doit être une adresse IPv6 valide.',
    'json'                 => ':attribute doit être une chaine de caractères  JSON valide.',
    'lt'                   => [
        'numeric' => ':attribute doit être inférieure à :value.',
        'file'    => ':attribute doit être inférieure à :value kilo-octets.',
        'string'  => ':attribute doit être inférieure à :value caractères.',
        'array'   => ':attribute doit avoir au moins :value éléments.',
    ],
    'lte'                  => [
        'numeric' => ':attribute doit être inférieure ou égale à :value.',
        'file'    => ':attribute doit être inférieure ou égale à :value kilo-octets.',
        'string'  => ':attribute doit être inférieure ou égale à :value caractères.',
        'array'   => ':attribute ne doit pas avoir plus de :value éléments.',
    ],
    'max'                  => [
        'numeric' => ':attribute ne peut pas être supérieure à :max.',
        'file'    => ':attribute ne peut pas être supérieure à :max kilo-octets.',
        'string'  => ':attribute ne peut pas être supérieure à :max caractères.',
        'array'   => ':attribute ne peut pas avoir plus de :max éléments.',
    ],
    'mimes'                => ':attribute doit être un fichier de type: :values.',
    'mimetypes'            => ':attribute doit être un fichier de type: :values.',
    'min'                  => [
        'numeric' => 'La valeur du champs :attribute doit être au minimum :min.',
        'file'    => ':attribute doit être au minimum :min kilo-octets.',
        'string'  => ':attribute doit être au minimum :min caractères.',
        'array'   => ':attribute doit avoir au minimum :min éléments.',
    ],
    'not_in'               => 'La valeur de :attribute selectionnée n\'est pas valide.',
    'not_regex'            => 'format de :attribute n\'est pas valide.',
    'numeric'              => ':attribute doit être a number.',
    'present'              => 'Le champs :attribute doit être présent.',
    'regex'                => 'format de :attribute n\'est pas valide.',
    'required'             => 'Le champs :attribute est requis.',
    'required_if'          => 'Le champs :attribute est requis lorsque :other est :value.',
    'required_unless'      => 'Le champs :attribute est requis sauf si :other est dans :values.',
    'required_with'        => 'Le champs :attribute est requis lorsque :values est présent.',
    'required_with_all'    => 'Le champs :attribute est requis lorsque :values est présent.',
    'required_without'     => 'Le champs :attribute est requis lorsque :values n\'est pas présent.',
    'required_without_all' => 'Le champs :attribute est requis est requis lorsqu\'aucune des valeurs n\'est présente',
    'same'                 => ':attribute et :other doivent correspondre.',
    'size'                 => [
        'numeric' => ':attribute doit être :size.',
        'file'    => ':attribute doit être :size kilo-octets.',
        'string'  => ':attribute doit être :size caractères.',
        'array'   => ':attribute doit contenir :size éléments.',
    ],
    'string'               => ':attribute doit être une chaîne de caractères.',
    'timezone'             => ':attribute doit être un fuseau horaire valide.',
    'unique'               => ':attribute existe dejà.',
    'uploaded'             => 'Le Chargement de :attribute a échoué.',
    'url'                  => 'Le format de :attribute n\'est pas valide.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],

        'email' => [
        'unique' => 'Cette adresse email existe deja!',
    ],
    'groups' => [
        'required' => 'vous devez selectionner au moin un group d\'utilisateurs.',
    ],
    'actions' => [
        'required' => 'vous devez selectionner au moin une action.',
    ],
    ],

    
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

'attributes' => [
'name'=>'Nom',
'email'=>'Adresse email',
'image'=>'Photo',
'password'=>'Mot de passe',
'title'=>'Titre',
'display_name'=>'Nom à afficher',
'created_by'=>'Auteur',    ],

];
