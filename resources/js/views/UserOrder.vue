<template>
 <div class="row mt-5 mb-5">

     <div class="col-12">
     <div class="card">
            <div class="card-header">
              <h3 class="card-title">User Order Items</h3>
            </div>
             <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Item</th>
                  <th>Size</th>
                  <th>Price</th>
                  <th>Qty</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="order in orders" :key="order.id">
                        <td>{{order.item_name}}</td>
                        <td>{{order.size_name}}</td>
                        <td>{{order.item_price}} EGP</td>
                        <td>{{order.qty}}</td>
                    </tr>
                     <tr >
                        <td colspan="2">Total price with delivary</td>
                        <td colspan="2">{{price}} EGP</td>
                    </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
</template>

<script>
  export default {
    components: {
    },
    name: 'user-order',
    props: {
    },
    data(){
        return {
            orders: {},
            form: {},
            price: '',
            auth: {},
            order_id: '',
            user_id: ''
        }
    },
      methods: {
          loadItems(){
              this.$http.get("/order-items-group/get/user?order="+ this.order_id + "&user=" + this.user_id).then(response => {
                    var data = response.data.items;
                    this.orders = data.items;
                    this.price  = data.price;
              }); 
          }
        }
        ,
        created() {
            this.order_id = this.$route.query.or;
            this.user_id = this.$route.query.u;
            this.loadItems();
        },
        mounted(){
            this.auth = Auth;
            funcs.checkPerm(Auth, rootUrl)
        }
  }
</script>