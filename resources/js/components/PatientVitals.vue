<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Patients' Vitals </h3>

                <div class="card-tools">
                 <button type="button" class="btn btn-primary" @click = "newModal">Add New <i class="fas fa-user-injured"></i></button>   
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Weight</th>
                      <th>Height</th>
                      <th>Temperature</th>
                      <th>Blood Pressure</th>
                      <th>Recorded On</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="patient in patientvitals.data" :key="patient.id">
                      <td>{{patient.id}}</td>
                      <td>{{patient.patient.first_name}} {{patient.patient.last_name}}</td>
                      <td>{{patient.weight}}</td>
                      <td>{{patient.height}}</td>
                      <td>{{patient.temperature}}</td>
                      <td>{{patient.blood_pressure}}</td>
                      <td>{{patient.created_at | monthDateTime}}</td>
                      <td>
                          <a href="#" @click="viewModal(patient)">
                              <i class="fa fa-eye green"></i>
                          </a> 
                          <span>/</span>                        
                          <a href="#" @click="editModal(patient)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          <span v-show="$gate.isNurse()">/</span>
                          <a href="#" v-if="$gate.isNurse()" @click="deletePatient('patient.id')">
                              <i class="fa fa-trash red"></i>
                          </a>                        
                      </td>
                    </tr>
  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="patientvitals" @pagination-change-pweight="getResults">
                  	<span slot="prev-nav">&lt; Previous</span>
	                  <span slot="next-nav">Next &gt;</span>
                </pagination>
              </div>              
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- View Modal -->
        <div class="modal fade" id="viewNew" tabindex="-1" role="dialog"
            aria-labelledby="viewNewModal" aria-hidden="true">
            <div class="modal-dialog model-dialog-centered" role="document">
                <div class="modal-content">
                    <form> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Patient Vitals
                            </h5>  
                        <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"> 
                            <div class="form-group">
                                <label>Patient's Name</label>
                                <select class="form-control" :class="{ 'is-invalid': form.errors.has('patient_id') }" v-model="form.patient_id">
                                <option value="">Select Patient</option>
                                <option 
                                    v-for="item in patients" :key="item.id"
                                    :value="item.id"
                                    :selected="item.id == form.patient_id">{{ item.first_name }} {{item.last_name}}</option>
                                </select>
                                <div v-if="form.errors.has('patient_id')" v-html="form.errors.get('patient_id')" />
                            </div> 
                            
                            <div class="form-group">
                            <label>Weight</label>  
                                    <input v-model="form.weight" type="integer"
                                    name="weight" class="form-control">
                                    <div v-if="form.errors.has('weight')" v-html="form.errors.get('weight')" />
                            </div>

                            <div class="form-group">
                            <label>Height</label>  
                                    <input v-model="form.height" type="integer"
                                    name="height" class="form-control">
                                    <div v-if="form.errors.has('height')" v-html="form.errors.get('height')" />
                            </div>

                            <div class="form-group">
                            <label>Temperature</label>  
                                    <input v-model="form.temperature" type="integer"
                                    name="temperature" class="form-control">
                                    <div v-if="form.errors.has('temperature')" v-html="form.errors.get('temperature')" />
                            </div>                            
                         
                            <div class="form-group">
                            <label>Blood Pressure</label>  
                                    <input v-model="form.blood_pressure" type="text"
                                    name="blood_pressure" class="form-control">
                                    <div v-if="form.errors.has('blood_pressure')" v-html="form.errors.get('blood_pressure')" />
                            </div> 

                    </div>
                   
                    </form>    
                </div>
            </div>
            </div>
        <!-- end of view modal --> 

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog"
            aria-labelledby="addNewModal" aria-hidden="true">
            <div class="modal-dialog model-dialog-centered" role="document">
                <div class="modal-content">
                    <form @submit.prevent="editmode ? updatePatientVital() : createPatientVital()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Update Patient Vitals
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New Patient Vitals
                            </h5>    
                        <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"> 
                            <div class="form-group">
                                <label>Patient's Name</label>
                                <select class="form-control" :class="{ 'is-invalid': form.errors.has('patient_id') }" v-model="form.patient_id">
                                <option value="">Select Patient</option>
                                <option 
                                    v-for="item in patients" :key="item.id"
                                    :value="item.id"
                                    :selected="item.id == form.patient_id">{{ item.first_name }} {{item.last_name}}</option>
                                </select>
                                <div v-if="form.errors.has('patient_id')" v-html="form.errors.get('patient_id')" />
                            </div> 
                            
                            <div class="form-group">
                            <label>Weight</label>  
                                    <input v-model="form.weight" type="integer"
                                    name="weight" class="form-control">
                                    <div v-if="form.errors.has('weight')" v-html="form.errors.get('weight')" />
                            </div>

                            <div class="form-group">
                            <label>Height</label>  
                                    <input v-model="form.height" type="integer"
                                    name="height" class="form-control">
                                    <div v-if="form.errors.has('height')" v-html="form.errors.get('height')" />
                            </div>

                            <div class="form-group">
                            <label>Temperature</label>  
                                    <input v-model="form.temperature" type="integer"
                                    name="temperature" class="form-control">
                                    <div v-if="form.errors.has('temperature')" v-html="form.errors.get('temperature')" />
                            </div>                            
                         
                            <div class="form-group">
                            <label>Blood Pressure</label>  
                                    <input v-model="form.blood_pressure" type="text"
                                    name="blood_pressure" class="form-control">
                                    <div v-if="form.errors.has('blood_pressure')" v-html="form.errors.get('blood_pressure')" />
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
          return {
            editmode:false,
            patientvitals: {},
            patients: {},
                form: new Form({
                    id: '',
                    name: '',
                    weight : '',
                    height : '',
                    temperature : '',
                    blood_pressure: '',
                }),
          }
        },
        methods: {
            getResults(page = 1) {
              this.$Progress.start();  
              axios.get('api/patient?page=' + page).then(({ data }) => (this.patientvitals = data));
              this.$Progress.finish();
            },              
              newModal(){
                  this.editmode = false,
                  this.form.reset();
                  $('#addNew').modal('show')  
              },
              viewModal(patient){
                  this.editmode = true,
                  this.form.reset();
                  $('#viewNew').modal('show')
                  this.form.fill(patient);  
              },
              editModal(patient){
                  this.editmode = true,
                  this.form.reset();
                  $('#addNew').modal('show')
                  this.form.fill(patient);  
              },
              updatePatientVital(){
                  this.$Progress.start();
                  this.form.put('api/patientvital/'+this.form.id)
                  .then(() => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                    'Updated!',
                    "Patient's vitals have been updated.",
                    'success'
                    )
                    Fire.$emit('Refresh');
                  })
                  .catch(() => {
                    this.$Progress.fail();
                  })
              },
              createPatientVital(){
                  this.$Progress.start();
                  this.form.post('api/patientvital')
                  .then(() => {
                  $('#addNew').modal('hide')
                  this.$Progress.finish();                                      
                  toast.fire({
                      icon: 'success',
                      title: "Patient's vitals were created successfully"
                      })
                  Fire.$emit('Refresh');      
                  })
                  .catch(() => {
                  this.$Progress.fail(); 
                  console.log('error'); 
                  })
              },
              deletePatientVital(id){
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
                  this.form.delete('api/patientvital/'+id).then(() => {
                  this.$Progress.finish();
                  Swal.fire(
                    'Deleted!',
                    "Patient's vitals have been deleted.",
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
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
              }, 
            loadPatients(){
                axios.get('api/listpatients').then((response) => {
                    this.patients = response.data.data
                });
            },             
              loadPatientVitals(){
                  axios.get('api/patientvital').then(({data}) => (this.patientvitals = data));
              },
        },
        mounted() {
            this.loadPatientVitals();
            this.loadPatients();
            Fire.$on('Refresh',() => {this.loadPatientVitals()});
        }
    }
</script>
