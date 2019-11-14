<template>
    <!-- Main Footer -->
    <footer class="main-footer mt-4">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Mahmoud Salem
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; {{ currentDate  }} <a href="http://ultimate-sa.com">Ultimate Solution</a>.</strong> All rights reserved.
    </footer>
</template>

<script>
  export default {
    name: 'footerLayout',
    data () {
      return {
        currentDate: new Date().getFullYear(),
      }
    },
      mounted() {

      },
      methods: {
      }

  }
</script>

