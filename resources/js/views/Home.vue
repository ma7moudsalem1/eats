<template>
    <div class="mt-5">
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ numbers.users }}</h3>

                <p>Users</p>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ numbers.resturants }}</h3>

                <p>Resturants</p>
              </div>
              <div class="icon">
                <i class="fa fa-cutlery"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ numbers.items }}</h3>

                <p>Items</p>
              </div>
              <div class="icon">
                <i class="fa fa-list"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ numbers.orders }}</h3>

                <p>orders</p>
              </div>
              <div class="icon">
                <i class="fa fa-shopping-cart"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
    </div>
</template>

<script>
  export default {
    components: {
    },
    name: 'home',
    props: {
    },
    data(){
        return {
            numbers: {},
        }
    },
      methods: {

        }
        ,
        created() {
            this.$http.get('/home').then(response => {
                this.numbers = response.data.home.numbers;
            });
        },
        mounted(){
            this.auth = Auth;
        }
  }
</script>