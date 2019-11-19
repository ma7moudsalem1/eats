<template>
 <div class="row mt-5 mb-5">

     <div class="col-12">
     <div class="card">
            <div class="card-header">
              <h3 class="card-title">Order Group ({{ details ? 'in details' : 'Sammary' }})</h3>
                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal">
                        <i class="fa fa-plus"></i>
                    </button>
                    <button @click="details = !details" class="btn btn-success">{{ details ? 'Sammary' : 'Details' }}</button>
                </div>
            </div>
            <order-details v-if="details" :newAdd="newAdd" />
            <order-sammary v-else :newAdd="newAdd" :auth="auth" />
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
</template>

<script>
    import orderDetails from '../components/order/details'
    import orderSammary from '../components/order/sammary'
  export default {
    components: {
        orderDetails,
        orderSammary
    },
    name: 'order-group',
    props: {
    },
    data(){
        return {
            orders: {},
            form: {},
            details: true,
            newAdd: false,
            auth: {}
        }
    },
      methods: {
        }
        ,
        created() {
            
        },
        mounted(){
            this.auth = Auth;
        }
  }
</script>