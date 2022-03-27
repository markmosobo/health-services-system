<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Patients</h3>

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
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Gender</th>
                      <th>Address</th>
                      <th v-if="$gate.isSuperAdminOrAdminOrDocOrNurse()">First Visit</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="patient in patients.data" :key="patient.id">
                      <td>{{patient.id}}</td>
                      <td>{{patient.first_name}}</td>
                      <td>{{patient.last_name}}</td>
                      <td>{{patient.gender | capitalizeFirstLetter}}</td>
                      <td>{{patient.address}}</td>
                      <td v-if="$gate.isSuperAdminOrAdminOrDocOrNurse()">{{patient.created_at | monthDateTime}}</td>
                      <td>
                          <a href="#" @click="viewModal(patient)" @submit = "getAge(patient)">
                              <i class="fa fa-eye green"></i>
                          </a> 
                          <span>/</span>
                          <a href="#" @click="editModal(patient)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          <span v-show="$gate.isSuperAdminOrAdmin()">/</span>
                          <a href="#" v-if="$gate.isSuperAdminOrAdmin()" @click="deletePatient('patient.id')">
                              <i class="fa fa-trash red"></i>
                          </a>                        
                      </td>
                    </tr>
  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="patients" @pagination-change-page="getResults">
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
                            Patient Information
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New Patient
                            </h5>    
                        <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"> 
                            <div class="form-group">
                            <label>First Name</label>  
                                    <input readonly="readonly" v-model="form.first_name" type="text"
                                    name="first_name" class="form-control">
                                    <div v-if="form.errors.has('first_name')" v-html="form.errors.get('first_name')" />
                            </div>

                            <div class="form-group">                           
                            <label>Last Name</label>  
                                    <input readonly="readonly" v-model="form.last_name" type="text"
                                    name="last_name" class="form-control">
                                    <div v-if="form.errors.has('last_name')" v-html="form.errors.get('last_name')" />
                            </div>

                            <div class="form-group">
                            <label>Age</label>  
                                    <input readonly="readonly" v-model="form.age" type="date"
                                    name="age" class="form-control">
                                    <div v-if="form.errors.has('age')" v-html="form.errors.get('age')" />
                            </div>

                            <div class="form-group">
                            <label>Gender</label>  
                                    <select v-model="form.gender" id="gender"
                                    name="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                      </select>
                                    <div v-if="form.errors.has('gender')" v-html="form.errors.get('gender')" />
                            </div>

                            <div class="form-group">
                            <label>Address</label>  
                                    <input readonly="readonly" v-model="form.address" type="text"
                                    name="address" class="form-control">
                                    <div v-if="form.errors.has('address')" v-html="form.errors.get('address')" />
                            </div>                            

                            <div class="form-group">
                            <label>Mode of Payment</label>  
                                    <select class="form-control" v-model="form.payment_id">
                                      <option 
                                          v-for="item in payments" :key="item.id"
                                          :value="item.id"
                                          :selected="item.id == form.payment_id">{{ item.name }}</option>
                                    </select>
                                    <div v-if="form.errors.has('payment_id')" v-html="form.errors.get('payment_id')" />
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
                    <form @submit.prevent="editmode ? updatePatient() : createPatient()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Update Patient Info
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New Patient
                            </h5>    
                        <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"> 
                            <div class="form-group">
                            <label>First Name</label>  
                                    <input v-model="form.first_name" type="text"
                                    name="first_name" class="form-control">
                                    <div v-if="form.errors.has('first_name')" v-html="form.errors.get('first_name')" />
                            </div>

                            <div class="form-group">                           
                            <label>Last Name</label>  
                                    <input v-model="form.last_name" type="text"
                                    name="last_name" class="form-control">
                                    <div v-if="form.errors.has('last_name')" v-html="form.errors.get('last_name')" />
                            </div>
                            
                            <div class="form-group">
                            <label>Date of Birth</label>  
                                    <input v-model="form.dob" type="date"
                                    name="dob" class="form-control">
                                    <div v-if="form.errors.has('dob')" v-html="form.errors.get('dob')" />
                            </div>

                            <div class="form-group">
                            <label>Gender</label>  
                                    <select v-model="form.gender" id="gender"
                                    name="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                      </select>
                                    <div v-if="form.errors.has('gender')" v-html="form.errors.get('gender')" />
                            </div>

                            <div class="form-group">
                            <label>Address</label>  
                                    <input v-model="form.address" type="text"
                                    name="address" class="form-control">
                                    <div v-if="form.errors.has('address')" v-html="form.errors.get('address')" />
                            </div>                            

                            <div class="form-group">
                            <label>Mode of Payment</label>  
                                    <select class="form-control" v-model="form.payment_id">
                                      <option 
                                          v-for="item in payments" :key="item.id"
                                          :value="item.id"
                                          :selected="item.id == form.payment_id">{{ item.name }}</option>
                                    </select>
                                    <div v-if="form.errors.has('payment_id')" v-html="form.errors.get('payment_id')" />
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
            currentDate: '',
            age: '',
            patients: {},
            payments: {},
                form: new Form({
                    id: '',
                    first_name: '',
                    last_name: '',
                    age: '',
                    dob : '',
                    gender : '',
                    address : '',
                    payment_id: '',
                    status: ''
                }),
          }
        },
        methods: {
              getResults(page = 1) {
                this.$Progress.start();  
                axios.get('api/patient?page=' + page).then(({ data }) => (this.patients = data));
                this.$Progress.finish();
              }, 
              showDate: function () {
              return new Date().toLocaleDateString('fr-CA');
              },
              getAge(patient) { 
              var diff = Date.now() - patient.dob.getTime();
              var age = new Date(diff); 
              console.log(age)
              return Math.abs(age.getUTCFullYear() - 1970);
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
              updatePatient(){
                  this.$Progress.start();
                  this.form.put('api/patient/'+this.form.id)
                  .then(() => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                    'Updated!',
                    'Patient info has been updated.',
                    'success'
                    )
                    Fire.$emit('Refresh');
                  })
                  .catch(() => {
                    this.$Progress.fail();
                  })
              },
              createPatient(){
                  this.$Progress.start();
                  this.form.post('api/patient')
                  .then(() => {
                  $('#addNew').modal('hide')
                  this.$Progress.finish();                                      
                  toast.fire({
                      icon: 'success',
                      title: 'Patient created successfully'
                      })
                  Fire.$emit('Refresh');      
                  })
                  .catch(() => {
                  this.$Progress.fail(); 
                  console.log('error'); 
                  })
              },
              deletePatient(id){
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
                  this.form.delete('api/patient/'+id).then(() => {
                  this.$Progress.finish();
                  Swal.fire(
                    'Deleted!',
                    'Patient has been deleted.',
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
                  axios.get('api/patient').then(({data}) => (this.patients = data));
              },
              listPayments(){
                  axios.get('api/listpayments').then((response) => {
                    this.payments = response.data.data;
              });
              }
        },
        mounted() {
            this.currentDate = this.showDate();
            this.loadPatients();
            this.listPayments();
            Fire.$on('Refresh',() => {this.loadPatients()});
        }
    }
</script>
