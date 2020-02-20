const nav = require('./nav/index');

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
                        items: nav.archiveItems(),
                    },
                    { text: 'Changelog', link: 'https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md' },
                ],
                sidebar: nav.sidebarItems(),
            },
        }
    },

    // Plugins
    plugins: {

        // Search Box
        // @see https://vuepress.vuejs.org/plugin/official/plugin-search.html
        '@vuepress/search': {
            searchMaxSuggestions: 10,
            test: '/archive\/current/'
        },

        // Back-to-top
        // '@vuepress/back-to-top': {}
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
