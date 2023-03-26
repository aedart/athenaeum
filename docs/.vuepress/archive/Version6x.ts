import {PagesCollection} from "@aedart/vuepress-utils/navigation";

/**
 * Version 6.x
 */
export default PagesCollection.make('v6.x', '/v6x', [
    {
        text: 'Version 6.x',
        collapsible: true,
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
        text: 'ACL',
        collapsible: true,
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
        text: 'Audit',
        collapsible: true,
        children: [
            'audit/',
            'audit/install',
            'audit/setup',
            'audit/record-changes',
            'audit/events',
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
        text: 'Collections',
        collapsible: true,
        children: [
            'collections/',
            'collections/install',
            {
                text: 'Summation',
                collapsible: true,
                children: [
                    'collections/summation/',
                    'collections/summation/items-processor'
                ]
            },
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
            'container/service-container',
            'container/list-resolver',
        ]
    },
    {
        text: 'Core',
        collapsible: true,
        children: [
            'core/',
            'core/install',
            'core/setup',
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
        text: 'Database',
        collapsible: true,
        children: [
            'database/',
            'database/install',
            {
                text: 'Models',
                collapsible: true,
                children: [
                    'database/models/instantiatable',
                    'database/models/sluggable',
                ]
            },
            {
                text: 'Query',
                collapsible: true,
                children: [
                    'database/query/criteria',
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
        text: 'ETags',
        collapsible: true,
        children: [
            'etags/',
            'etags/install',
            'etags/setup',
            'etags/usage',
            {
                text: 'Generators',
                collapsible: true,
                children: [
                    'etags/generators/',
                    'etags/generators/custom',
                ]
            },
            'etags/eloquent',
            'etags/macros',
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
        text: 'Filters',
        collapsible: true,
        children: [
            'filters/',
            'filters/prerequisites',
            'filters/install',
            'filters/setup',
            'filters/processor',
            'filters/builder',
            {
                text: 'Predefined Resources',
                collapsible: true,
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
        text: 'Flysystem',
        collapsible: true,
        children: [
            'flysystem/',
            {
                text: 'Database Adapter',
                collapsible: true,
                children: [
                    'flysystem/db/',
                    'flysystem/db/install',
                    'flysystem/db/setup',
                    'flysystem/db/deduplication',
                    'flysystem/db/mime-type',
                ]
            }
        ]
    },
    {
        text: 'Http',
        collapsible: true,
        children: [
            {
                text: 'Api',
                collapsible: true,
                children: [
                    'http/api/',
                    'http/api/install',
                    'http/api/setup',
                    {
                        text: 'Resources',
                        collapsible: true,
                        children: [
                            'http/api/resources/',
                            'http/api/resources/timestamps',
                            'http/api/resources/self-link',
                            'http/api/resources/relations',
                            'http/api/resources/registrar',
                        ]
                    },
                    {
                        text: 'Middleware',
                        collapsible: true,
                        children: [
                            'http/api/middleware/',
                            'http/api/middleware/must-be-json',
                            'http/api/middleware/fields-to-select',
                        ]
                    }
                ]
            },
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
            {
                text: 'Messages',
                collapsible: true,
                children: [
                    'http/messages/',
                    'http/messages/install',
                    'http/messages/serializers',
                ]
            },
        ]
    },
    {
        text: 'Maintenance',
        collapsible: true,
        children: [
            {
                text: 'Modes',
                collapsible: true,
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
        text: 'Mime Types',
        collapsible: true,
        children: [
            'mime-types/',
            'mime-types/install',
            'mime-types/setup',
            'mime-types/usage',
            {
                text: 'Drivers',
                collapsible: true,
                children: [
                    'mime-types/drivers/',
                    'mime-types/drivers/file-info',
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
        text: 'Redmine',
        collapsible: true,
        children: [
            'redmine/',
            'redmine/install',
            'redmine/setup',
            {
                text: 'General Usage',
                collapsible: true,
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
                text: 'Available Resources',
                collapsible: true,
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
        text: 'Service',
        collapsible: true,
        children: [
            'service/',
            'service/install',
            'service/usage',
        ]
    },
    {
        text: 'Streams',
        collapsible: true,
        children: [
            'streams/',
            'streams/install',
            'streams/setup',
            {
                text: 'How to use',
                collapsible: true,
                children: [
                    'streams/usage/',
                    'streams/usage/open-close',
                    'streams/usage/raw-resource',
                    'streams/usage/seeking',
                    'streams/usage/reading',
                    'streams/usage/writing',
                    'streams/usage/size',
                    'streams/usage/truncate',
                    'streams/usage/flush',
                    'streams/usage/hash',
                    'streams/usage/mime-type',
                    'streams/usage/output',
                    'streams/usage/locking',
                    'streams/usage/transactions',
                    'streams/usage/meta',
                    'streams/usage/misc',
                ]
            },
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
            'utils/duration',
            'utils/json',
            'utils/math',
            'utils/memory',
            'utils/method-helper',
            'utils/invoker',
            'utils/populatable',
            'utils/string',
            'utils/version',
        ]
    },
    {
        text: 'Validation',
        collapsible: true,
        children: [
            'validation/',
            'validation/install',
            'validation/setup',
            {
                text: 'Rules',
                collapsible: true,
                children: [
                    'validation/rules/alpha-dash-dot',
                    'validation/rules/semantic-version',
                ]
            },
        ]
    },
]);
