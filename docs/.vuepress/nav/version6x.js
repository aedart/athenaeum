module.exports.sidebar = function(){
    return [
        {
            title: 'Version 6.x',
            collapsable: true,
            children: [
                '',
                'upgrade-guide',
                'new',
                'contribution-guide',
                'security',
                'code-of-conduct',
                'origin',
            ]
        },
        {
            title: 'ACL',
            collapsable: true,
            children: [
                'acl/',
                'acl/install',
                'acl/setup',
                'acl/permissions',
                'acl/roles',
                'acl/users',
                'acl/cache',
            ]
        },
        {
            title: 'Audit',
            collapsable: true,
            children: [
                'audit/',
                'audit/install',
                'audit/setup',
                'audit/record-changes',
                'audit/events',
            ]
        },
        {
            title: 'Circuits',
            collapsable: true,
            children: [
                'circuits/',
                'circuits/install',
                'circuits/setup',
                'circuits/usage',
                'circuits/events',
            ]
        },
        {
            title: 'Collections',
            collapsable: true,
            children: [
                'collections/',
                'collections/install',
                {
                    title: 'Summation',
                    collapsable: true,
                    children: [
                        'collections/summation/',
                        'collections/summation/items-processor'
                    ]
                },
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
                'config/custom',
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
                'container/service-container',
                'container/list-resolver',
            ]
        },
        {
            title: 'Core',
            collapsable: true,
            children: [
                'core/',
                'core/install',
                'core/setup',
                {
                    title: 'Usage',
                    collapsable: true,
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
            title: 'Database',
            collapsable: true,
            children: [
                'database/',
                'database/install',
                {
                    title: 'Models',
                    collapsable: true,
                    children: [
                        'database/models/instantiatable',
                        'database/models/sluggable',
                    ]
                },
                {
                    title: 'Query',
                    collapsable: true,
                    children: [
                        'database/query/criteria',
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
            title: 'Filters',
            collapsable: true,
            children: [
                'filters/',
                'filters/prerequisites',
                'filters/install',
                'filters/setup',
                'filters/processor',
                'filters/builder',
                {
                    title: 'Predefined Resources',
                    collapsable: true,
                    children: [
                        // 'filters/predefined/', // N/A - no need for an index here...
                        'filters/predefined/search',
                        'filters/predefined/sort',
                        'filters/predefined/constraints',
                        'filters/predefined/match',
                    ]
                },
                'filters/tip'
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
                        {
                            title: 'Available Methods',
                            collapsable: true,
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
                                'http/clients/methods/middleware',
                                'http/clients/methods/conditions',
                                'http/clients/methods/criteria',
                                'http/clients/methods/redirects',
                                'http/clients/methods/timeout',
                                'http/clients/methods/debugging',
                                'http/clients/methods/logging',
                                'http/clients/methods/driver_options',
                                'http/clients/methods/driver',
                            ]
                        },
                        {
                            title: 'Http Query Builder',
                            collapsable: true,
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
                    title: 'Cookies',
                    collapsable: true,
                    children: [
                        'http/cookies/',
                        'http/cookies/install',
                        'http/cookies/usage',
                    ]
                },
                {
                    title: 'Messages',
                    collapsable: true,
                    children: [
                        'http/messages/',
                        'http/messages/install',
                        'http/messages/serializers',
                    ]
                },
            ]
        },
        {
            title: 'Maintenance',
            collapsable: true,
            children: [
                {
                    title: 'Modes',
                    collapsable: true,
                    children: [
                        'maintenance/modes/',
                        'maintenance/modes/install',
                        'maintenance/modes/setup',
                        'maintenance/modes/usage',
                        'maintenance/modes/drivers',
                    ]
                },
            ]
        },
        {
            title: 'Mime Types',
            collapsable: true,
            children: [
                'mime-types/',
                'mime-types/install',
                'mime-types/setup',
                'mime-types/usage',
                {
                    title: 'Drivers',
                    collapsable: true,
                    children: [
                        'mime-types/drivers/',
                        'mime-types/drivers/file-info',
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
            title: 'Redmine',
            collapsable: true,
            children: [
                'redmine/',
                'redmine/install',
                'redmine/setup',
                {
                    title: 'General Usage',
                    collapsable: true,
                    children: [
                        'redmine/usage/', // Supported Operations
                        'redmine/usage/list',
                        'redmine/usage/find',
                        'redmine/usage/fetch',
                        'redmine/usage/create',
                        'redmine/usage/update',
                        'redmine/usage/delete',
                        'redmine/usage/relations',
                    ]
                },
                {
                    title: 'Available Resources',
                    collapsable: true,
                    children: [
                        'redmine/resources/',
                        'redmine/resources/attachments',
                        'redmine/resources/enumerations',
                        'redmine/resources/issue_relations',
                        'redmine/resources/users',
                        'redmine/resources/groups',
                        'redmine/resources/roles',
                        'redmine/resources/memberships',
                        'redmine/resources/versions',
                        'redmine/resources/categories',
                        'redmine/resources/trackers',

                    ]
                },
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
                },
                'support/live-templates',
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
                'utils/duration',
                'utils/json',
                'utils/math',
                'utils/method-helper',
                'utils/invoker',
                'utils/populatable',
                'utils/string',
                'utils/version',
            ]
        },
        {
            title: 'Validation',
            collapsable: true,
            children: [
                'validation/',
                'validation/install',
                'validation/setup',
                {
                    title: 'Rules',
                    collapsable: true,
                    children: [
                        'validation/rules/alpha-dash-dot',
                        'validation/rules/semantic-version',
                    ]
                },
            ]
        },
    ]
};
