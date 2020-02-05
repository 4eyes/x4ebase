<?php

/**
 * Reorder redirect middlewares and resolve static routes before base redirects
 */
return [
    'frontend' => [
        'typo3/cms-redirects/redirecthandler' => [
            'target' => \TYPO3\CMS\Redirects\Http\Middleware\RedirectHandler::class,
            'before' => [
                'typo3/cms-frontend/base-redirect-resolver',
            ],
            'after' => [
                'typo3/cms-frontend/tsfe',
                'typo3/cms-frontend/authentication',
                null,
                null
            ],
        ],
        'typo3/cms-frontend/base-redirect-resolver' => [
            'after' => [
                'typo3/cms-frontend/static-route-resolver',
                null
            ],
            'before' => [
                'typo3/cms-frontend/page-resolver'
            ]
        ],
        'typo3/cms-frontend/static-route-resolver' => [
            'after' => [
                'typo3/cms-redirects/redirecthandler'
            ]
        ],
    ],
];
