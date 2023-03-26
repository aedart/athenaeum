import {PagesCollection} from "@aedart/vuepress-utils/navigation";

/**
 * Version 4.x
 */
export default PagesCollection.make('v4.x', '/v4x', [
    {
        text: 'Version 4.x',
        collapsible: true,
        children: [
            '',
            'upgrade-guide',
            'new',
            'origin',
        ]
    },
    {
        text: 'Circuits',
        collapsible: true,
        children: [
            'circuits/',
            'circuits/install',
            'circuits/setup',
            'circuits/usage',
            'circuits/events',
        ]
    },
    {
        text: 'Config',
        collapsible: true,
        children: [
            'config/',
            'config/install',
            'config/setup',
            'config/usage',
            'config/custom',
        ]
    },
    {
        text: 'Console',
        collapsible: true,
        children: [
            'console/',
            'console/install',
            'console/setup',
            'console/commands',
            'console/schedules',
        ]
    },
    {
        text: 'Container',
        collapsible: true,
        children: [
            'container/',
            'container/install',
            'container/reg-as-app',
            'container/destroy',
        ]
    },
    {
        text: 'Core',
        collapsible: true,
        children: [
            'core/',
            'core/prerequisite',
            'core/install',
            'core/integration',
            {
                text: 'Usage',
                collapsible: true,
                children: [
                    'core/usage/', // Configuration
                    'core/usage/providers',
                    'core/usage/container',
                    'core/usage/events',
                    'core/usage/cache',
                    'core/usage/logging',
                    'core/usage/console',
                    'core/usage/tasks',
                    'core/usage/exceptions',
                    'core/usage/ext',
                    'core/usage/testing',
                ]
            },
        ]
    },
    {
        text: 'Dto',
        collapsible: true,
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
        text: 'Events',
        collapsible: true,
        children: [
            'events/',
            'events/install',
            'events/setup',
            'events/listeners',
            'events/subscribers',
        ]
    },
    {
        text: 'Http',
        collapsible: true,
        children: [
            {
                text: 'Clients',
                collapsible: true,
                children: [
                    'http/clients/',
                    'http/clients/install',
                    'http/clients/setup',
                    'http/clients/usage',
                    {
                        text: 'Available Methods',
                        collapsible: true,
                        children: [
                            'http/clients/methods/',
                            'http/clients/methods/protocol_version',
                            'http/clients/methods/base_uri',
                            'http/clients/methods/method_and_uri',
                            'http/clients/methods/headers',
                            'http/clients/methods/content_type',
                            'http/clients/methods/auth',
                            'http/clients/methods/query',
                            'http/clients/methods/data_format',
                            'http/clients/methods/data',
                            'http/clients/methods/attachments',
                            'http/clients/methods/cookies',
                            'http/clients/methods/expectations',
                            'http/clients/methods/conditions',
                            'http/clients/methods/criteria',
                            'http/clients/methods/redirects',
                            'http/clients/methods/timeout',
                            'http/clients/methods/driver_options',
                            'http/clients/methods/driver',
                        ]
                    },
                    {
                        text: 'Http Query Builder',
                        collapsible: true,
                        children: [
                            'http/clients/query/',
                            'http/clients/query/select',
                            'http/clients/query/where',
                            'http/clients/query/dates',
                            'http/clients/query/include',
                            'http/clients/query/pagination',
                            'http/clients/query/sorting',
                            'http/clients/query/raw',
                            'http/clients/query/custom_grammar',
                        ]
                    }
                ]
            },
            {
                text: 'Cookies',
                collapsible: true,
                children: [
                    'http/cookies/',
                    'http/cookies/install',
                    'http/cookies/usage',
                ]
            },
        ]
    },
    {
        text: 'Properties',
        collapsible: true,
        children: [
            'properties/',
            'properties/install',
            'properties/usage',
            'properties/naming',
            'properties/visibility',
        ]
    },
    {
        text: 'Service',
        collapsible: true,
        children: [
            'service/',
            'service/install',
            'service/usage',
        ]
    },
    {
        text: 'Support',
        collapsible: true,
        children: [
            'support/',
            'support/install',
            {
                text: 'Laravel Aware-of Helpers',
                collapsible: true,
                children: [
                    'support/laravel/',
                    'support/laravel/interfaces',
                    'support/laravel/default',
                    'support/laravel/pros-cons',
                    'support/laravel/available-helpers',
                ]
            },
            {
                text: 'Aware-of Properties',
                collapsible: true,
                children: [
                    'support/properties/',
                    'support/properties/available-helpers',
                ]
            },
            'support/live-templates',
        ]
    },
    {
        text: 'Testing',
        collapsible: true,
        children: [
            'testing/',
            'testing/install',
            'testing/test-cases',
            'testing/testing-aware-of',
        ]
    },
    {
        text: 'Utils',
        collapsible: true,
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
]);
