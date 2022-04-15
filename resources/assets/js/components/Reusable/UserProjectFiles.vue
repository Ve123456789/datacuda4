<template>
    <div class="d_column">
        <div class="d_project_box">
            <div class="d_img_box">
                <img v-if="!project.logo" :src="'assets/img/folder.png'">
                <img v-else :src="project.image_path+'original/'+ project.logo" >
                <div class="d_hover">
                    <div class="d_hover_content">
                        <div class="dropdown">
                        <b-dropdown  text="">
                            <b-dropdown-item v-on:click="model_show_edit_project(project.id,project.name)" >Edit</b-dropdown-item>
                            <!-- <b-dropdown-item v-on:click="model_show(project.id)">Share Album</b-dropdown-item> -->
                            <b-dropdown-item v-on:click="showCopy(project.id)" >Duplicate Album</b-dropdown-item>
                            <b-dropdown-item v-on:click="delete_project(project.id)">Delete</b-dropdown-item>
                            <b-dropdown-item v-on:click="download_project(project.id)">Download</b-dropdown-item>
                        </b-dropdown>
                        </div>
                        <a href="javascript:void(0)" class="btn" v-on:click="hite(project.id)">View project</a>
                        <div class="project-info">
                            <p>{{ project.total_img }} photos</p>
                            <p>{{ project.total_vid }} video</p>
                            <p>{{ project.total_pdf }} pdf</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d_content_data clearfix"> 
                <div class="d__content_data_l">
                    <h6>{{ project.name }}</h6>
                    <p v-if=" project.project_purchase.length > 0" style="color:green" > Paid </p>
                    <p  v-else >
                        <span v-if="project_price_share>0" style="color:red" > Awaiting Payment </span>
                        <span v-else >&nbsp;</span>
                    </p>
                </div>
                <div class="d__content_data_r">
                    <div class="d_date">{{ project.date }}</div>
                    <div class="d_money" v-if=" project.project_purchase.length > 0" > $ {{ project_price }} </div>
                    <div v-else >
                        <div class="d_money"  v-if="project_price_share>0" > $ {{ project_price_share }} </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <modal :name="'share-project'+project.id" class="share_project_model">
            <div class="modal-header p-3">
                <h5 class="modal-title">Share Project</h5>
                <button type="button" class="close m-0" v-on:click="model_hide(project.id)">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-3">
                <form>
                    <div class="form-group">
                        <label lass="col-form-label">Enter The Email ID:</label>
                        <input type="email" class="form-control" name="Email-ID" v-model="email" v-validate="'required|email'">
                        <span class="error" v-if="errors.has('Email-ID')">{{errors.first('Email-ID')}}</span>
                    </div>
                    <div class="form-group">
                        <label lass="col-form-label">Enter password to secure file:</label>
                        <input type="password" class="form-control" name="project_password" v-model="project_password" v-validate="'required'">
                        <span class="error" v-if="errors.has('project_password')">{{errors.first('project_password')}}</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer p-3">
                <button type="button" class="btn btn-secondary" v-on:click="model_hide(project.id)">Close</button>
                <button type="button" class="btn btn-primary" v-on:click="project_share(project.real_id)">Share Project</button>
            </div>
        </modal>

        <modal :name="'model-show-edit-project'+project.id" height="auto" :scrollable="true" draggable=".window-header">
            <div class="window-header">
            <div class="form_content_box">
                <!-- <div class="form_logo"><img src="../../../img/datacuda.png"></div> -->
                <flash-message class="myCustomClass"></flash-message>
                <button type="button" class="close" aria-label="Close"  @click="model_hide_edit_project(project.id)"> &times; </button>

                <h2>Update Project</h2>
                <div class="form-group">
                    <input type="text" name = "project_name" class="form_cus form-control" id="project_name" placeholder="Enter your project name" v-model="project_name" v-validate="'required'">
                    <div v-if="errors.has('project_name')">
                        {{ errors.first('project_name') }}
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn green_btn btn-block mb-3" @click="updateProject(project.id)">UPDATE PROJECT</button>
                    <p class="text-center mb-0"> 
                        <router-link to="/profile/plan">
                            <a class="prime-color">Upgrade</a>
                        </router-link>
                        to access more features
                    </p>
                    <p class="text-center">Compare our  <router-link to="/profile/plan"> <a  class="prime-color">Features.</a> </router-link> </p>
                </div>
            </div>
            </div>
        </modal>
        <modal name="create_project_copy" height="auto" :scrollable="true" draggable=".window-header">
            <div class="window-header">
            <div class="form_content_box">
                <!-- <div class="form_logo"><img src="../../../img/datacuda.png"></div> -->
                <flash-message class="myCustomClass"></flash-message>
                <button type="button" class="close" aria-label="Close"  v-on:click="hideCopy"> &times; </button>

                <h2>Duplicate New Project</h2>
                <div class="form-group">
                    <input type="text" name = "project_name_copy" class="form_cus form-control" id="project_name_copy" placeholder="Enter your project name" v-model="project_name_copy" v-validate="'required'">
                    <div v-if="errors.has('project_name_copy')" class="error" >
                        {{ errors.first('project_name_copy') }}
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn green_btn btn-block mb-3" v-on:click="createProjectCopy">Duplicate PROJECT</button>
                    <p class="text-center mb-0"> 
                        <router-link to="/profile/plan">
                            <a class="prime-color">Upgrade</a>
                        </router-link>
                        to access more features
                    </p>
                    <p class="text-center">Compare our  <router-link to="/profile/plan"> <a  class="prime-color">Features.</a> </router-link> </p>
                </div>
            </div>
            </div>
        </modal>
    </div>
