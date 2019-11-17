<template>
 <div class="row mt-5 mb-5">

     <div class="col-12">
     <div class="card">
            <div class="card-header">
              <h3 class="card-title">Decisions</h3>
                <div class="card-tools">
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Resturant Name</th>
                  <th>status</th>
                  <th v-if="auth.isAdmin">Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="decision in decisions.data" :key="decision.id">
                        <td>{{decision.resturant.name}}</td>
                        <td>{{decision.status ? 'Active' : 'Not Active'}}</td>
                        <td v-if="auth.isAdmin">
                            <a v-if="auth.isAdmin && !decision.status" href="#" class="btn btn-danger" @click.prevent="deleteDecision(decision.id)">
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
                <pagination :data="decisions" @pagination-change-page="getResults"></pagination>
                <button v-if="auth.isAdmin" @click.prevent="makeOrder()" class="btn btn-success"><i class="fa fa-check"></i></button>
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
    name: 'decision',
    props: {
    },
    data(){
        return {
            decisions: {},
            form: {},
            auth: {}
        }
    },
      methods: {
            newModal(){
                this.form = {};
                $('#addNewModal').modal('show');
            },
            getResults(page = 1) {
                this.$http.get('/decisions?page=' + page).then(response => {
                    this.decisions = response.data.decisions;
                });
            },
            loadDecisions(){
                  this.$http.get('/decisions').then(response => {
                    this.decisions = response.data.decisions;
                });
            },
            makeOrder(){
                this.$http.post('/decisions/make/order', {}).then(response => {
                    let url = document.head.querySelector('meta[name="root-url"]').content;
                    this.$router.push(url + 'orders');
                });
            },
            deleteDecision(id){
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

                            this.$http.delete('/decisions/' + id).then(response => {
                                Fire.$emit('dataLoaded');
                                Swal.fire(
                                    'Deleted!',
                                    'Your decision has been deleted.',
                                    'success'
                                )
                            });

                        }

                    })
            },
        }
        ,
        created() {
             this.loadDecisions();
            Fire.$on('dataLoaded', () => {
                this.loadDecisions();
            });
        },
        mounted(){
            this.auth = Auth;
            funcs.checkPerm(Auth, rootUrl)
        }
  }
</script>