<style>
.widget-user-header{
    background-position: center center;
    background-size: cover;
    height: 250px;
}
</style>

<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info" style="background-image:url('./images/sunflower.jpg')">
                <h3 class="widget-user-username">{{form.name}}</h3>
                <h5 class="widget-user-desc">{{form.role}}</h5>
              </div>
              <div class="widget-user-image">
                <!-- <img class="img-circle elevation-2" :src="showProfilePhoto()" alt="User Avatar"> -->
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">{{sentmessages}}</h5>
                      <span class="description-text">MESSAGES SENT</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">{{receivedmessages}}</h5>
                      <span class="description-text">MESSAGES RECEIVED</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">{{chatmessages}}</h5>
                      <span class="description-text">CHAT MESSAGES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.widget-user -->

            <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane" id="activity">
                      <h3>Display User Activity</h3>
                  </div>

                  <div class="tab-pane active" id="settings">
                    <form class="form-horizontal">

                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                          <input v-model="form.name" type="text" class="form-control" placeholder="Name" id="inputName">
                          <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" />   

                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                          <input v-model="form.email" type="email" class="form-control" id="inputEmail" placeholder="Email Address">
                          <div v-if="form.errors.has('email')" v-html="form.errors.get('email')" />   

                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label">Experience</label>
                        <div class="col-sm-12">
                          <textarea v-model="form.bio" class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                          <div v-if="form.errors.has('bio')" v-html="form.errors.get('bio')" />   

                        </div>
                      </div>

                      <div class="form-group">
                        <label for="photo" class="col-sm-8 control-label">Profile Photo</label>
                        <div class="col-sm-12">
                          <input type="file" @change="updateProfile" name="photo" class="form-input">
                        </div>  
                      </div>

                      <div class="form-group">
                        <label for="inputPassword" class="col-sm-12 control-label">Password
                          (leave empty if not changing)
                        </label>
                        <div class="col-sm-12">
                          <input v-model="form.password" type="password" class="form-control" name="password">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-12">
                          <button @click.prevent="updateInfo" type="submit" class="btn btn-success">Update</button>
                        </div>
                      </div>

                    </form>

                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return{
              sentmessages: [],
              receivedmessages: [],
              chatmessages: [], 
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
            updateProfile(element){
              // console.log('Uploading')
            let file = element.target.files[0];
            let reader = new FileReader();
            console.log(file)
            if(file['size'] < 211177){
            reader.onloadend = (file) => {
              // console.log('RESULT',reader.result)
            this.form.photo = reader.result
            }
            reader.readAsDataURL(file);    
            }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'You are uploading a large file'
            })  
            }  
            },
            showProfilePhoto(){
            let photo = (this.form.photo.length > 200) ? this.form.photo : "images/"+ this.form.photo;
            return photo;
            },         
            updateInfo(){
              this.$Progress.start();
              this.form.put('api/profile')
              .then(() => {
              this.$Progress.finish();
              Swal.fire(
                    'Updated!',
                    'Your profile has been updated.',
                    'success'
                    )  
              })
              .catch(() => {
              this.$Progress.fail();
              Swal.fire(
                    'Failed!',
                    'There was an error.Please try again',
                    'warning'
                    )
              })
            },
            loadMessagesSent(){
            axios.get('api/countsentmessages').then(({data}) => (this.sentmessages = data));
            },
            loadMessagesReceived(){
            axios.get('api/countreceivedmessages').then(({data}) => (this.receivedmessages = data));
            },
            loadChatMessages(){
            axios.get('api/countchatmessages').then(({data}) => (this.chatmessages = data));
            }
        },
        created(){
            axios.get('api/profile').then(({data}) =>  (this.form.fill(data)));          
            this.loadMessagesSent();
            this.loadMessagesReceived();
            this.loadChatMessages();
        }
    }
</script>
