<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users List</h3>

                <div class="card-tools">
                 <button type="button" class="btn btn-primary" @click = "newModal">Add New <i class="fas fa-user-plus"></i></button>   
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
                      <th>Role</th>
                      <th>Registered</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                      <td>{{user.id}}</td>
                      <td>{{user.name}}</td>
                      <td>{{user.email}}</td>
                      <td>{{user.role | capitalizeFirstLetter}}</td>
                      <td>{{user.created_at | monthDateTime}}</td>
                      <td>
                          <a href="#" @click= "editModal(user)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          <span>/</span>
                          <a href="#" @click= "deleteUser(user.id)">
                              <i class="fa fa-trash red"></i>
                          </a>                          
                      </td>
                    </tr>
  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="users" @pagination-change-page="getResults">
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
                    <form @submit.prevent="editmode ? updateUser() : createUser()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Update User Info
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New User
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
                            <label>User Role</label>  
                                    <select v-model="form.role" id="role"
                                    name="role" class="form-control">
                                    <option value="">Select User Role</option>
                                    <option value="superadmin">Super Admin</option>
                                    <option value="admin">Admin</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="nurse">Nurse</option>
                                    <option value="pharmacist">Pharmacist</option>
                                    <option value="accountant">Accountant</option>
                                    <option value="staff">Staff</option>
                                    </select>
                                    <div v-if="form.errors.has('role')" v-html="form.errors.get('role')" />
                            </div>

                            <div class="form-group">
                            <label>Bio</label>  
                                    <textarea v-model="form.bio" id="bio"
                                    name="bio" placeholder="Short bio for user(optional)" class="form-control">
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
        data() {
            return{
                editmode:false,
                users: {},
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
        methods:{
              getResults(page = 1) {
			        axios.get('api/user?page=' + page)
				      .then(response => {
					    this.users = response.data;
				      });
              },         
              newModal(){
                  this.editmode = false,
                  this.form.reset();
                  $('#addNew').modal('show')  
              },
              editModal(user){
                  this.editmode = true,
                  this.form.reset();
                  $('#addNew').modal('show')
                  this.form.fill(user);  
              },
              updateUser(){
                  this.$Progress.start();
                  this.form.put('api/user/'+this.form.id)
                  .then(() => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                    'Updated!',
                    'Information has been updated.',
                    'success'
                    )
                    Fire.$emit('Refresh');
                  })
                  .catch(() => {
                    this.$Progress.fail();
                  })
              },
              createUser(){
                  this.$Progress.start();
                  this.form.post('api/user')
                  .then(() => {
                  $('#addNew').modal('hide')
                  this.$Progress.finish();                                      
                  toast.fire({
                      icon: 'success',
                      title: 'User created successfully'
                      })
                  Fire.$emit('Refresh');      
                  })
                  .catch(() => {
                  this.$Progress.fail();  
                  })
              },
              loadUsers(){
                  axios.get('api/user').then(({data}) => (this.users = data));
              },
              deleteUser(id){
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
                  this.form.delete('api/user/'+id).then(() => {
                  this.$Progress.finish();
                  Swal.fire(
                    'Deleted!',
                    'User has been deleted.',
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
        created() {
            this.loadUsers();
            Fire.$on('Refresh',() =>
            {
                this.loadUsers();
            })
        }
    }
</script>
