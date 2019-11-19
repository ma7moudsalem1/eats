<template>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Qty</th>
                  <th>Item</th>
                  <th>Size</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="order in orders" :key="order.id">
                        <td >{{ order.qty_total }}</td>
                        <td>{{order.item_name}}</td>
                        <td>{{order.size_name}}</td>
                    </tr>
                </tbody>
              </table>
             
            </div>
           
</template>

<script>
  export default {
    name: 'order-sammary',
    props: {
      newAdd:{
            type: Boolean,
            default(){
                return false;
            }
        },
        auth:{
            type: Object,
            default(){
                return {};
            }
        }
    },
    data(){
        return {
            orders: {},
            order_id: ''
        }
    },
      methods: {
            loadOrder(){
                this.$http.get("/order-items-group?order="+ this.order_id+ "&display=s").then(response => {
                    this.orders = response.data.orders;
                }); 
            },
        }
        ,
        created() {
            this.order_id = this.$route.query.or;
            this.loadOrder();
        },
         watch:{
        }
  }
</script>