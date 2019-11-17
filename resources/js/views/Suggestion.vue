<template>
 <div class="row mt-5 mb-5">

     <div class="col-12">
     <div class="card">
            <div class="card-header">
              <h3 class="card-title">Suggestions ({{ details ? 'in details' : 'Sammary' }})</h3>
                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal">
                        <i class="fa fa-plus"></i>
                    </button>
                    <button @click="details = !details" class="btn btn-success">{{ details ? 'Sammary' : 'Details' }}</button>
                </div>
            </div>
            <sugg-details v-if="details" :newAdd="newAdd" />
            <sugg-sammary v-else :newAdd="newAdd" :auth="auth" />
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

     
           <!-- Modal -->
        <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewModalLabel">Add New suggestion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createItem()">
                        <div class="modal-body">

                             <div class="form-group">
                                <select v-model="form.resturant_id" name="resturant_id"
                                        class="form-control"  id="resturant_id">
                                    <option v-for="(res, i) in resturants" :key="i" :value="i">{{ res }}</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <textarea  v-model="form.notes" name="notes" placeholder="Notes (Optional)"
                                           class="form-control" id="notes"
                                           cols="30" rows="3"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



      </div>
      <!-- /.row -->
</template>

<script>
    import suggDetails from '../components/suggestions/details'
    import suggSammary from '../components/suggestions/sammary'
  export default {
    components: {
        suggDetails,
        suggSammary
    },
    name: 'suggestion',
    props: {
    },
    data(){
        return {
            suggestions: {},
            form: {},
            resturants: {},
            details: true,
            newAdd: false,
            auth: {}
        }
    },
      methods: {
            newModal(){
                this.form = {};
                $('#addNewModal').modal('show');
            },
            createItem(){
                this.newAdd = false;
                this.$http.post("/suggestions", this.form).then(response => {
                    if(response.data.result.success){
                        this.form = {};
                        this.newAdd = true;
                        $('#addNewModal').modal('hide');

                        toast.fire({
                            type: 'success',
                            title: 'Suggestion created successfully'
                        });
                    }else{
                        toast.fire({
                            type: 'error',
                            title: response.data.result.message
                        });
                    }
                    

                });

            },
            getResturants(){
                  this.$http.get('/get-resturants').then(response => {
                    this.resturants = response.data.resturants;
                });
            },

            isDecisionMade(){
                  this.$http.get('/decisions/check/made').then(response => {
                    var dec = response.data.decisions;
                    if(dec['made']){
                        let url = document.head.querySelector('meta[name="root-url"]').content;
                        this.$router.push(url + 'decisions');
                    }
                });
            },
        }
        ,
        created() {
            this.getResturants();
        },
        mounted(){
            this.isDecisionMade();
            this.auth = Auth;
        }
  }
</script>