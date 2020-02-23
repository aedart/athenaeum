module.exports.sidebar = function(){
    return [
        {
            title: 'Version 4.x',
            collapsable: true,
            children: [
                '',
                'upgrade-guide',
                'new',
            ]
        },
        {
            title: 'Config',
            collapsable: true,
            children: [
                'config/',
                'config/install',
                'config/setup',
                'config/usage',
            ]
        },
        {
            title: 'Console',
            collapsable: true,
            children: [
                'console/',
                'console/install',
                'console/setup',
                'console/commands',
                'console/schedules',
            ]
        },
        {
            title: 'Container',
            collapsable: true,
            children: [
                'container/',
                'container/install',
                'container/reg-as-app',
                'container/destroy',
            ]
        },
        {
            title: 'Core',
            collapsable: true,
            children: [
                'core/',
                'core/prerequisite',
                'core/install',
                'core/integration',
                {
                    title: 'Advanced',
                    collapsable: true,
                    children: [
                        'core/advanced/',
                        'core/advanced/config',
                        'core/advanced/events',
                        'core/advanced/commands',
                        'core/advanced/tasks',
                        'core/advanced/ext',
                        'core/advanced/testing',
                    ]
                },
            ]
        },
        {
            title: 'Dto',
            collapsable: true,
            children: [
                'dto/',
                'dto/install',
                'dto/interface',
                'dto/concrete-dto',
                'dto/usage',
                'dto/populate',
                'dto/export',
                'dto/json',
                'dto/serialization',
                'dto/nested-dto',
                'dto/array/',
            ]
        },
        {
            title: 'Events',
            collapsable: true,
            children: [
                'events/',
                'events/install',
                'events/setup',
                'events/listeners',
                'events/subscribers',
            ]
        },
        {
            title: 'Http',
            collapsable: true,
            children: [
                {
                    title: 'Clients',
                    collapsable: true,
                    children: [
                        'http/clients/',
                        'http/clients/install',
                        'http/clients/setup',
                        'http/clients/usage',
                        'http/clients/json',
                        'http/clients/methods',
                        'http/clients/custom',
                    ]
                },
            ]
        },
        {
            title: 'Properties',
            collapsable: true,
            children: [
                'properties/',
                'properties/install',
                'properties/usage',
                'properties/naming',
                'properties/visibility',
            ]
        },
        {
            title: 'Service',
            collapsable: true,
            children: [
                'service/',
                'service/install',
                'service/usage',
            ]
        },
        {
            title: 'Support',
            collapsable: true,
            children: [
                'support/',
                'support/install',
                {
                    title: 'Laravel Aware-of Helpers',
                    collapsable: true,
                    children: [
                        'support/laravel/',
                        'support/laravel/interfaces',
                        'support/laravel/default',
                        'support/laravel/pros-cons',
                        'support/laravel/available-helpers',
                    ]
                },
                {
                    title: 'Aware-of Properties',
                    collapsable: true,
                    children: [
                        'support/properties/',
                        'support/properties/available-helpers',
                    ]
                }
            ]
        },
        {
            title: 'Testing',
            collapsable: true,
            children: [
                'testing/',
                'testing/install',
                'testing/test-cases',
                'testing/testing-aware-of',
            ]
        },
        {
            title: 'Utils',
            collapsable: true,
            children: [
                'utils/',
                'utils/install',
                'utils/array',
                'utils/json',
                'utils/math',
                'utils/method-helper',
                'utils/populatable',
                'utils/version',
            ]
        },
    ]
};
