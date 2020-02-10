module.exports.sidebar = function(){
    return [
        {
            title: 'Version 4.x',
            collapsable: true,
            children: [
                '',
                'upgrade-guide',
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
        // {
        //     title: 'Container',
        //     collapsable: true,
        //     children: [
        //         'container/',
        //     ]
        // },
        {
            title: 'Core',
            collapsable: true,
            children: [
                'core/',
            ]
        },
        // {
        //     title: 'Dto',
        //     collapsable: true,
        //     children: [
        //         'dto/',
        //         'dto/interface',
        //         'dto/concrete-dto',
        //         'dto/overloading',
        //         'dto/populate',
        //         'dto/json',
        //         'dto/nested-dto',
        //         'dto/array/',
        //     ]
        // },
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
