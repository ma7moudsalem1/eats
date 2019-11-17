<template>
 <div class="row mt-5 mb-5">
        <div class="col-12">
     <div class="card">
            <div class="card-header">
              <h3 class="card-title">Users</h3>
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
                  <th>Email</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                        <td>{{user.name}}</td>
                        <td>{{user.email}}</td>
                        <td>
                            <a href="#" class="btn btn-primary" @click.prevent="editModal(user)">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-danger" @click.prevent="deleteUser(user.id)">
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
                <pagination :data="users" @pagination-change-page="getResults"></pagination>
            </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->


           <!-- Modal -->
        <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editMode" class="modal-title" id="addNewModalLabel">Edit User</h5>
                        <h5 v-else="editMode" class="modal-title" id="addNewModalLabel">Add New User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateUser() : createUser()">
                        <div class="modal-body">

                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name" placeholder="name"
                                       class="form-control" >
                            </div>

                            <div class="form-group">
                                <input v-model="form.email" type="email" name="email" placeholder="Email address"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <select v-model="form.isAdmin" name="isAdmin"
                                        class="form-control"  id="isAdmin">
                                    <option value="">Select User Role</option>
                                    <option value="1">Admin</option>
                                    <option value="0">User</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <input v-model="form.password" type="password" name="password" placeholder="Password"
                                       class="form-control">
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
    name: 'user',
    props: {
    },
    data(){
        return {
            users: {},
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
            editModal(user){
                this.editMode = true;
                this.form  = user;
                $('#addNewModal').modal('show');
            },
            getResults(page = 1) {
                this.$http.get('/users?page=' + page).then(response => {
                    this.users = response.data.users;
                });
            },
            loadUsers(){
                this.$http.get("/users").then(response => {
                    this.users = response.data.users;
                }); 
            },
            createUser(){
                this.$http.post("/users", this.form).then(response => {
                    this.form = {};
                    Fire.$emit('dataLoaded');
                      toast({
                        type: 'success',
                        title: 'User created successfully'
                    });
                });

            },
            updateUser(){
                this.$http.patch('/users/'+this.form.id, this.form).then(response => {
                    this.form = {};
                    //Fire.$emit('dataLoaded');
                      toast({
                        type: 'success',
                        title: 'User Update successfully'
                    });
                });
                $('#addNewModal').modal('hide');
            }
            ,
            deleteUser(id){
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

                            this.$http.delete('/users/' + id).then(response => {
                                Fire.$emit('dataLoaded');
                                Swal(
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
            this.loadUsers();
            Fire.$on('dataLoaded', () => {
                this.loadUsers();
            });
        },
        mounted(){
            funcs.checkPerm(Auth, rootUrl)
        }
  }
</script>