<template>
  <div :class="css">
    <label>
      {{ label }}
    </label>

    <slot></slot>
  </div>
</template>
<script>

/**
 * Custom "version warning"
 */
export default {
  name: 'Version Warning',

  props: {
    /**
     * The type of warning... or info
     */
    type: {
      type: String,
      default: 'warning'
    }
  },

  computed: {

    /**
     * Css
     *
     * @return {object}
     */
    css() {
      return {
        'version-disclaimer': true,
        [this.type]: true
      }
    },

    label() {
      switch (this.type) {
        case 'info':
          return 'Info';

        case 'warning':
        default:
          return 'Warning';
      }
    }
  }
}
</script>
