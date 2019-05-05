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
                    { text: 'Components', link: '/components/' },
                    { text: 'Changelog', link: 'https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md' },
                ],
                sidebar: {
                    '/components/' : genSidebarComponents(),
                }
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
            title: 'Config',
            collapsable: true,
            children: [
                ['config/', 'Loader'],
            ]
        },
        {
            title: 'Container',
            collapsable: true,
            children: [
                'container/',
            ]
        },
        {
            title: 'Dto',
            collapsable: true,
            children: [
                'dto/',
                'dto/interface',
                'dto/concrete-dto',
                'dto/overloading',
                'dto/populate',
                'dto/json',
                'dto/nested-dto',
                'dto/array/',
            ]
        },
        {
            title: 'Http',
            collapsable: true,
            children: [
                'http/',
                'http/clients/'
            ]
        },
        {
            title: 'Properties',
            collapsable: true,
            children: [
                ['properties/', 'Overload'],
            ]
        },
        {
            title: 'Support',
            collapsable: true,
            children: [
                ['support/', 'Introduction'],
                'support/laravel-helpers',
                'support/properties',
                ['support/generator', 'Generator'],
            ]
        },
        {
            title: 'Testing',
            collapsable: true,
            children: [
                ['testing/', 'Introduction'],
                'testing/laravel',
                'testing/test-cases',
                'testing/traits',
            ]
        },
        {
            title: 'Utils',
            collapsable: true,
            children: [
                'utils/',
                'utils/json',
            ]
        },
    ]
}
