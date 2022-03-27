<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Rooms List</h3>
                <div class="card-tools">
                 <button v-show="$gate.isStaff()" type="button" class="btn btn-primary" @click = "newModal">Add New <i class="far fa-hospital"></i></button>   
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Room ID</th>
                      <th>Name</th>
                      <th>Type</th>
                      <th>Status</th>
                      <th v-show="$gate.isStaff()">Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="room in rooms.data" :key="room.id">
                      <td><a href="#">RM{{room.id}}</a></td>
                      <td>{{room.name}}</td>
                      <td>{{room.type | capitalizeFirstLetter}}</td>
                      <td>
                        <span v-if="room.status == '0' " class="badge badge-info">Available</span>
                        <span v-else class="badge badge-warning">Full</span>
                      </td>
                      <td v-show="$gate.isStaff()">
                          <a href="#" @click = "editModal(room)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          <span>/</span>
                          <a href="#" @click = "deleteRoom(room.id)">
                              <i class="fa fa-trash red"></i>
                          </a>                        
                      </td>
                    </tr>
  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix" style="display: block;">
                <pagination :data="rooms" @pagination-change-page="getResults">
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
                    <form @submit.prevent="editmode ? updateRoom() : createRoom()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Update Room Info
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New Room
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
                            <label>Room Type</label>  
                                    <select v-model="form.type" id="type"
                                    name="type" class="form-control">
                                    <option value="">Select Room Type</option>
                                    <option value="ward">Ward</option>
                                    <option value="store">Store</option>
                                    <option value="office">Office</option>
                                    <option value="residential">Residential</option>
                                    </select>
                                    <div v-if="form.errors.has('type')" v-html="form.errors.get('type')" />
                            </div>                            

                            <div class="form-group">
                            <label>Capacity(optional)*</label>  
                                    <input v-model="form.capacity" type="text"
                                    name="capacity" class="form-control">
                                    <div v-if="form.errors.has('capacity')" v-html="form.errors.get('capacity')" />
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
            rooms: {},  
            form:new Form({
                    id: '',
                    name: '',
                    type: '',
                    capacity: ''
                })    
            }
        },
        methods: {
            getResults(page = 1) {
              this.$Progress.start();  
              axios.get('api/room?page=' + page).then(({ data }) => (this.rooms = data));
              this.$Progress.finish();
            },              
              newModal(){
                  this.editmode = false,
                  this.form.reset();
                  $('#addNew').modal('show')  
              },
              editModal(room){
                  this.editmode = true,
                  this.form.reset();
                  $('#addNew').modal('show')
                  this.form.fill(room);  
              },
              updateRoom(){
                  this.$Progress.start();
                  this.form.put('api/room/'+this.form.id)
                  .then(() => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                    'Updated!',
                    "Room information has been updated.",
                    'success'
                    )
                    Fire.$emit('Refresh');
                  })
                  .catch(() => {
                    this.$Progress.fail();
                  })
              },
              createRoom(){
                  this.$Progress.start();
                  this.form.post('api/room')
                  .then(() => {
                  $('#addNew').modal('hide')
                  this.$Progress.finish();                                      
                  toast.fire({
                      icon: 'success',
                      title: 'Room created successfully'
                      })
                  Fire.$emit('Refresh');      
                  })
                  .catch(() => {
                  this.$Progress.fail();  
                  })
              },
              loadRooms(){
                  axios.get('api/room').then((response) => {this.rooms = response.data});
              }                          
        },
        created() {
            this.loadRooms();
            Fire.$on('Refresh',() => {this.loadRooms()});
        }
    }
</script>
