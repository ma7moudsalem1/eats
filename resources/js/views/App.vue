<template >
   <div>
       <HeaderLayout />
        <sideLayout />

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <router-view></router-view>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footerLayout />
   </div>
</template>

<script>
    import HeaderLayout from '../components/common/header-layout'
    import footerLayout from '../components/common/footer-layout'
    import sideLayout from '../components/common/side-layout'
    export default {
        components: {
            HeaderLayout,
            footerLayout,
            sideLayout,
        },
        name: 'App',
        data () {
            return {
                route: this.$route.name
            }
        },
        created(){
        },
    }
</script>
