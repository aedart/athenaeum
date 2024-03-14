import {defaultTheme, defineUserConfig, Page} from 'vuepress';
import {backToTopPlugin} from "@vuepress/plugin-back-to-top";
import {searchPlugin} from "@vuepress/plugin-search";
import {baseURL, prefixPath} from "@aedart/vuepress-utils";
import {lastUpdatedPlugin} from "@aedart/vuepress-utils/plugins";
import Archive from "./archive";

/**
 * Base URL of site
 *
 * @type {"/" | `/${string}/`}
 */
const BASE_URL = baseURL('athenaeum');

/**
 * Vuepress configuration for docs...
 */
export default defineUserConfig({
    base: BASE_URL,
    dest: './.build',
    lang: 'en-GB',
    title: 'Athenaeum',
    description: 'Official Documentation',

    head: [
        // Icon
        ['link', { rel: 'apple-touch-icon', sizes: '180x180', href: resolvePath('images/icon/apple-touch-icon.png') }],
        ['link', { rel: 'icon', type: 'image/png', sizes: '32x32', href: resolvePath('images/icon/favicon-32x32.png') }],
        ['link', { rel: 'icon', type: 'image/png', sizes: '16x16', href: resolvePath('images/icon/favicon-16x16.png') }],
        ['link', { rel: 'manifest', href: resolvePath('site.webmanifest') }],
    ],

    theme: defaultTheme({
        repo: 'aedart/athenaeum',

        // Due to strange date format, and comparison, when situated in a different
        // timezone, e.g. Denmark (UTC + 01:00), then dark/light mode switches
        // incorrectly, when set to 'auto'!
        colorMode: 'light',
        logo: '/images/icon/apple-touch-icon.png',

        editLink: true,
        editLinkText: 'Edit page',
        //editLinkPattern: ':repo/-/edit/:branch/:path',

        docsRepo: 'https://github.com/aedart/athenaeum',
        docsBranch: 'main',
        docsDir: 'docs',

        lastUpdated: true,
        lastUpdatedText: 'Last Updated',

        navbar: [
            { text: 'Packages', link: Archive.currentFullPath },
            Archive.asNavigationItem(),
            { text: 'Changelog', link: 'https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md' },
        ],

        sidebar: Archive.sidebarConfiguration()
    }),

    plugins: [

        backToTopPlugin(),

        searchPlugin({
            maxSuggestions: 10,

            isSearchable: (page: Page) => {
                return page.path.includes(Archive.currentFullPath);
            },

            getExtraFields: (page: Page): string[] => {
                let desc:string|undefined = page.frontmatter.description;
                if (desc) {
                    return [desc];
                }

                return [];
            },
        }),

        lastUpdatedPlugin(),
    ]
});

/**
 * Prefixes given path with "base" URL, if needed
 *
 * @param {string} path
 *
 * @returns {string}
 */
function resolvePath(path: string) {
    return prefixPath(BASE_URL, path);
}
