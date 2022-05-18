<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Drugs Stock</h3>
                <div class="card-tools">
                 <button v-show="$gate.isPharm()" type="button" class="btn btn-primary" @click = "newModal">Add New <i class="fas fa-tablets"></i></button>   
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th v-show="$gate.isPharm()">ID</th>
                      <th>Name</th>
                      <th>Dose Form</th>
                      <th>Quantity</th>
                      <th v-show="$gate.isPharm()">Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="drug in drugs.data" :key="drug.id">
                      <td v-show="$gate.isPharm()">{{drug.id}}</td>
                      <td>{{drug.name}}</td>
                      <td>{{drug.dose_form | capitalizeFirstLetter}}</td>
                      <td>{{drug.quantity}}</td>
                      <td v-show="$gate.isPharm()">
                          <a href="#" @click = "editModal(drug)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          <span>/</span>
                          <a href="#" @click = "deleteDrug(drug.id)">
                              <i class="fa fa-trash red"></i>
                          </a>                        
                      </td>
                    </tr>
  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix" style="display: block;">
                <pagination :data="drugs" @pagination-change-page="getResults">
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
                    <form @submit.prevent="editmode ? updateDrug() : createDrug()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Update Drug 
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New Drug
                            </h5>    
                        <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"> 
                            <div class="form-group">
                            <label>Name</label>  
                                    <input v-model="form.name" type="text"
                                    name="name" class="form-control">
                                    <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                            </div>

                            <div class="form-group">
                            <label>Dose Form</label>  
                                    <select v-model="form.dose_form" id="dose_form"
                                    name="dose_form" class="form-control">
                                    <option value="">Select Form</option>
                                    <option value="inhalation">Inhalation</option>
                                    <option value="liquid">Liquid</option>
                                    <option value="injection">Injection</option>
                                    <option value="tablet">Tablet</option>
                                    <option value="oral liquid">Oral liquid</option>
                                    <option value="pfi">PFI</option>
                                      </select>
                                    <div v-if="form.errors.has('dose_form')" v-html="form.errors.get('dose_form')" />
                            </div>                            
                            
                            <div class="form-group">
                            <label>Quantity</label>  
                                    <input v-model="form.quantity" type="text"
                                    name="quantity" class="form-control">
                                    <div v-if="form.errors.has('quantity')" v-html="form.errors.get('quantity')" />
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
            drugs: {},
            form: new Form({
                    id: '',
                    name : '',
                    quantity : '',
                    dose_form: ''
            })
          }
        },
        methods: {
            getResults(page = 1) {
              this.$Progress.start();  
              axios.get('api/drug?page=' + page).then(({ data }) => (this.drugs = data));
              this.$Progress.finish();
            },              
              newModal(){
                  this.editmode = false,
                  this.form.reset();
                  $('#addNew').modal('show')  
              },
              editModal(drug){
                  this.editmode = true,
                  this.form.reset();
                  $('#addNew').modal('show')
                  this.form.fill(drug);  
              },
              updateDrug(){
                  this.$Progress.start();
                  this.form.put('api/drug/'+this.form.id)
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
              createDrug(){
                  this.$Progress.start();
                  this.form.post('api/drug')
                  .then(() => {
                  $('#addNew').modal('hide')
                  this.$Progress.finish();                                      
                  toast.fire({
                      icon: 'success',
                      title: 'Drug created successfully'
                      })
                  Fire.$emit('Refresh');      
                  })
                  .catch(() => {
                  this.$Progress.fail();  
                  })
              },
              deleteDrug(id){
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
                  this.form.delete('api/drug/'+id).then(() => {
                  this.$Progress.finish();
                  Swal.fire(
                    'Deleted!',
                    'Drug has been deleted.',
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
              loadDrugs(){
                  axios.get('api/drug').then(({data}) => (this.drugs = data));
              }              
        },
        mounted() {
            this.loadDrugs();
            Fire.$on('Refresh',() => {this.loadDrugs();})
        }
    }
</script>
