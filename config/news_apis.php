<?php
return [
    'newsapi' => [
        'url' => 'https://newsapi.org/v2/top-headlines?country=us&apiKey=' . env('NEWSAPI_KEY'),
        'transform' => 'transformNewsApi', // A method name for transformation
    ],
    'guardian' => [
        'url' => 'https://content.guardianapis.com/search?api-key=' . env('GUARDIAN_API_KEY'),
        'transform' => 'transformGuardianApi',
    ],
    'nytimes' => [
        'url' => 'https://api.nytimes.com/svc/topstories/v2/home.json?api-key=' . env('NYTIMES_API_KEY'),
        'transform' => 'transformNYTimesApi',
    ],
];

