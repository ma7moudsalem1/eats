<template>
  <div class="text-center">
    404 page error.
  </div>
</template>

<script>
  export default {
    name: 'not-found',
    props: {
    },
    created () {
      this.$ssrContext && this.$ssrContext.res.status(404)
    }
  }
</script>