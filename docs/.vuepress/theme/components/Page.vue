<template>
  <main class="page">
    <slot name="top" />

    <!--
      Custom version warning(s)
    -->
    <!-- When viewing docs. for next version -->
    <VersionWarning v-if="showWarningForNextVersionDocs" type="info">
      You are viewing documentation for an upcoming version. <strong>It has not yet been released!</strong>!
    </VersionWarning>

    <!-- When viewing docs. for outdated version -->
    <VersionWarning v-if="showWarningForOutdatedVersionDocs">
      You are viewing documentation for a version that is <strong>no longer supported!</strong>
    </VersionWarning>

    <Content class="theme-default-content" />
    <PageEdit />

    <PageNav v-bind="{ sidebarItems }" />

    <slot name="bottom" />
  </main>
</template>
<script>
import Page from '@vuepress/theme-default/components/Page';
import PageEdit from '@vuepress/theme-default/components/PageEdit.vue'
import PageNav from '@vuepress/theme-default/components/PageNav.vue'
import VersionWarning from "./VersionWarning";

/**
 * Path string substring for current version docs
 *
 * @type {string}
 */
const CURRENT_PATH = '/archive/current/';

/**
 * Path string substring for next version docs
 *
 * @type {string}
 */
const NEXT_PATH = '/archive/next/';


/**
 * Extended "Page" for vue-press
 */
export default {
  extend: Page,
  components: {
    PageEdit,
    PageNav,
    VersionWarning
  },

  props: ['sidebarItems'],

  computed: {

    showWarningForNextVersionDocs() {
        return this.$route.path.includes(NEXT_PATH);
    },

    showWarningForOutdatedVersionDocs() {
      let path = this.$route.path;

      return !path.includes(NEXT_PATH) && !path.includes(CURRENT_PATH)
    }
  },

  // mounted() {
  //   console.log(this.$route);
  // }
}
</script>
