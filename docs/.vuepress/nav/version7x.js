module.exports.sidebar = function(){
    return [
        {
            title: 'Version 7.x',
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
            title: 'Antivirus',
            collapsable: true,
            children: [
                'antivirus/',
                'antivirus/install',
                'antivirus/setup',
                'antivirus/usage',
                {
                    title: 'Scanners',
                    collapsable: true,
                    children: [
                        'antivirus/scanners/',
                        'antivirus/scanners/clamav',
                        'antivirus/scanners/null',
                        'antivirus/scanners/custom',
                    ]
                },
                'antivirus/events',
                'antivirus/psr',
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
            title: 'Auth',
            collapsable: true,
            children: [
                'auth/',
                'auth/install',
                {
                    title: 'Fortify',
                    collapsable: true,
                    children: [
                        'auth/fortify/', // Prerequisites
                        {
                            title: 'Actions',
                            collapsable: true,
                            children: [
                                'auth/fortify/actions/rehash-password',
                            ]
                        },
                    ]
                },
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
            title: 'ETags',
            collapsable: true,
            children: [
                'etags/',
                'etags/install',
                'etags/setup',
                {
                    title: 'ETags usage',
                    collapsable: true,
                    children: [
                        'etags/etags/',
                        {
                            title: 'Generators',
                            collapsable: true,
                            children: [
                                'etags/etags/generators/',
                                'etags/etags/generators/custom',
                            ]
                        },
                        'etags/etags/eloquent',
                    ]
                },
                {
                    title: 'Http Request Preconditions',
                    collapsable: true,
                    children: [
                        'etags/evaluator/',
                        'etags/evaluator/resource-context',
                        'etags/evaluator/preconditions',
                        'etags/evaluator/actions',
                        {
                            title: 'RFC 9110',
                            collapsable: true,
                            children: [
                                'etags/evaluator/rfc9110/if-match',
                                'etags/evaluator/rfc9110/if-unmodified-since',
                                'etags/evaluator/rfc9110/if-none-match',
                                'etags/evaluator/rfc9110/if-modified-since',
                                'etags/evaluator/rfc9110/if-range',
                            ]
                        },
                        {
                            title: 'Extensions',
                            collapsable: true,
                            children: [
                                'etags/evaluator/extensions/',
                                'etags/evaluator/extensions/range',
                            ]
                        },
                        'etags/evaluator/range-validator',
                        'etags/evaluator/download-stream',
                    ]
                },
                'etags/macros',
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
            title: 'Flysystem',
            collapsable: true,
            children: [
                'flysystem/',
                {
                    title: 'Database Adapter',
                    collapsable: true,
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
            title: 'Http',
            collapsable: true,
            children: [
                {
                    title: 'Api',
                    collapsable: true,
                    children: [
                        'http/api/',
                        'http/api/install',
                        'http/api/setup',
                        {
                            title: 'Resources',
                            collapsable: true,
                            children: [
                                'http/api/resources/',
                                'http/api/resources/timestamps',
                                'http/api/resources/self-link',
                                'http/api/resources/relations',
                                'http/api/resources/caching',
                                'http/api/resources/registrar',
                            ]
                        },
                        {
                            title: 'Requests',
                            collapsable: true,
                            children: [
                                'http/api/requests/',
                                'http/api/requests/list-resources',
                                'http/api/requests/list-deleted',
                                'http/api/requests/show-single',
                                'http/api/requests/create-single',
                                'http/api/requests/update-single',
                                'http/api/requests/delete-single',
                                'http/api/requests/list-related',
                                'http/api/requests/process-multiple',
                            ]
                        },
                        {
                            title: 'Middleware',
                            collapsable: true,
                            children: [
                                'http/api/middleware/',
                                'http/api/middleware/must-be-json',
                                'http/api/middleware/fields-to-select',
                                'http/api/middleware/remove-response-payload',
                            ]
                        }
                    ]
                },
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
            title: 'Streams',
            collapsable: true,
            children: [
                'streams/',
                'streams/install',
                'streams/setup',
                {
                    title: 'How to use',
                    collapsable: true,
                    children: [
                        'streams/usage/',
                        'streams/usage/open-close',
                        'streams/usage/raw-resource',
                        'streams/usage/seeking',
                        'streams/usage/reading',
                        'streams/usage/writing',
                        'streams/usage/size',
                        'streams/usage/truncate',
                        'streams/usage/sync',
                        'streams/usage/flush',
                        'streams/usage/hash',
                        'streams/usage/mime-type',
                        'streams/usage/filename',
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
            title: 'Translation',
            collapsable: true,
            children: [
                'translation/',
                'translation/install',
                {
                    title: 'Exporters',
                    collapsable: true,
                    children: [
                        'translation/exporters/',
                        'translation/exporters/setup',
                        'translation/exporters/usage',
                        {
                            title: 'Drivers',
                            collapsable: true,
                            children: [
                                'translation/exporters/drivers/',
                                'translation/exporters/drivers/array',
                                'translation/exporters/drivers/lang-js',
                                'translation/exporters/drivers/lang-js-json',
                                'translation/exporters/drivers/cache',
                            ]
                        },
                    ]
                },
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
                'utils/memory',
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
