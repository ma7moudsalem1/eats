<template>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th v-if="auth.isAdmin"></th>
                  <th>Resturant</th>
                  <th>User</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="suggestion in suggestions" :key="suggestion.id">
                        <td v-if="auth.isAdmin"><input type="checkbox" :value="suggestion.resturant.id" v-model="decisions"></td>
                        <td>{{suggestion.resturant.name}}</td>
                        <td>{{suggestion.total}}</td>
                    </tr>
                </tbody>
              </table>
              <button class="btn btn-success mt-5" @click.prevent="makeDecision()" v-if="decisions.length && auth.isAdmin">Make decision</button>
            </div>
           
</template>

<script>
  export default {
    name: 'sammary',
    props: {
      newAdd:{
            type: Boolean,
            default(){
                return false;
            }
        },
        auth:{
            type: Object,
            default(){
                return {};
            }
        }
    },
    data(){
        return {
            suggestions: {},
            decisions: []
        }
    },
      methods: {
            loadSuggestions(){
                this.$http.get("/suggestions?display=s").then(response => {
                    this.suggestions = response.data.suggestions;
                }); 
            },
            refreshData(){
                this.loadSuggestions();
            },
            makeDecision(){
                this.$http.post("/decisions", {'resturants': this.decisions}).then(response => {
                    window.location.replace(rootUrl + 'decisions');
                });
            }
        }
        ,
        created() {
            this.loadSuggestions();
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