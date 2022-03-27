<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Pharmacists List</h3>
                <div class="card-tools">
                 <button type="button" class="btn btn-primary" @click = "newModal">Add New <i class="fas fa-tablets"></i></button>   
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Start Date</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="pharmacist in pharmacists.data" :key="pharmacist.id">
                      <td>{{pharmacist.id}}</td>
                      <td>{{pharmacist.name}}</td>
                      <td>{{pharmacist.email}}</td>
                      <td>{{pharmacist.created_at | monthDateTime}}</td>
                      <td>
                          <a href="#" @click = "editModal(pharmacist)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          <span>/</span>
                          <a href="#" @click = "deletePharmacist(pharmacist.id)">
                              <i class="fa fa-trash red"></i>
                          </a>                        
                      </td>
                    </tr>
  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix" style="display: block;">
                <pagination :data="pharmacists" @pagination-change-page="getResults">
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
                    <form @submit.prevent="editmode ? updatePharmacist() : createPharmacist()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Update Pharmacist Info
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New Pharmacist
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
                                    name="bio" placeholder="Short bio for pharmacist(optional)" class="form-control">
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
    </div>
</template>

<script>
    export default {
        data(){
          return{
            editmode:false,
            pharmacists: {},
            form: new Form({
                    id: '',
                    name : '',
                    email : '',
                    role : '',
                    bio : '',
                    photo : '',
                    password : ''              
            })
          }
        },
        methods: {
            getResults(page = 1) {
              this.$Progress.start();  
              axios.get('api/pharmacist?page=' + page).then(({ data }) => (this.pharmacists = data));
              this.$Progress.finish();
            },             
             newModal(){
                  this.editmode = false,
                  this.form.reset();
                  $('#addNew').modal('show')  
              },
              editModal(pharmacist){
                  this.editmode = true,
                  this.form.reset();
                  $('#addNew').modal('show')
                  this.form.fill(pharmacist);  
              },
              updatePharmacist(){
                  this.$Progress.start();
                  this.form.put('api/pharmacist/'+this.form.id)
                  .then(() => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                    Swal.fire(
                    'Updated!',
                    "pharmacist's information has been updated.",
                    'success'
                    )
                    Fire.$emit('Refresh');
                  })
                  .catch(() => {
                    this.$Progress.fail();
                  })
              },
              createPharmacist(){
                  this.$Progress.start();
                  this.form.post('api/pharmacist')
                  .then(() => {
                  $('#addNew').modal('hide')
                  this.$Progress.finish();                                      
                  toast.fire({
                      icon: 'success',
                      title: 'pharmacist created successfully'
                      })
                  Fire.$emit('Refresh');      
                  })
                  .catch(() => {
                  this.$Progress.fail();  
                  })
              },
              loadPharmacists(){
                  axios.get('api/pharmacist').then(({data}) => (this.pharmacists = data));
              },
              deletePharmacist(id){
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
                  this.form.delete('api/pharmacist/'+id).then(() => {
                  this.$Progress.finish();
                  Swal.fire(
                    'Deleted!',
                    'pharmacist has been deleted.',
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
            this.loadPharmacists();
            Fire.$on('Refresh',() => {this.loadPharmacists();})
        }
    }
</script>