</template>
<script>
    export default {
        data() {
            let projects = '';
            return {
                projects: '',
                email:'',
                project_password:'',
                message: '',
                project_price:0,
                project_price_share:0,
                project_name:'',
                project_name_copy:''
            }
        },
        props: {
            project: Object

        },
        methods: {
            shuffle() {
                //.tweets = _.shuffle(this.tweets)
            },
            hite(id)
            {
                this.$router.push('/project/'+id);
            },
            model_show (id) {
                this.$modal.show('share-project'+id);
            },
            model_hide (id) {
                this.$modal.hide('share-project'+id);
            },
            model_show_edit_project(id,pname){
                this.project_name = pname;
                this.$modal.show('model-show-edit-project'+id);
                
            },
             model_hide_edit_project(id){
                this.$modal.hide('model-show-edit-project'+id);
            },
            updateProject(id){
                console.log("update project",id,this.project_name);
                let data = {
                    project_name: this.project_name,
                    id: id,
                };

                axios
                    .post("/api/update_project", data)
                    .then(( response ) => {
                        if(response.data.status == 201 ){
                            this.flash(response.data.message, "success");
                            this.$router.push('/project/'+ response.data.project_id);
                        }else{
                            this.flash(response.data.error.project_name[0], "error");
                        }
                        
                    })
                    .catch(({ data }) => {
                        this.flash(data.data.message, "success");
                        
                    });
                this.$modal.hide('model-show-edit-project'+id);
                //this.getUserProjects();

            },
            project_share(id){
                this.$validator.validateAll();
                if (this.errors.any()) {
                    return;
                }
                if(this.email == '')
                {
                    return;
                }
                let data = {
                    email: this.email,
                    project_password: this.project_password,

                    id: id
                };
                axios
                    .post('/api/send_project_link', data)
                    .then(({data}) => {
                        this.model_hide(this.project.id);
                        this.$swal({
                            title: "Mail Send Successfully!",
                            text: 'Please Check Mail Your Inbox.',
                            type: 'success',
                        });
                    })
                    .catch(({ response }) => {
                        this.$swal({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        });
                    });

            },
            delete_project (id) {
                //console.log(id);
                let data = {
                    id: id
                };
                axios
                    .post('/api/soft_delete_project', data)
                    .then(( response ) => {
                        //console.log(response);
                        this.$parent.getUserProjects();
                         this.flash('Project Deleted !', 'success');
                    })
                    .catch(( response ) => {
                        this.$parent.getUserProjects();
                       /// console.log('not deleted');
                         this.flash('Project not Deleted', 'error');
                    });
            },
            showCopy (id) {
                console.log("copy project id "+id);
                localStorage.setItem('copy_project_id',id);
                this.$modal.show('create_project_copy');
            },
            hideCopy () {
                this.$modal.hide('create_project_copy');
            },
            createProjectCopy(){
                let project_id = localStorage.getItem('copy_project_id');
                console.log(project_id,this.project_name_copy);
                let data = {
                    project_name: this.project_name_copy,
                    project_id:project_id
                };

                axios
                    .post("/api/create_project_copy", data)
                    .then(( response ) => {
                        console.log(response); 
                        if(response.data.status == 201 ){
                            this.flash(response.data.message, "success");
                            this.$router.push('/project/'+ response.data.project_id);
                        }else{
                           
                            this.flash(response.data.error[0], "error");
                        }
                        
                    })
                    .catch(({ data }) => {
                        this.flash(data.data.message, "success");
                        
                    });
                this.$modal.hide('create_project_copy');
                //this.getUserProjects();
            },
            download_project(id){
                var id = id;
                let data = {
                    id: id,
                    id_type:'e',
                };
                axios
                    .post('/api/user_download_project', data)
                    .then(( response ) => {
                        var url = response.data.data.url;
                        window.location.href = url;
                    })
                    .catch(( response ) => {
                        //console.log(response);
                    });
            }
            ,
            projectPrice(){
                this.project.project_purchase.forEach(element => {
                    this.project_price += parseFloat(element.by_amount);
                });

                this.project.project_ShareImage.forEach(element => {
                    this.project_price_share += parseFloat(element.buy_amount);
                });

                
            }
        },

        created() {
            this.projectPrice();
            //console.log(tweets);
            //console.log("pravin",this.project);
        }
    }

</script>
