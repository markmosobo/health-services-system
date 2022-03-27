<template>
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-12">
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Outpatients</h3>

                <div class="card-tools">
                 <button type="button" class="btn btn-primary" @click = "newModal">Add New <i class="fas fa-hospital-user"></i></button>   
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="display: block;">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Patient ID</th>
                      <th>Name</th>
                      <th>Lab No</th>
                      <th>Date</th>
                      <th>Action</th>                     
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="pat in outpatients.data" :key="pat.id">
                      <td><a href="#">OUTP{{pat.id}}</a></td>
                      <td>{{pat.patient.name}}</td>
                      <td>{{pat.lab.lab_no}}</td>
                      <td>{{pat.created_at | monthDateTime}} </td>
                      <td>
                          <a href="#" @click="editModal(pat)">
                              <i class="fa fa-edit blue"></i>
                          </a>                          
                      </td>    
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-footer clearfix" style="display: block;">
                <pagination :data="outpatients" @pagination-change-page="getResults">
                  	<span slot="prev-nav">&lt; Previous</span>
	                  <span slot="next-nav">Next &gt;</span>
                </pagination> 
              </div>
            </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog"
            aria-labelledby="addNewModal" aria-hidden="true">
            <div class="modal-dialog model-dialog-centered" role="document">
                <div class="modal-content">
                    <form @submit.prevent="editmode ? updateOutpatient() : createOutpatient()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Update Outpatient's Info
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New Outpatient
                            </h5>    
                        <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">                             
                            <div class="form-group">

                                <label>Patient:</label>
                                <select class="form-control" v-model="form.patient_id">
                                  <option value="">Select a Patient</option>
                                  <option 
                                      v-for="pat in patientslist" :key="pat.id"
                                      :value="pat.id"
                                      :selected="pat.id == form.patient_id">{{ pat.name }}</option>
                                </select>
                                    <div v-if="form.errors.has('patient_id')" v-html="form.errors.get('patient_id')" />
                            </div>  

                            <div class="form-group">

                                <label>Lab Code:</label>
                                <select class="form-control" v-model="form.lab_id">
                                  <option value="">Select Lab Code</option>
                                  <option 
                                      v-for="item in labslist" :key="item.id"
                                      :value="item.id"
                                      :selected="item.id == form.patient_id">{{ item.lab_no }}</option>
                                </select>
                                    <div v-if="form.errors.has('lab_id')" v-html="form.errors.get('lab_id')" />
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
                outpatients: {},
                editmode:false,
                form: new Form({
                    id: '',
                    patient_id: '',
                    lab_id: '',
                }),
                labslist: {},
                patientslist: {}
            }
        },
        methods: {
            getResults(page = 1) {
              this.$Progress.start();  
              axios.get('api/outpatient?page=' + page).then(({ data }) => (this.outpatients = data));
              this.$Progress.finish();
            },              
              newModal(){
                  this.editmode = false,
                  this.form.reset();
                  $('#addNew').modal('show')  
              },
              editModal(outpatient){
                  this.editmode = true,
                  this.form.reset();
                  $('#addNew').modal('show')
                  this.form.fill(outpatient);  
              },
              updateOutpatient(){
                  this.$Progress.start();
                  this.form.put('api/outpatient/'+this.form.id)
                  .then(() => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                    'Updated!',
                    "Outpatient's information has been updated.",
                    'success'
                    )
                    Fire.$emit('Refresh');
                  })
                  .catch(() => {
                    this.$Progress.fail();
                  })
              },
              createOutpatient(){
                  this.$Progress.start();
                  this.form.post('api/outpatient')
                  .then(() => {
                  $('#addNew').modal('hide')
                  this.$Progress.finish();                                      
                  toast.fire({
                      icon: 'success',
                      title: 'Outpatient created successfully'
                      })
                  Fire.$emit('Refresh');      
                  })
                  .catch(() => {
                  this.$Progress.fail();  
                  })
              },              
              listPatients(){
                  axios.get('api/listpatients').then((response) => {
                    this.patientslist = response.data.data;
                    });
              },
              listLabs(){
                  axios.get('api/listlabs').then((response) => {
                    this.labslist = response.data.data;
                    });
              },
              loadOutPatients(){
                  axios.get('api/outpatient').then((response) =>
                   {this.outpatients = response.data;});
              }                                        
        },
        mounted() {
            this.listLabs();
            this.listPatients();
            this.loadOutPatients();
            Fire.$on('Refresh',() => {this.loadOutPatients() });
        }
    }
</script>
