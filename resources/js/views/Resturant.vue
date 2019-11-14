<template>
 <div class="row mt-5 mb-5">
        <div class="col-12">
     <div class="card">
            <div class="card-header">
              <h3 class="card-title">Resturants</h3>
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
                  <th>Delivery Price</th>
                  <th>status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="resturant in resturants.data" :key="resturant.id">
                        <td>{{resturant.name}}</td>
                        <td>{{resturant.delivery_price}} EGP</td>
                        <td>{{resturant.status ? 'Active' : 'Not Active'}}</td>
                        <td>
                            <a href="#" class="btn btn-primary" @click.prevent="editModal(resturant)">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-danger" @click.prevent="deleteResturant(resturant.id)">
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
                <pagination :data="resturants" @pagination-change-page="getResults"></pagination>
            </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->


           <!-- Modal -->
        <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editMode" class="modal-title" id="addNewModalLabel">Edit resturant</h5>
                        <h5 v-else="editMode" class="modal-title" id="addNewModalLabel">Add New resturant</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateResturant() : createResturant()">
                        <div class="modal-body">

                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name" placeholder="name"
                                       class="form-control" >
                            </div>

                            <div class="form-group">
                                <input v-model="form.delivery_price" type="text" name="delivery_price" placeholder="delivery price"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <input v-model="form.menu" type="text" name="menu" placeholder="menu link (Optional)"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <textarea  v-model="form.details" name="details" placeholder="details (Optional)"
                                           class="form-control" id="details"
                                           cols="30" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <select v-model="form.status" name="status"
                                        class="form-control"  id="status">
                                    <option value="">Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Not Active</option>
                                </select>
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
    name: 'resturant',
    props: {
    },
    data(){
        return {
            resturants: {},
            editMode: false,
            form: {}
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
                this.$http.get('/resturants?page=' + page).then(response => {
                    this.resturants = response.data.resturants;
                });
            },
            loadResturants(){
                this.$http.get("/resturants").then(response => {
                    this.resturants = response.data.resturants;
                }); 
            },
            createResturant(){
                this.$http.post("/resturants", this.form).then(response => {
                    this.form = {};
                    Fire.$emit('dataLoaded');
                    $('#addNewModal').modal('hide');

                    toast.fire({
                        type: 'success',
                        title: 'Resturant created successfully'
                    });

                });

            },
            updateResturant(){
                this.$http.patch('/resturants/'+this.form.id, this.form).then(response => {
                    this.form = {};
                    //Fire.$emit('dataLoaded');
                    toast.fire({
                        type: 'success',
                        title: 'Resturant Update successfully'
                    });
                });
                $('#addNewModal').modal('hide');
            }
            ,
            deleteResturant(id){
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

                            this.$http.delete('/resturants/' + id).then(response => {
                                Fire.$emit('dataLoaded');
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            });

                        }

                    })
            }
        }
        ,
        created() {
            this.loadResturants();
            Fire.$on('dataLoaded', () => {
                this.loadResturants();
            });
        }
  }
</script>