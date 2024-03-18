import { defineUserConfig } from "@condorhero/vuepress-plugin-export-pdf-v2";

/**
 * Export PDF configuration
 *
 * @see https://www.npmjs.com/package/@condorhero/vuepress-plugin-export-pdf-v2
 */
export default defineUserConfig({
    //theme: "@vuepress/theme-default",

    /**
     * WARNING: Adapt these settings such that only desired version(s)
     * are exported...
     */
    routePatterns: [
        '/archive/v1x/**',

        '!/archive/v2x/**',
        '!/archive/v3x/**',
        '!/archive/v4x/**',
        '!/archive/v5x/**',
        '!/archive/v6x/**',
        '!/archive/v7x/**',
        '!/archive/current/**',
        '!/archive/next/**',
    ],
    outDir: 'docs/.vuepress/public/pdf',
    pdfOptions: {
        displayHeaderFooter: true,

        // @see https://github.com/puppeteer/puppeteer/blob/main/docs/api/puppeteer.pdfoptions.md
        footerTemplate: '<div class="page-nav"><p class="inner"><span class="pageNumber"></span> / <span class="totalPages"></span> </p></div>',
        scale: 0.8
    },
    pdfOutlines: true,
});