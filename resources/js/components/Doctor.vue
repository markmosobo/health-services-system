<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Doctors List</h3>
                <div class="card-tools">
                 <button v-show="$gate.isSuperAdminOrAdmin()" type="button" class="btn btn-primary" @click = "newModal">Add New <i class="fas fa-user-md"></i></button>   
                 <button v-show="$gate.isDocOrNurse()" type="button" class="btn btn-primary" @click = "messageModal">Send Message <i class="fas fa-envelope"></i></button>   
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th v-show="$gate.isSuperAdminOrAdmin()">ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th v-show="$gate.isSuperAdminOrAdmin()">Start Date</th>
                      <th v-show="$gate.isSuperAdminOrAdmin()">Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="doctor in doctors.data" :key="doctor.id">
                      <td v-show="$gate.isSuperAdminOrAdmin()">{{doctor.id}}</td>
                      <td>{{doctor.name}}</td>
                      <td>{{doctor.email}}</td>
                      <td v-show="$gate.isSuperAdminOrAdmin()">{{doctor.created_at | monthDateTime}}</td>
                      <td v-show="$gate.isSuperAdminOrAdmin()">                         
                          <a href="#" @click = "editModal(doctor)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          <span>/</span>
                          <a href="#" @click = "deleteDoctor(doctor.id)">
                              <i class="fa fa-trash red"></i>
                          </a>                        
                      </td>                           
                    </tr>
  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix" style="display: block;">
                <pagination :data="doctors" @pagination-change-page="getResults">
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
                    <form @submit.prevent="editmode ? updateDoctor() : createDoctor()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Update Doctor Info
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New Doctor
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
                            <label>Email Address</label>  
                                    <input v-model="form.email" type="email"
                                    name="email" class="form-control">
                                    <div v-if="form.errors.has('email')" v-html="form.errors.get('email')" />
                            </div>

                            <div class="form-group">
                            <label>Bio</label>  
                                    <textarea v-model="form.bio" id="bio"
                                    name="bio" placeholder="Short bio for doctor(optional)" class="form-control">
                                    </textarea>
                                    <div v-if="form.errors.has('bio')" v-html="form.errors.get('bio')" />
                            </div>

                            <div class="form-group">
                            <label>Password</label>  
                                        <input v-model="form.password" type="password" name="password"
                                        placeholder="Password" class="form-control">
                                        <div v-if="form.errors.has('password')" v-html="form.errors.get('password')" />   
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

        <!-- Message Modal -->
        <div class="modal fade" id="sendMe" tabindex="-1" role="dialog"
            aria-labelledby="sendMeModal" aria-hidden="true">
            <div class="modal-dialog model-dialog-centered" role="document">
                <div class="modal-content">
                    <form @submit.prevent="sendmode ? sendMessage() : replyMessage()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="sendmode" id="sendMeModalTitle">
                            New Message
                            </h5>
                        <h5 class="modal-title" v-show="!sendmode" id="sendMeModalTitle">
                            Reply Message
                            </h5>    
                        <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"> 
                            <div class="form-group" style="display:flex; flex-direction: row; justify-content: center; align-items: center">

                                <label>Recepient:</label>
                                <select class="form-control" v-model="form.sent_to_id">
                                  <option 
                                      v-for="doc in doctorslist" :key="doc.id"
                                      :value="doc.id"
                                      :selected="doc.id == form.sent_to_id">{{ doc.name }}</option>
                                </select>
                                    <div v-if="form.errors.has('sent_to_id')" v-html="form.errors.get('sent_to_id')" />
                            </div>

                            <div class="form-group" style="display:flex; flex-direction: row;">
                            <label>Subject: </label>  
                                    <input v-model="form.subject" type="text"
                                    name="subject" class="form-control">
                                    <div v-if="form.errors.has('subject')" v-html="form.errors.get('subject')" />
                            </div>

                            <div class="form-group">
                            <label>Message</label>  
                                    <textarea v-model="form.body" id="body"
                                    name="body"  class="form-control">
                                    </textarea>
                                    <div v-if="form.errors.has('body')" v-html="form.errors.get('body')" />
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                        data-dismiss="modal">Close</button>
                        <button type="submit" v-show="sendmode" class="btn btn-success">
                        Send</button>
                        <button type="submit" v-show="!sendmode" class="btn btn-primary">
                        Reply</button>     
                    </div>
                   
                    </form>    
                </div>
            </div>
            </div>
        <!-- end of message modal -->               
    </div>
</template>

<script>
    export default {
        data(){
          return{
            editmode:false,
            sendmode: false,
            doctors: {},
            form: new Form({
                    id: '',
                    name : '',
                    email : '',
                    role : '',
                    bio : '',
                    photo : '',
                    password : '',
                    sent_to_id: '',
                    subject: '',
                    body: ''              
            }),
            doctorslist: {},
          }
        },
        methods: {
            getResults(page = 1) {
              this.$Progress.start();  
              axios.get('api/doctor?page=' + page).then(({ data }) => (this.doctors = data));
              this.$Progress.finish();
            },              
              messageModal(message){
                 this.sendmode = true;
                 this.form.reset();
                  $('#sendMe').modal('show')
                  this.form.fill(message);
              },
              sendMessage(){
                  this.$Progress.start();
                  this.form.post('api/message')
                  .then(() => {
                    $('#sendMe').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                    'Sent!',
                    'Message has been delivered.',
                    'success'
                    )
                  })
                  .catch(() => {
                    this.$Progress.fail();
                  })
              },
              replyMessage(){

              },
              newModal(){
                  this.editmode = false,
                  this.form.reset();
                  $('#addNew').modal('show')  
              },
              editModal(doctor){
                  this.editmode = true,
                  this.form.reset();
                  $('#addNew').modal('show')
                  this.form.fill(doctor);  
              },
              updateDoctor(){
                  this.$Progress.start();
                  this.form.put('api/doctor/'+this.form.id)
                  .then(() => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                    Swal.fire(
                    'Updated!',
                    "Doctor's information has been updated.",
                    'success'
                    )
                    Fire.$emit('Refresh');
                  })
                  .catch(() => {
                    this.$Progress.fail();
                  })
              },
              createDoctor(){
                  this.$Progress.start();
                  this.form.post('api/doctor')
                  .then(() => {
                  $('#addNew').modal('hide')
                  this.$Progress.finish();                                      
                  toast.fire({
                      icon: 'success',
                      title: 'Doctor created successfully'
                      })
                  Fire.$emit('Refresh');      
                  })
                  .catch(() => {
                  this.$Progress.fail();  
                  })
              },
              loadDoctors(){
                  axios.get('api/doctor').then(({data}) => (this.doctors = data));
              },
              listDoctors(){
                  axios.get('api/listdoctors').then((response) => {
                    this.doctorslist = response.data.data;
                    });
              },              
              deleteDoctor(id){
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
                  this.form.delete('api/doctor/'+id).then(() => {
                  this.$Progress.finish();
                  Swal.fire(
                    'Deleted!',
                    'Doctor has been deleted.',
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
              }
        },
        mounted() {
            this.loadDoctors();
            this.listDoctors();
            Fire.$on('Refresh',() => {this.loadDoctors();})
        }
    }
</script>
