<template>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>User</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="order in orders.data" :key="order.id">
                        <td>{{order.user.name}}</td>
                        <td>
                            <a  class="btn btn-info" title="info">
                                <i class="fa fa-book"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
              </table>
              <pagination :data="orders" @pagination-change-page="getResults"></pagination>
            
            </div>
            <!-- /.card-body -->
</template>

<script>
  export default {
    name: 'order-details',
    props: {
        newAdd:{
            type: Boolean,
            default(){
                return false;
            }
        }
    },
    data(){
        return {
            orders: {},
            auth: {},
            order_id: ''
        }
    },
      methods: {
            getResults(page = 1) {
                this.$http.get('/order-items-group?order='+ this.order_id +'page=' + page).then(response => {
                    this.orders = response.data.orders;
                });
            },
            loadOrders(){
                this.$http.get("/order-items-group?order="+ this.order_id).then(response => {
                    this.orders = response.data.orders;
                }); 
            },
        }
        ,
        created() {
            this.auth = Auth;
            this.order_id = this.$route.query.or;
            this.loadOrders();
        },
        watch:{
        }
  }
</script>