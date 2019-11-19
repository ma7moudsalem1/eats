<template>
 <div class="row mt-5 mb-5">

     <div class="col-12">
     <div class="card">
            <div class="card-header">
              <h3 class="card-title">Orders</h3>
                <div class="card-tools">
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Resturant Name</th>
                  <th>Delivery Price</th>
                  <th>Status</th>
                  <th>Time</th>
                  <th v-if="auth.isAdmin">Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="order in orders.data" :key="order.id">
                        <td>{{order.resturant.name}}</td>
                        <td>{{order.delivery_price}} EGP</td>
                        <td>{{order.status ? 'Active' : 'Not Active'}}</td>
                        <td>{{order.created_at}}</td>
                        <td v-if="auth.isAdmin">

                            <router-link :to="url('orderitems?or=' + order.id)" class="btn btn-info" title="order items">
                                <i class="fa fa-bars"></i>
                            </router-link>

                             <router-link v-if="auth.isAdmin" :to="url('ordergroup?or=' + order.id)" class="btn btn-info" title="order group">
                                <i class="fa fa-bars"></i>
                            </router-link>

                            <a v-if="auth.isAdmin" href="#" class="btn btn-primary" @click.prevent="editModal(order)">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a v-if="auth.isAdmin" href="#" class="btn btn-danger" @click.prevent="deleteOrder(order.id)">
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

            <!-- Modal -->
        <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewModalLabel">Edit Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="updateOrder()">
                        <div class="modal-body">

                            <div class="form-group">
                                <select v-model="form.status" name="status"
                                        class="form-control"  id="status">
                                    <option value="1">Active</option>
                                    <option value="0">Not Active</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <input v-model="form.delivery_price" type="text" name="delivery_price" placeholder="delivery_price"
                                       class="form-control" >
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
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
    name: 'decision',
    props: {
    },
    data(){
        return {
            orders: {},
            form: {},
            auth: {}
        }
    },
      methods: {
            url(path){
                let url = document.head.querySelector('meta[name="root-url"]').content
                return url + path;
            },
            editModal(order){
                this.form  = order;
                $('#addNewModal').modal('show');
            },
            getResults(page = 1) {
                this.$http.get('/orders?page=' + page).then(response => {
                    this.orders = response.data.orders;
                });
            },
            loadOrders(){
                  this.$http.get('/orders').then(response => {
                    this.orders = response.data.orders;
                });
            },
            updateOrder(){
                this.$http.patch('/orders/'+this.form.id, this.form).then(response => {
                    this.form = {};
                    toast.fire({
                        type: 'success',
                        title: 'order Update successfully'
                    });
                });
                $('#addNewModal').modal('hide');
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

                            this.$http.delete('/orders/' + id).then(response => {
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
        }
        ,
        created() {
             this.loadOrders();
            Fire.$on('dataLoaded', () => {
                this.loadOrders();
            });
        },
        mounted(){
            this.auth = Auth;
        }
  }
</script>