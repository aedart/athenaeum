const version1 = require('./nav/version1x');
const version2 = require('./nav/version2x');
const version3 = require('./nav/version3x');
const version4 = require('./nav/version4x');

module.exports = {
    base: resolveBasePath(),
    dest: '.build',
    title: 'Athenaeum',
    description: 'Athenaeum Official Documentation',
    locales: {
        '/': {
            lang: 'en-GB',
            title: 'Athenaeum',
            description: 'Athenaeum Official Documentation'
        },
    },
    themeConfig: {
        repo: 'aedart/athenaeum',
        editLinks: true,
        docsDir: 'docs',
        lastUpdated: true,
        locales: {
            '/': {
                // text for the language dropdown
                selectText: 'Languages',
                // label for this locale in the language dropdown
                label: 'English',
                // text for the edit-on-github link
                editLinkText: 'Edit page on GitHub',
                // config for Service Worker
                // serviceWorker: {
                //     updatePopup: {
                //         message: "New content is available.",
                //         buttonText: "Refresh"
                //     }
                // },
                // algolia docsearch options for current locale
                //algolia: {},
                nav: [
                    { text: 'Packages', link: '/archive/current/' },
                    {
                        text: 'Archive',
                        link: '/archive/',
                        items: [
                            { text: 'current', link: '/archive/current/' },
                            { text: 'v3.x', link: '/archive/v3x/' },
                            { text: 'v2.x', link: '/archive/v2x/' },
                            { text: 'v1.x', link: '/archive/v1x/' },
                        ]
                    },
                    { text: 'Changelog', link: 'https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md' },
                ],
                sidebar: {
                    // Current (latest) version
                    '/archive/current/' : version4.sidebar(),

                    // Previous versions
                    '/archive/v3x/' : version3.sidebar(),
                    '/archive/v2x/' : version2.sidebar(),
                    '/archive/v1x/' : version1.sidebar(),
                }
            },
        }
    }
};

/**
 * Resolves the base path
 *
 * @return {string}
 */
function resolveBasePath() {
    if(process.env.NODE_ENV === 'development'){
        console.info('ENVIRONMENT', process.env.NODE_ENV);
        return '/';
    }

    return /athenaeum/;
}
