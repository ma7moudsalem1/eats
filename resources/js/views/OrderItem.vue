<template>
 <div class="row mt-5 mb-5">

     <div class="col-12">
     <div class="card">
            <div class="card-header">
              <h3 class="card-title">Orders Items <a href="#" @click.prevent="calcTotal()">Get Total Price</a></h3>
                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Item</th>
                  <th>Size</th>
                  <th>Price</th>
                  <th>Qty</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="order in orders.data" :key="order.id">
                        <td>{{order.item.name}}</td>
                        <td>{{order.size_name}}</td>
                        <td>{{order.item_price}} EGP</td>
                        <td>{{order.qty}}</td>
                        <td >
                            <a href="#" class="btn btn-danger" @click.prevent="deleteOrder(order.id)">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

         <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editMode" class="modal-title" id="addNewModalLabel">Edit Item</h5>
                        <h5 v-else="editMode" class="modal-title" id="addNewModalLabel">Add New Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateItem() : createItem()">
                        <div class="modal-body">

                            <div class="form-group">
                                <select v-model="form.item_id" name="item_id"
                                        class="form-control"  id="item_id" @change="getSizes()">
                                    <option v-for="(item, i) in items" :key="i" :value="item.id">{{ item.name }}</option>
                                </select>
                            </div>

                            <div class="form-group" v-show="form.item_id">
                                <select v-model="form.size_id" name="size_id"
                                        class="form-control"  id="size_id">
                                    <option v-for="(size, i) in sizes" :key="i" :value="size.id">{{ size.name + ' (' +  size.item_price + ' EGP)' }}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <input v-model="form.qty" type="number" name="qty" placeholder="qty"
                                       class="form-control" min="1" >
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-if="editMode" type="submit" class="btn btn-primary">Update</button>
                            <button v-else="editMode" type="submit" class="btn btn-success">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="TotalModal" tabindex="-1" role="dialog" aria-labelledby="TotalModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="TotalModalLabel">Total Price</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="modal-body">

                            total Price: <strong>{{total}} EGP</strong>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                </div>
            </div>
        </div>

      </div>
      <!-- /.row -->
</template>

<script>
  export default {
    components: {
    },
    name: 'order-item',
    props: {
    },
    data(){
        return {
            orders: {},
            items: {},
            order_id: '',
            form: {},
            auth: {},
            editMode: false,
            sizes: {},
            total: ''
        }
    },
      methods: {
            url(path){
                let url = document.head.querySelector('meta[name="root-url"]').content
                return url + path;
            },
            calcTotal(){
                this.$http.get('/order-items/get/total?order='+ this.order_id).then(response => {
                    this.total = response.data.items;
                    $('#TotalModal').modal('show');
                });
            },
            newModal(){
                this.editMode = false;
                this.form = {};
                $('#addNewModal').modal('show');
            },
            getResults(page = 1) {
                this.$http.get('/order-items?order='+ this.order_id +'&page=' + page).then(response => {
                    this.orders = response.data.orders;
                });
            },
            loadOrders(){
                  this.$http.get('/order-items?order='+this.order_id).then(response => {
                    this.orders = response.data.orders;
                });
            },
            createItem(){
                this.form.order_id = this.order_id;
                this.$http.post("/order-items", this.form).then(response => {
                    if(response.data.result.success){
                        this.form = {};
                        Fire.$emit('dataLoaded');
                        $('#addNewModal').modal('hide');

                        toast.fire({
                            type: 'success',
                            title: 'Item created successfully'
                        });

                    }else{
                         toast.fire({
                            type: 'error',
                            title: response.data.result.message
                        });
                    }
                    
                });

            },
            deleteOrder(id){
                    Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if(result.value){

                            this.$http.delete('/order-items/' + id).then(response => {
                                Fire.$emit('dataLoaded');
                                Swal.fire(
                                    'Deleted!',
                                    'Your order has been deleted.',
                                    'success'
                                )
                            });

                        }

                    })
            },
            loadItems(){
                this.$http.get('/order-items/get/items?order='+ this.order_id).then(response => {
                    this.items = response.data.items;
                });
            },
            getSizes(){
                for (let index = 0; index < this.items.length; index++) {
                 
                 if(this.items[index].id == this.form.item_id){
                     this.sizes = this.items[index].sizes;
                     break;
                 }
                    
                }
            }
        }
        ,
        created() {
            this.order_id = this.$route.query.or;
             this.loadOrders();
             this.loadItems();
            Fire.$on('dataLoaded', () => {
                this.loadOrders();
            });
        },
        mounted(){
            this.auth = Auth;
        }
  }
</script>