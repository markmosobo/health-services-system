<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Consultations</h3>
                <div class="card-tools">
                 <button type="button" class="btn btn-primary" @click = "newModal">Add New <i class="fas fa-user-md"></i></button>   
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Patient</th>
                      <th>Symptoms</th>
                      <th>Status</th>
                      <th>Consulted On</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in consultations.data" :key="item.id">
                      <td>{{item.id}}</td>
                      <td>{{item.patient.first_name}} {{item.patient.last_name}}</td>
                      <td>{{item.symptoms | capitalizeFirstLetter}}</td>
                      <td>{{item.status | capitalizeFirstLetter}}</td>                      
                      <td>{{item.created_at | monthDateTime}}</td>
                      <td >
                          <a href="#" @click = "editModal(item)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          <span v-show="$gate.isDoc()">/</span>
                          <a href="#" v-if="$gate.isDoc()" @click = "deleteConsultation(item.id)">
                              <i class="fa fa-trash red"></i>
                          </a>                        
                      </td>
                    </tr>
  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog"
            aria-labelledby="addNewModal" aria-hidden="true">
            <div class="modal-dialog model-dialog-centered" role="document">
                <div class="modal-content">
                    <form @submit.prevent="editmode ? updateConsultation() : createConsultation()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Update Consultation Info
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New Consultation
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
                                  <option 
                                      v-for="pat in patients" :key="pat.id"
                                      :value="pat.id"
                                      :selected="pat.id == form.patient_id">{{ pat.first_name }} {{ pat.last_name }}</option>
                                </select>
                                    <div v-if="form.errors.has('patient_id')" v-html="form.errors.get('patient_id')" />
                            </div>  

                            <div class="form-group">
                            <label>Symptoms</label>  
                                    <textarea v-model="form.symptoms" id="symptoms"
                                    name="symptoms" class="form-control">
                                    </textarea>
                                    <div v-if="form.errors.has('symptoms')" v-html="form.errors.get('symptoms')" />
                            </div>

                            <!-- <div class="form-group">
                            <label>Status</label>  
                                    <select v-model="form.status" id="status"
                                    name="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="outpatient">Outpatient</option>
                                    <option value="inpatient">Inpatient</option>
                                      </select>
                                    <div v-if="form.errors.has('status')" v-html="form.errors.get('status')" />
                            </div> -->

                            <div class="form-group">

                                <label>Tests to be done:</label><br>
                                <label><input type="checkbox"  name="test[]" value="Malaria"> Malaria</label>
                                <label><input type="checkbox"  name="test[]" value="Typhoid"> Typhoid</label>
                                <label><input type="checkbox"  name="test[]" value="Brucella"> Brucella</label>
                                <label><input type="checkbox"  name="test[]" value="HIV"> HIV/Aids</label>
                                <label><input type="checkbox"  name="test[]" value="Covid 19"> COVID-19</label>
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
                patients: {},
                consultations: {},
                form: new Form({
                        id: '',
                        patient_id: '',
                        symptoms: '',
                        tests: '',
                        status: ''
                })
            }
        },
        methods: {
              newModal(){
                  this.editmode = false,
                  this.form.reset();
                  $('#addNew').modal('show')  
              },
              editModal(lab){
                  this.editmode = true,
                  this.form.reset();
                  $('#addNew').modal('show')
                  this.form.fill(lab);  
              },              
              updateConsultation(){
                  this.$Progress.start();
                  this.form.put('api/consult/'+this.form.id)
                  .then(() => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                    'Updated!',
                    "Consultation information has been updated.",
                    'success'
                    )
                    Fire.$emit('Refresh');
                  })
                  .catch(() => {
                    this.$Progress.fail();
                  })
              },
              createConsultation(){
                  this.$Progress.start();
                  this.form.post('api/consult')
                  this.form.post('api/pendinglab')
                  .then(() => {
                  $('#addNew').modal('hide')
                  this.$Progress.finish();                                      
                  toast.fire({
                      icon: 'success',
                      title: 'Consultation created successfully'
                      })
                  Fire.$emit('Refresh');      
                  })
                  .catch(() => {
                  this.$Progress.fail();  
                  })
              }, 
              deleteConsultation(id){
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
                  this.form.delete('api/consult/'+id).then(() => {
                  this.$Progress.finish();
                  Swal.fire(
                    'Deleted!',
                    'Consultation has been deleted.',
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
              listPatients(){
                  axios.get('api/listpatients').then((response) => {
                    this.patients = response.data.data;
                    });
              },
              loadConsultations(){
                  axios.get('api/consult').then((response) => {this.consultations = response.data});
              },
        },
        mounted() {
            this.listPatients();
            this.loadConsultations();
            Fire.$on('Refresh',() => {this.loadConsultations();})
        }
    }
</script>
