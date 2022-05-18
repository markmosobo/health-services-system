<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Lab Tests</h3>
                <div class="card-tools">
                 <button v-show="$gate.isDoc()" type="button" class="btn btn-primary" @click = "newModal">Add New <i class="fas fa-tablets"></i></button>   
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Code</th>
                      <th v-show="$gate.isDoc()">Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="lab in labtests.data" :key="lab.id">
                      <td>{{lab.name}}</td>
                      <td>{{lab.code}}</td>
                      <td v-show="$gate.isDoc()">
                          <a href="#" @click = "editModal(lab)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          <span>/</span>
                          <a href="#" @click = "deleteLabTest(lab.id)">
                              <i class="fa fa-trash red"></i>
                          </a>                        
                      </td>
                    </tr>
  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix" style="display: block;">
                <pagination :data="labtests" @pagination-change-page="getResults">
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
                    <form @submit.prevent="editmode ? updateLabTest() : createLabTest()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Update Lab Test
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            Add New Lab Test
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
                            <label>Code</label>  
                                    <input v-model="form.code" type="text"
                                    name="code" class="form-control">
                                    <div v-if="form.errors.has('code')" v-html="form.errors.get('code')" />
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
            labtests: {},
            form: new Form({
                    id: '',
                    name : '',
                    code : ''
            })
          }
        },
        methods: {
            getResults(page = 1) {
              this.$Progress.start();  
              axios.get('api/labtest?page=' + page).then(({ data }) => (this.labtests = data));
              this.$Progress.finish();
            },              
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
              updateLabTest(){
                  this.$Progress.start();
                  this.form.put('api/labtest/'+this.form.id)
                  .then(() => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                  toast.fire({
                      icon: 'success',
                      title: 'Updated'
                      })
                    Fire.$emit('Refresh');
                  })
                  .catch(() => {
                    this.$Progress.fail();
                  })
              },
              createLabTest(){
                  this.$Progress.start();
                  this.form.post('api/labtest')
                  .then(() => {
                  $('#addNew').modal('hide')
                  this.$Progress.finish();                                      
                  toast.fire({
                      icon: 'success',
                      title: 'Lab test created successfully'
                      })
                  Fire.$emit('Refresh');      
                  })
                  .catch(() => {
                  this.$Progress.fail();  
                  })
              },
              deleteLabTest(id){
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
                  this.form.delete('api/labtest/'+id).then(() => {
                  this.$Progress.finish();
                  Swal.fire(
                    'Deleted!',
                    'Lab test has been deleted.',
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
              },
              loadLabTests(){
                  axios.get('api/labtest').then(({data}) => (this.labtests = data));
              }              
        },
        mounted() {
            this.loadLabTests();
            Fire.$on('Refresh',() => {this.loadLabTests();})
        }
    }
</script>
