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
        // {
        //     title: 'Http',
        //     collapsable: true,
        //     children: [
        //         'http/',
        //         'http/clients/'
        //     ]
        // },
        // {
        //     title: 'Properties',
        //     collapsable: true,
        //     children: [
        //         ['properties/', 'Overload'],
        //     ]
        // },
        // {
        //     title: 'Support',
        //     collapsable: true,
        //     children: [
        //         ['support/', 'Introduction'],
        //         'support/laravel-helpers',
        //         'support/properties',
        //         ['support/generator', 'Generator'],
        //     ]
        // },
        // {
        //     title: 'Testing',
        //     collapsable: true,
        //     children: [
        //         ['testing/', 'Introduction'],
        //         'testing/laravel',
        //         'testing/test-cases',
        //         'testing/traits',
        //     ]
        // },
        // {
        //     title: 'Utils',
        //     collapsable: true,
        //     children: [
        //         'utils/',
        //         'utils/json',
        //     ]
        // },
    ]
};
