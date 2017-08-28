<?php
return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults' => [
            'title' => 'UK Fluids Network',
            'description' => 'The UK Fluids Network is an EPSRC-funded network of academic and industrial research groups,'
            . ' focused on innovative developments and applications in Fluid Mechanics.',
            'separator' => ' - ',
            'keywords' => ['UK Fluids Network', 'UKFN', 'Fluids', 'Mechanics', 'EPSRC', 'network', 'research',
                'SIG', 'SRV', 'Special Interest Groups', 'Short Research Visits', 'Fluid Mechanics', 'UK', 'innovative developments', 'academic',
                'information', 'jobs', 'events', 'news', 'mailing list'],
            'canonical' => null, // Set null for using Url::current(), set false to total remove
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google' => "t-KEYseRHCxi0Y_RO8bF3mALmyTdlZxcpqYGkqIt3uM",
            'bing' => null,
            'alexa' => null,
            'pinterest' => null,
            'yandex' => null,
        ],
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title' => 'UK Fluids Network',
            'description' => 'The UK Fluids Network is an EPSRC-funded network of academic and industrial research groups,'
            . ' focused on innovative developments and applications in Fluid Mechanics.',
            'url' => 'https://fluids.ac.uk',
            'type' => 'website',
            'site_name' => false,
            'images' => ['https://fluids.ac.uk/pictures/logo.png'],
            'locale' => 'en_UK'
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card' => 'EPSRC-funded network of academic and industrial research groups,'
            . ' focused on innovative developments and applications in Fluid Mechanics. ',
            'description' => 'EPSRC-funded network of academic and industrial research groups,'
            . ' focused on innovative developments and applications in Fluid Mechanics. ',
            'site' => '@UKFluidsNetwork',
            'title' => 'UK Fluids Network'
        ],
    ],
];
