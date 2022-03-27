<template>

<div class="container-fluid">
        <div class="row mt-3">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable ui-sortable">

            <!-- MESSAGES-->
            <div class="card direct-chat direct-chat-primary">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">Messages</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-primary"
                        @click = "newModal">Compose <i class="fas fa-envelope"></i>
                  </button>                
                </div>
              </div>
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Inbox</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Sent</a></li>
                </ul>
              </div>              
              <!-- /.card-header -->
              <div class="card-body">

                <div class="tab-content">
                    
                    <div class="tab-pane direct-chat-messages active"  id="activity">
                      <div class="direct-chat-msg">
                      <table class="table table-bordered table-hover">
                        <tbody>
                        <tr v-for="message in mymessages.data" :key="message.id">
                          <td>
                            <img class="direct-chat-img" src="subject.png" alt="message user image">
                            <div class="direct-chat-text">
                             <i class="fas fa-clipboard"></i>  
                              {{message.subject}}
                            </div>
                          </td>                           
                          <td>
                           <div class="direct-chat-msg">
                                  <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">{{message.sender.name}}</span>
                                    <span class="direct-chat-timestamp float-right">{{message.created_at | formatDate}}</span>
                                  </div>
                                  <img class="direct-chat-img" src="client.png" alt="Message User Image">
                                  <div class="direct-chat-text">
                                    {{message.body}}
                                    <a v-if="!message.status == '1'" href="#" @click="replyModal(message)">
                                        <i class="fa fa-envelope blue"></i>
                                    </a>   
                                  </div>  
                           </div>
                          </td>
                          <td v-show="message.status == '1'">                           
                            <div class="card card-success card-outline direct-chat direct-chat-success collapsed-card">
                                <div class="card-header">
                                  <div class="card-tools">
                                    <span>Chat</span>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                      <i class="fas fa-plus"></i>
                                    </button>
                                  </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body" style="display: none;">
                                  <div class="direct-chat-messages">
                                    <div class="direct-chat-msg">
                                      <div class="direct-chat-infos clearfix">
                                        <span class="direct-chat-name float-left">{{message.sender.name}}</span>
                                        <span class="direct-chat-timestamp float-right">{{message.created_at | formatDate}}</span>
                                      </div>
                                      <img class="direct-chat-img" src="client.png" alt="Message User Image">
                                      <div class="direct-chat-text">
                                        {{message.body}}
                                      </div>
                                    </div>

                                    <!-- Message to the right -->
                                    <div class="direct-chat-msg right">
                                      <div class="direct-chat-infos clearfix">
                                        <!-- <span class="direct-chat-name float-right">Sarah Bullock</span> -->
                                        <span class="direct-chat-timestamp float-left">{{message.updated_at | formatDate}}</span>
                                      </div>
                                      <img class="direct-chat-img" src="user.png" alt="Message User Image">
                                      <div class="direct-chat-text">
                                        {{message.reply}}
                                      </div>
                                    </div>

                                     <tr v-for="chat in chats.data" :key="chat.id">
                                      <div v-if="chat.message_id == message.id" >
                                        <div v-if="chat.user_id == currentuser_id" class="direct-chat-msg right">
                                          
                                          <div class="direct-chat-infos clearfix">
                                            <!-- <span class="direct-chat-name float-right">Sarah Bullock</span> -->
                                            <span class="direct-chat-timestamp float-left">{{chat.created_at | formatDate}}</span>
                                          </div>
                                          <img class="direct-chat-img" src="user.png" alt="Message User Image">
                                          <div class="direct-chat-text">
                                            {{chat.reply}}
                                          </div>                                          
                                          
                                        </div>

                                        <!-- Message to the right -->
                                        <div v-else-if="chat.user_id !== currentuser_id" class="direct-chat-msg">
                                          <div class="direct-chat-infos clearfix">
                                            <span class="direct-chat-name float-left">{{message.sender.name}}</span>
                                            <span class="direct-chat-timestamp float-right">{{chat.created_at | formatDate}}</span>
                                          </div>
                                          <img class="direct-chat-img" src="client.png" alt="Message User Image">
                                          <div class="direct-chat-text">
                                            {{chat.reply}}
                                          </div>
                                        </div>                                        
                                      </div>                                     
                                     </tr>                            

                                  </div>

                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer" style="display: none;">
                                  <form @submit.prevent= "chatUser(message.id)"> 
                                    <div class="input-group">
                                      <input v-model="form.chat_info" type="text" name="chat_info" placeholder="Type Message ..." class="form-control">
                                      <div v-if="form.errors.has('chat_info')" v-html="form.errors.get('chat_info')" />                                      
                                      <span class="input-group-append">
                                        <button type="submit" class="btn btn-success">Send</button>
                                      </span>
                                    </div>
                                  </form>
                                </div>
                                <!-- /.card-footer-->
                             </div> 
                          </td>
                        </tr>
                        </tbody>
                      </table>
                      </div>
                      <div class="card-footer">
                        <pagination :data="mymessages" @pagination-change-page="getResults">
                            <span slot="prev-nav">&lt; Previous</span>
                            <span slot="next-nav">Next &gt;</span>
                        </pagination>
                      </div> 
                    </div>

                    <div class="tab-pane direct-chat-messages"  id="timeline">
                      <div class="direct-chat-msg right">
                      <table class="table table-bordered table-hover">
                        <tbody>
                        <tr v-for="message in sentmessages.data" :key="message.id">
                            <td>
                             <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                  <span class="direct-chat-name float-left">Subject</span>
                                </div>
                                <img class="direct-chat-img" src="subject.png" alt="Message User Image">
                                <div class="direct-chat-text">
                                  {{message.subject}}
                                </div>
                              </div>
                            </td> 

                            <td>                                                 
                            <div class="direct-chat-infos clearfix">
                              <!-- <span class="direct-chat-name float-right">Sarah Bullock</span> -->
                              <span class="direct-chat-timestamp float-left">{{message.created_at | formatDate}}</span>
                            </div>
                            <img class="direct-chat-img" src="user.png" alt="Message User Image">
                            <div class="direct-chat-text">
                              {{message.body}}
                                    <a v-if="message.status == '1'" href="#">
                                        <i class="fa fa-check-double"></i>
                                    </a>                              
                            </div>
                            </td>
                            <td v-show="message.status == '1'">
                              <div class="card direct-chat direct-chat-warning collapsed-card">
                                <div class="card-header">

                                  <div class="card-tools">
                                    <span>Converse</span>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                      <i class="fas fa-comments"></i>
                                    </button>
                                  </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                  <!-- Conversations are loaded here -->
                                  <div class="direct-chat-messages">
                                    <div class="direct-chat-msg">
                                      <div class="direct-chat-infos clearfix">
                                        <!-- <span class="direct-chat-name float-left">Alexander Pierce</span> -->
                                        <span class="direct-chat-timestamp float-right">{{message.created_at | formatDate}}</span>
                                      </div>
                                      <img class="direct-chat-img" src="user.png" alt="message user image">
                                      <div class="direct-chat-text">
                                        {{message.body}}
                                      </div>
                                    </div>
                                    <!-- /.direct-chat-msg -->

                                    <!-- Message to the right -->
                                    <div class="direct-chat-msg right">
                                      <div class="direct-chat-infos clearfix">
                                        <span class="direct-chat-name float-right">{{message.receiver.name}}</span>
                                        <span class="direct-chat-timestamp float-left">{{message.updated_at | formatDate}}</span>
                                      </div>
                                      <img class="direct-chat-img" src="client.png" alt="message user image">
                                      <div class="direct-chat-text">
                                        {{message.reply}}
                                      </div>
                                    </div>

                                     <tr v-for="chat in chats.data" :key="chat.id">
                                      <div v-if="chat.message_id == message.id" >
                                        <div v-if="chat.user_id == currentuser_id" class="direct-chat-msg right">
                                          
                                          <div class="direct-chat-infos clearfix">
                                            <!-- <span class="direct-chat-name float-right">Sarah Bullock</span> -->
                                            <span class="direct-chat-timestamp float-left">{{chat.created_at | formatDate}}</span>
                                          </div>
                                          <img class="direct-chat-img" src="user.png" alt="Message User Image">
                                          <div class="direct-chat-text">
                                            {{chat.reply}}
                                          </div>                                          
                                          
                                        </div>

                                        <!-- Message to the right -->
                                        <div v-else-if="chat.user_id !== currentuser_id" class="direct-chat-msg">
                                          <div class="direct-chat-infos clearfix">
                                            <span class="direct-chat-name float-right">{{message.receiver.name}}</span>
                                            <span class="direct-chat-timestamp float-left">{{chat.created_at | formatDate}}</span>
                                          </div>
                                          <img class="direct-chat-img" src="client.png" alt="Message User Image">
                                          <div class="direct-chat-text">
                                            {{chat.reply}}
                                          </div>
                                        </div>                                        
                                      </div>                                     
                                     </tr> 

                                  </div>
                                  <!--/.direct-chat-messages-->

                                  <!-- /.direct-chat-pane -->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                  <form @submit.prevent= "chatUser(message.id)"> 
                                    <div class="input-group">
                                      <input v-model="form.chat_info" type="text" name="chat_info" placeholder="Type Message ..." class="form-control">
                                      <div v-if="form.errors.has('chat_info')" v-html="form.errors.get('chat_info')" />                                      
                                      <span class="input-group-append">
                                        <button type="submit" class="btn btn-warning">Send</button>
                                      </span>
                                    </div>
                                  </form>
                                </div>
                                <!-- /.card-footer-->
                              </div>                              
                            </td>
                          </tr>  
                        </tbody>
                      </table>  
                    </div>
                    <div class="card-footer">
                      <pagination :data="sentmessages" @pagination-change-page="fetchResults">
                          <span slot="prev-nav">&lt; Previous</span>
                          <span slot="next-nav">Next &gt;</span>
                      </pagination>
                    </div> 
                    </div> 

                </div>

              </div>
              <!-- /.card-body -->             
            </div>


          </section>
          <!-- /.Left col -->
        </div> 
        
        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog"
            aria-labelledby="addNewModal" aria-hidden="true">
            <div class="modal-dialog model-dialog-centered" role="document">
                <div class="modal-content">
                    <form @submit.prevent="editmode ? replyUser() : sendMessage()"> 
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalTitle">
                            Reply User
                            </h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalTitle">
                            New Message
                            </h5>    
                        <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"> 
                            <div class="form-group" v-if="!editmode" style="display:flex; flex-direction: row;"> 
                            <label>TO:</label>  
                                <select class="form-control" v-model="form.sent_to_id">
                                  <option 
                                      v-for="user in users" :key="user.id"
                                      :value="user.id"
                                      :selected="user.id == form.sent_to_id">{{ user.name }}</option>
                                </select>
                                    <div v-if="form.errors.has('sent_to_id')" v-html="form.errors.get('sent_to_id')" />
                            </div>
                            
                            <!-- <div class="form-group" style="display:flex; flex-direction: row;">
                            <label>Recepient</label>  
                                    <input v-model="form.sender_id" type="integer"
                                    name="sender_id" class="form-control">
                                    <div v-if="form.errors.has('sender_id')" v-html="form.errors.get('sender_id')" />
                            </div> -->

                            <div class="form-group" style="display:flex; flex-direction: row;">
                            <label>RE: </label>  
                                    <input v-model="form.subject" type="text"
                                    name="subject" class="form-control">
                                    <div v-if="form.errors.has('subject')" v-html="form.errors.get('subject')" />
                            </div>

                            <div class="form-group" v-if="!editmode">
                            <label>BODY: </label>  
                                    <textarea v-model="form.body" id="body"
                                    name="body"  class="form-control">
                                    </textarea>
                                    <div v-if="form.errors.has('body')" v-html="form.errors.get('body')" />
                            </div>

                            <div class="form-group" v-if="editmode" style="display:flex; flex-direction: row;">
                            <label>Message</label>  
                                    <textarea v-model="form.body" id="body"
                                    name="body"  class="form-control">
                                    </textarea>
                                    <div v-if="form.errors.has('body')" v-html="form.errors.get('body')" />
                            </div>                            

                            <div class="form-group" v-if="editmode">
                            <label>Reply</label>  
                                    <textarea v-model="form.reply" id="reply"
                                    name="reply"  class="form-control">
                                    </textarea>
                                    <div v-if="form.errors.has('reply')" v-html="form.errors.get('reply')" />
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                        data-dismiss="modal">Close</button>
                        <button type="submit" v-show="editmode" class="btn btn-success">
                        Reply</button>
                        <button type="submit" v-show="!editmode" class="btn btn-primary">
                        Send</button>     
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
       props: ['app'],
       data(){
          return {
            currentuser_id: this.$userId,
            editmode:false,
            mymessages: {},
            sentmessages: {},
            chats: {},
            users: {},
            form: new Form({
                    id: '',
                    subject : '',
                    body : '',
                    reply : '',
                    status : '',
                    photo : '',
                    sender_id : '',
                    sent_to_id: '',
                    chat_info: ''
            }),
          }
        },
        methods: { 
             chatUser(id){
                  this.$Progress.start();
                  this.form.post('api/chat/'+id)
                  .then(() => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                    'Replied!',
                    'Message sent.',
                    'success'
                    )
                    Fire.$emit('RefreshChatFeed');
                  })
                  this.form.reset()
                  .catch(() => {
                    this.$Progress.fail();
                  })
             },      
             getResults(page = 1) {
              this.$Progress.start();  
              axios.get('api/message?page=' + page).then(({ data }) => (this.mymessages = data));
              this.$Progress.finish();
              },
             fetchResults(page = 1) {
              this.$Progress.start();  
              axios.get('api/sentmessage?page=' + page).then(({ data }) => (this.sentmessages = data));
              this.$Progress.finish();
              },                         
              newModal(){
                  this.editmode = false,
                  this.form.reset();
                  $('#addNew').modal('show')  
              },
              replyModal(message){
                  this.editmode = true,
                  this.form.reset();
                  $('#addNew').modal('show')
                  this.form.fill(message);  
              },
              replyUser(){
                  this.$Progress.start();
                  this.form.put('api/message/'+this.form.id)
                  .then(() => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                    'Replied!',
                    'Message has been sent.',
                    'success'
                    )
                    Fire.$emit('Refresh');
                  })
                  .catch(() => {
                    this.$Progress.fail();
                  })
              },
              sendMessage(){
                  this.$Progress.start();
                  this.form.post('api/message')
                  .then(() => {
                  $('#addNew').modal('hide')
                  this.$Progress.finish();                                      
                  toast.fire({
                      icon: 'success',
                      title: 'Message sent successfully'
                      })
                  Fire.$emit('Refresh');      
                  })
                  .catch(() => {
                  this.$Progress.fail();  
                  })
              },              
              loadMyMessages(){
                  axios.get('api/message').then(({data}) => (this.mymessages = data));
              },
              loadSentMessages(){
                axios.get('api/sentmessage').then((response) => {this.sentmessages = response.data});
              },
              loadChats(){
                axios.get('api/chat').then((response) => {this.chats = response.data});
              }, 
              listUsers(){
                  axios.get('api/listusers').then((response) => {
                    this.users = response.data.data;
              });
              }         
        },
        mounted() {
          this.listUsers();
          this.loadMyMessages();
          this.loadSentMessages();
          this.loadChats();
          Fire.$on('RefreshChatFeed',() => {
            this.loadChats();
          })
          Fire.$on('Refresh',() => {
            this.loadMyMessages();
            this.loadSentMessages();
          })
        }
    }
</script>
