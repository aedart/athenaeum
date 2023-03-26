import {PagesCollection} from "@aedart/vuepress-utils/navigation";

/**
 * Version 3.x
 */
export default PagesCollection.make('v3.x', '/v3x', [
    {
        text: 'Version 3.x',
        collapsible: true,
        children: [
            '',
        ]
    },
    {
        text: 'Config',
        collapsible: true,
        children: [
            // ['config/', 'Loader'], // Original
            'config/',
        ]
    },
    {
        text: 'Container',
        collapsible: true,
        children: [
            'container/',
        ]
    },
    {
        text: 'Dto',
        collapsible: true,
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
        text: 'Http',
        collapsible: true,
        children: [
            'http/',
            'http/clients/'
        ]
    },
    {
        text: 'Properties',
        collapsible: true,
        children: [
            // ['properties/', 'Overload'], // Original
            'properties/',
        ]
    },
    {
        text: 'Support',
        collapsible: true,
        children: [
            // ['support/', 'Introduction'], // Original
            'support/',
            'support/laravel-helpers',
            'support/properties',
            // ['support/generator', 'Generator'], // Original
            'support/generator',
        ]
    },
    {
        text: 'Testing',
        collapsible: true,
        children: [
            // ['testing/', 'Introduction'], // Original
            'testing/',
            'testing/laravel',
            'testing/test-cases',
            'testing/traits',
        ]
    },
    {
        text: 'Utils',
        collapsible: true,
        children: [
            'utils/',
            'utils/json',
        ]
    },
]);
