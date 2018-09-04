module.exports = {
    base: '/athenaeum/',
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
                    '/components/' : genSidebarComponents('Components'),
                }
                //sidebar: 'auto'
            },
        }
    }
};

function genSidebarComponents (title) {
    return [
        {
            title,
            collapsable: false,
            children: [
                '',
                'testing/',

                // TODO: Does not appear to work!?
                // ['testing/', {
                //     title: 'Testing',
                //     collapsable: false,
                //     children: [
                //         '',
                //         'testing/test-cases'
                //     ]
                // }],
            ]
        }
    ]
}
