<template>
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-12">
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Inpatients</h3>

                <div class="card-tools">
                 <button type="button" class="btn btn-primary" @click = "newModal">Add New <i class="fas fa-procedures"></i></button>   
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
                      <th>Room No</th>
                      <th>Admission Date</th>
                      <th>Discharge Date</th>
                      <th>Status</th> 
                      <th>Action</th>                     
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="pat in inpatients.data" :key="pat.id">
                      <td><a href="#">INP{{pat.id}}</a></td>
                      <td>{{pat.patient.name}}</td>
                      <td>{{pat.lab.lab_no}}</td>
                      <td>{{pat.room.name}}</td>
                      <td>{{pat.created_at | monthDateTime}} </td>
                      <td>{{pat.discharge_date | monthDateTime}}  </td>
                      <td>
                        <span v-if="!pat.discharge_date == ''" class="badge badge-info">Discharged</span>
                        <span v-else class="badge badge-warning">Admitted</span>
                      </td>
                      <td>
                          <a href="#" @click = "editModal(pat)" v-show="!pat.discharge_date == !''">
                              <i class="fa fa-edit blue"></i>
                          </a>                          
                      </td>    
                      <td  v-if="$gate.isSuperAdminOrAdminOrDocOrNurse()" v-show="!pat.discharge_date == !''">                        
                        <a href="#" v-if="$gate.isSuperAdminOrAdminOrDocOrNurse()" @click = "dischargeInpatient(pat.id)" class="btn btn-sm btn-info float-left">Discharge</a>                                                       
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-footer clearfix" style="display: block;">
                <pagination :data="inpatients" @pagination-change-page="getResults">
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
                    <form @submit.prevent="editmode ? updateInpatient() : createInpatient()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Update Inpatient's Info
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New Inpatient
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
                                  <option 
                                      v-for="item in labslist" :key="item.id"
                                      :value="item.id"
                                      :selected="item.id == form.patient_id">{{ item.lab_no }}</option>
                                </select>
                                    <div v-if="form.errors.has('lab_id')" v-html="form.errors.get('lab_id')" />
                            </div>

                            <div class="form-group">

                                <label>Room:</label>
                                <select class="form-control" v-model="form.room_id">
                                  <option 
                                      v-for="som in roomslist" :key="som.id"
                                      :value="som.id"
                                      :selected="som.id == form.room_id">{{ som.name }}</option>
                                </select>
                                    <div v-if="form.errors.has('room_id')" v-html="form.errors.get('room_id')" />
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
                editmode: false,
                inpatients: {},
                form: new Form({
                        id: '',
                        patient_id: '',
                        lab_id: '',
                        room_id: '',                
                }),
                labslist: {},
                roomslist: {},
                patientslist: {}
            }
        },
        methods: {
            getResults(page = 1) {
              this.$Progress.start();  
              axios.get('api/inpatient?page=' + page).then(({ data }) => (this.inpatients = data));
              this.$Progress.finish();
            },              
              newModal(){
                  this.editmode = false,
                  this.form.reset();
                  $('#addNew').modal('show')  
              },
              editModal(inpatient){
                  this.editmode = true,
                  this.form.reset();
                  $('#addNew').modal('show')
                  this.form.fill(inpatient);  
              },
              updateInpatient(){
                  this.$Progress.start();
                  this.form.put('api/inpatient/'+this.form.id)
                  .then(() => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                    'Updated!',
                    "Inpatient's information has been updated.",
                    'success'
                    )
                    Fire.$emit('Refresh');
                  })
                  .catch(() => {
                    this.$Progress.fail();
                  })
              },
              createInpatient(){
                  this.$Progress.start();
                  this.form.post('api/inpatient')
                  .then(() => {
                  $('#addNew').modal('hide')
                  this.$Progress.finish();                                      
                  toast.fire({
                      icon: 'success',
                      title: 'Inpatient created successfully'
                      })
                  Fire.$emit('Refresh');      
                  })
                  .catch(() => {
                  this.$Progress.fail();  
                  })
              },
              dischargeInpatient(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Do you want to discharge the inpatient?',
                  showDenyButton: true,
                  showCancelButton: true,
                  confirmButtonText: 'Discharge',
                  denyButtonText: `Don't discharge`,
                }).then((result) => {
                    this.$Progress.finish();
                    if (result.isConfirmed) {
                    axios.post('api/dischargeinpatient/'+id).then((response)=>{
                    console.log(response);  
                    toast.fire('Discharged!', '', 'success')
                    Fire.$emit('Refresh');
                    }).catch(() => {
                    this.$Progress.fail();
                    console.log('err');  
                    })
                    }else if(result.isDenied){
                    toast.fire('The inpatient was not discharged','','warning')
                    }
                })
              },                          
              listLabs(){
                  axios.get('api/listlabs').then((response) => {
                    this.labslist = response.data.data;
                    });
              },
              listRooms(){
                  axios.get('api/listrooms').then((response) => {
                    this.roomslist = response.data.data;
                    });
              },
              listPatients(){
                  axios.get('api/listpatients').then((response) => {
                    this.patientslist = response.data.data;
                    });
              },
              loadInPatients(){
                  axios.get('api/inpatient').then((response) => {this.inpatients = response.data});
              }                            
        },
        mounted() {
            this.listPatients();
            this.listLabs();
            this.listRooms();
            this.loadInPatients();
            Fire.$on('Refresh',() => {this.loadInPatients();})
        }
    }
</script>
