<template>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Resturant</th>
                  <th>User</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="suggestion in suggestions.data" :key="suggestion.id">
                        <td>{{suggestion.resturant.name}}</td>
                        <td>{{suggestion.user.name}}</td>
                        <td>
                            <a  v-if="auth.id == suggestion.user_id" href="#" class="btn btn-danger" @click.prevent="deleteItem(suggestion.id)" >
                                <i class="fa fa-trash"></i>
                            </a>
                            <a v-if="!mySuggestions.includes(suggestion.resturant.id)" class="btn btn-warning" @click.prevent="plusOne(suggestion.id)" title="plus one">
                                +1
                            </a>
                            <a v-if="suggestion.notes != null" class="btn btn-info" @click.prevent="getInfo(suggestion)" title="info">
                                <i class="fa fa-book"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
              </table>
              <pagination :data="suggestions" @pagination-change-page="getResults"></pagination>

              <div class="modal fade" id="infoModel" tabindex="-1" role="dialog" aria-labelledby="infoModellLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="infoModelLabel">{{ suggInfo.resturant ? suggInfo.resturant.name : '' }} - {{ suggInfo.user ? suggInfo.user.name : ''  }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <div class="modal-body">

                                <div class="form-group">
                                   <strong>Notes: </strong>{{ suggInfo.notes }}
                                </div>
                                
                                <div class="form-group">
                                  <strong>Inserted at: </strong>{{ suggInfo.created_at }}
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                    </div>
                </div>
            </div>
            
            </div>
            <!-- /.card-body -->
</template>

<script>
  export default {
    name: 'items',
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
            suggestions: {},
            mySuggestions: [],
            auth: {},
            suggInfo: {}
        }
    },
      methods: {
            getInfo(suggestion){
                $('#infoModel').modal('show');
                this.suggInfo = suggestion
            },
            getResults(page = 1) {
                this.$http.get('/suggestions?page=' + page).then(response => {
                    this.suggestions = response.data.suggestions;
                });
            },
            loadSuggestions(){
                this.$http.get("/suggestions").then(response => {
                    this.suggestions = response.data.suggestions;
                }); 
            },
            loadMySuggestions(){
                this.$http.get("/my-suggestions").then(response => {
                    this.mySuggestions = response.data.suggestions;
                }); 
            },
            plusOne(id){
                this.$http.post("/suggestions/add/" + id).then(response => {
                    if(response.data.result.success){
                        this.refreshData();
                        toast.fire({
                            type: 'success',
                            title: 'You just added your suggestion successfully'
                        });
                    }else{
                        toast.fire({
                            type: 'error',
                            title: response.data.result.message
                        });
                    }
                    
                }); 
            },
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

                            this.$http.delete('/suggestions/' + id).then(response => {
                                this.refreshData()
                                Swal.fire(
                                    'Deleted!',
                                    'Your Suggestion has been deleted.',
                                    'success'
                                )
                            });

                        }

                    })
            },
            refreshData(){
                this.loadMySuggestions();
                this.loadSuggestions();
            }
        }
        ,
        created() {
            this.auth = Auth;
            this.loadMySuggestions();
            this.loadSuggestions();
            this.$parent.$on('newSuggestion', this.refreshData());
        },
        watch:{
            newAdd(){
                if(this.newAdd){
                    this.refreshData();
                    this.newAdd = false
                }
            }
        }
  }
</script>