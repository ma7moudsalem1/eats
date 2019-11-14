<template>
 <div class="row mt-5 mb-5">
        <div class="col-12">
     <div class="card">
            <div class="card-header">
              <h3 class="card-title">Price & Size</h3>
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
                  <th>Name</th>
                  <th>Price</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items.data" :key="item.id">
                        <td>{{item.name}}</td>
                        <td>{{item.item_price}} EGP</td>
                        <td>
                            <a href="#" class="btn btn-primary" @click.prevent="editModal(item)">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-danger" @click.prevent="deleteItem(item.id)">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <div class="card-footer">
                <pagination :data="items" @pagination-change-page="getResults"></pagination>
            </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->


           <!-- Modal -->
        <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editMode" class="modal-title" id="addNewModalLabel">Edit Price</h5>
                        <h5 v-else="editMode" class="modal-title" id="addNewModalLabel">Add New Price</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateItem() : createItem()">
                        <div class="modal-body">

                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name" placeholder="name"
                                       class="form-control" >
                            </div>

                             <div class="form-group">
                                <input v-model="form.item_price" type="text" name="item_price" placeholder="item price (EGP)"
                                       class="form-control" >
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



      </div>
      <!-- /.row -->
</template>

<script>
  export default {
    name: 'items',
    props: {
    },
    data(){
        return {
            items: {},
            editMode: false,
            form: {},
            it: ''
        }
    },
      methods: {
            newModal(){
                this.editMode = false;
                this.form = {};
                $('#addNewModal').modal('show');
            },
            editModal(resturant){
                this.editMode = true;
                this.form  = resturant;
                $('#addNewModal').modal('show');
            },
            getResults(page = 1) {
                this.$http.get('/item-sizes?it='+ this.it +'&page=' + page).then(response => {
                    this.items = response.data.items;
                });
            },
            loadItems(){
                this.$http.get("/items-sizes?it="+ this.it).then(response => {
                    this.items = response.data.items;
                }); 
            },
            createItem(){
                this.form.item_id = this.it;
                this.$http.post("/items-sizes", this.form).then(response => {
                    this.form = {};
                    Fire.$emit('dataLoaded');
                    $('#addNewModal').modal('hide');

                    toast.fire({
                        type: 'success',
                        title: 'Item created successfully'
                    });

                });

            },
            updateItem(){
                this.form.item_id = this.it;
                this.$http.patch('/items-sizes/'+this.form.id, this.form).then(response => {
                    this.form = {};
                    //Fire.$emit('dataLoaded');
                    toast.fire({
                        type: 'success',
                        title: 'Item Update successfully'
                    });
                });
                $('#addNewModal').modal('hide');
            }
            ,
            deleteItem(id){
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

                            this.$http.delete('/items/' + id).then(response => {
                                Fire.$emit('dataLoaded');
                                Swal.fire(
                                    'Deleted!',
                                    'Your Item has been deleted.',
                                    'success'
                                )
                            });

                        }

                    })
            },
        }
        ,
        created() {
            this.it = this.$route.query.it;
            this.loadItems();
            Fire.$on('dataLoaded', () => {
                this.loadItems();
            });
        }
  }
</script>