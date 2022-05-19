<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">Drug Charges</h3>
                 <div class="card-tools">
                     <div class="input-group input-group-sm" style="width: 150px;">
                     <input type="text" name="table_search" placeholder="Search" class="form-control float-right">
                      <div class="input-group-append">
                          <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                      </div>
                          </div>
                          </div>
                          </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Quantity</th>
                      <th>Amount</th>
                      <th v-show="$gate.isAccountant()">Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in drugcharges.data" :key="item.id">
                      <td>{{item.name }} - {{item.dose_form}}</td>
                      <td>{{item.quantity}}</td>
                      <td>{{item.price}}</td>
                      <td v-show="$gate.isAccountant()">
                          <a href="#" @click = "editModal(item)">
                              <i class="fa fa-edit blue"></i>
                          </a>                       
                      </td>
                    </tr>
  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix" style="display: block;">
                <pagination :data="drugcharges" @pagination-change-page="getResults">
                  	<span slot="prev-nav">&lt; Previous</span>
	                  <span slot="next-nav">Next &gt;</span>
                </pagination> 
              </div>               
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog"
            aria-labelledby="addNewModal" aria-hidden="true">
            <div class="modal-dialog model-dialog-centered" role="document">
                <div class="modal-content">
                    <form @submit.prevent="editmode ? updateCharge() : createCharge()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Update Charge 
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New Charge
                            </h5>    
                        <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"> 
                            <div class="form-group">

                                <label>Drug or Medicine:</label>
                                <select class="form-control" v-model="form.drug_id">
                                  <option 
                                      v-for="item in drugs" :key="item.id"
                                      :value="item.id"
                                      :selected="item.id == form.drug_id">{{ item.name }}</option>
                                </select>
                                    <div v-if="form.errors.has('drug_id')" v-html="form.errors.get('drug_id')" />
                            </div>
                            
                            <div class="form-group">
                            <label>Quantity</label>  
                                    <input readonly="readonly" v-model="form.quantity" type="text"
                                    name="quantity" class="form-control">
                                    <div v-if="form.errors.has('quantity')" v-html="form.errors.get('quantity')" />
                            </div>                            

                            <div class="form-group">
                            <label>Amount</label>  
                                    <input v-model="form.drug_charge" type="text"
                                    name="drug_charge" class="form-control">
                                    <div v-if="form.errors.has('drug_charge')" v-html="form.errors.get('drug_charge')" />
                            </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                        data-dismiss="modal">Close</button>
                        <button type="submit" v-show="editmode" class="btn btn-success">
                        Update</button>
                        <button type="submit" v-show="!editmode" class="btn btn-primary">
                        Create</button>     
                    </div>
                   
                    </form>    
                </div>
            </div>
            </div>
        <!-- end of modal -->        
    </div>
</template>

<script>
    export default {
        data(){
          return{
            editmode:false,
            drugcharges: {},
            drugs: {},
            form: new Form({
                    id: '',
                    drug_charge : '',
                    drug_id:'',
                    quantity: ''
            })
          }
        },
        methods: {
            getResults(page = 1) {
              this.$Progress.start();  
              axios.get('api/drugcharge?page=' + page).then(({ data }) => (this.drugcharges = data));
              this.$Progress.finish();
            },              
              newModal(){
                  this.editmode = false,
                  this.form.reset();
                  $('#addNew').modal('show')  
              },
              editModal(charge){
                  this.editmode = true,
                  this.form.reset();
                  $('#addNew').modal('show')
                  this.form.fill(charge);  
              },
              updateCharge(){
                  this.$Progress.start();
                  this.form.put('api/drugcharge/'+this.form.id)
                  .then(() => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                  toast.fire({
                      icon: 'success',
                      title: 'Updated'
                      })
                    Fire.$emit('Refresh');
                  })
                  .catch(() => {
                    this.$Progress.fail();
                  })
              },
              deleteCharge(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/drugcharge/'+id).then(() => {
                  this.$Progress.finish();
                  Swal.fire(
                    'Deleted!',
                    'charge has been deleted.',
                    'success'
                  )
                  Fire.$emit('Refresh');                     
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  });
                  }

                })
              },
              listDrugs(){
                  axios.get('api/listdrugs').then((response) => {
                    this.drugs = response.data.data;
                    });
              },              
              loadCharges(){
                  axios.get('api/drugcharge').then(({data}) => (this.drugcharges = data));
              }              
        },
        mounted() {
            this.loadCharges();
            this.listDrugs();
            Fire.$on('Refresh',() => {this.loadCharges();})
        }
    }
</script>
