<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <!--lab results -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">My Labs</h3>
                <div class="card-tools">
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Patient</th>
                      <th>Test(s) Completed</th>
                      <th>Result(s)</th>
                      <th>Tested On</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="lab in labfindings.data" :key="lab.id">
                      <td>{{lab.patient.first_name}} {{lab.patient.last_name}}</td>
                      <td>{{lab.tested.name}}</td>
                      <td>{{lab.results}}</td>
                      <td>{{lab.created_at | monthDateTime}}</td>
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
                    <form @submit.prevent="editmode ? updateLab() : createLab()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Post Lab Result
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New Lab
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
                                      v-for="pat in patientslist" :key="pat.id"
                                      :value="pat.id"
                                      :selected="pat.id == form.patient_id">{{ pat.name }}</option>
                                </select>
                                    <div v-if="form.errors.has('patient_id')" v-html="form.errors.get('patient_id')" />
                            </div>  

                            <div class="form-group">

                                <label>Tests done:</label><br>
                                <label><input type="checkbox"  name="test[]" value="Malaria"> Malaria</label>
                                <label><input type="checkbox"  name="test[]" value="Typhoid"> Typhoid</label>
                                <label><input type="checkbox"  name="test[]" value="Brucella"> Brucella</label>
                                <label><input type="checkbox"  name="test[]" value="HIV"> HIV/Aids</label>
                                <label><input type="checkbox"  name="test[]" value="Covid 19"> COVID-19</label>
                            </div> 

                            <div class="form-group">
                            <label>Results</label>  
                                    <textarea v-model="form.results" id="results"
                                    name="results" placeholder="Test results" class="form-control">
                                    </textarea>
                                    <div v-if="form.errors.has('results')" v-html="form.errors.get('results')" />
                            </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                        data-dismiss="modal">Close</button>
                        <button type="submit" v-show="editmode" class="btn btn-primary">
                        Post</button>
                        <button type="submit" v-show="!editmode" class="btn btn-success">
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
                labfindings: {},
                patientslist: {},
                form: new Form({
                        id: '',
                        patient_id: '',
                        tests: '',
                        results: ''
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
              updateLab(){
                this.$Progress.start();
                Swal.fire({
                  title: 'Do you want to post the lab result?',
                  showDenyButton: true,
                  showCancelButton: true,
                  confirmButtonText: 'Confirm',
                  denyButtonText: `Deny`,
                }).then((result) => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                    if (result.isConfirmed) {
                    this.form.put('api/pendinglab/'+ this.form.id)
                    this.form.post('api/lab').then((response)=>{
                    console.log(response);  
                    Swal.fire('Posted!', '', 'success')
                    Fire.$emit('Refresh');
                    }).catch(() => {
                    this.$Progress.fail();
                    console.log('err');  
                    })
                    }else if(result.isDenied){
                    Swal.fire('The result was not posted','','warning')
                    }
                })
              },
              createLab(){
                  this.$Progress.start();
                  this.form.post('api/pendinglab')
                  .then(() => {
                  $('#addNew').modal('hide')
                  this.$Progress.finish();                                      
                  toast.fire({
                      icon: 'success',
                      title: 'Lab created successfully'
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
              loadLabs(){
                  axios.get('api/lab').then((response) => {this.labfindings = response.data});
              }
        },
        mounted() {
            this.listPatients();
            this.loadLabs();
            Fire.$on('Refresh',() => {this.loadLabs();})
        }
    }
</script>
