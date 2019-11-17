<template>
 <div class="row mt-5 mb-5">
        <div class="col-12">
     <div class="card">
            <div class="card-header">
              <h3 class="card-title">Items</h3>
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
                  <th>Resturant</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items.data" :key="item.id">
                        <td>{{item.name}}</td>
                        <td>{{item.resturant.name}}</td>
                        <td>
                            <router-link :to="url('sizes?it=' + item.id)" class="btn btn-info" title="Price & Items">
                                <i class="fa fa-bars"></i>
                            </router-link>

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
                        <h5 v-if="editMode" class="modal-title" id="addNewModalLabel">Edit Item</h5>
                        <h5 v-else="editMode" class="modal-title" id="addNewModalLabel">Add New Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateItem() : createItem()">
                        <div class="modal-body">

                            <div class="form-group">
                                <select v-model="form.resturant_id" name="resturant_id"
                                        class="form-control"  id="resturant_id">
                                    <option v-for="(res, i) in resturants" :key="i" :value="i">{{ res }}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name" placeholder="name"
                                       class="form-control" >
                            </div>

                            <div class="form-group">
                                <input type="file" @change="onImageChange" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <textarea  v-model="form.details" name="details" placeholder="details (Optional)"
                                           class="form-control" id="details"
                                           cols="30" rows="3"></textarea>
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
            resturants: {},
            editMode: false,
            form: {image: ''}
        }
    },
      methods: {
           url(path){
                let url = document.head.querySelector('meta[name="root-url"]').content
                return url + path;
            },
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
                this.$http.get('/items?page=' + page).then(response => {
                    this.items = response.data.items;
                });
            },
            loadItems(){
                this.$http.get("/items").then(response => {
                    this.items = response.data.items;
                }); 
            },
            createItem(){
                this.$http.post("/items", this.form).then(response => {
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
                this.$http.patch('/items/'+this.form.id, this.form).then(response => {
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
            getResturants(){
                  this.$http.get('/get-resturants').then(response => {
                    this.resturants = response.data.resturants;
                });
            },
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.form.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
        }
        ,
        created() {
            this.loadItems();
            this.getResturants();
            Fire.$on('dataLoaded', () => {
                this.loadItems();
            });
        },
        mounted(){
            funcs.checkPerm(Auth, rootUrl)
        }
  }
</script>