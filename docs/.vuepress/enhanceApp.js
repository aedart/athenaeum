/**
 * App Level Enhancements
 *
 * @see https://v1.vuepress.vuejs.org/guide/basic-config.html#app-level-enhancements
 *
 * @param Vue The version of Vue being used in the VuePress app
 * @param options The options for the root Vue instance
 * @param router The router instance for the app
 * @param siteData Site metadata
 * @param isServer Is this enhancement applied in server-rendering or client
 */
export default({
    Vue,
    options,
    router,
    siteData,
    isServer
}) => {
    router.addRoutes([
        // For backwards compatibility, handle the "components" route,
        // redirect it to the most current docs.
        { path: '/components/', redirect: '/packages/' }
    ])
}
