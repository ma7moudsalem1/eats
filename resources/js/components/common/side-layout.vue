<template>
<!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <router-link to="/dashboard" class="brand-link">
            <!-- <img src="/img/logo.png" alt="Vue System Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8"> -->
            <span class="brand-text font-weight-light">Ultimate Eats</span>
        </router-link>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Circle-icons-profile.svg/600px-Circle-icons-profile.svg.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <router-link to="/dashboard" class="d-block">name</router-link>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <router-link :to="url('')" class="nav-link">
                            <i class="nav-icon fa fa-home"></i>
                            <p>
                                Home
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link :to="url('users')" class="nav-link">
                            <i class="fa fa-users nav-icon"></i>
                            <p>Users</p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link :to="url('resturants')" class="nav-link">
                            <i class="fa fa-cutlery nav-icon"></i>
                            <p>Resturants</p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link :to="url('items')" class="nav-link">
                            <i class="fa fa-bars nav-icon"></i>
                            <p>Items</p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#"
                           @click="$('#logout-form').submit(); location.reload">

                            <i class="nav-icon fa fa-power-off"></i>
                            <p>
                                {{ 'logout' }}
                            </p>
                        </a>

                        
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside> 
</template>

<script>
    export default {
        components: {
        },
        data () {
            return {
            }
        },
        methods: {
            url(path){
                let url = document.head.querySelector('meta[name="root-url"]').content
                return url + path;
            }
        }
    }
</script>




