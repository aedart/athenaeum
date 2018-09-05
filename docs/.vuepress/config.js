module.exports = {
    base: '/',
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
                    { text: 'Components', link: '/components/' }
                ],
                sidebar: {
                    '/components/' : genSidebarComponents(),
                }
                //sidebar: 'auto'
            },
        }
    }
};

function genSidebarComponents () {
    return [
        {
            title: 'Getting Started',
            collapsable: true,
            children: [
                '',
            ]
        },
        {
            title: 'Testing',
            collapsable: true,
            children: [
                'testing/',
                'testing/test-cases',
            ]
        },
    ]
}
