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
                            <b-dropdown-item>Edit</b-dropdown-item>
                            <b-dropdown-item v-on:click="model_show(project.id)">Share Album</b-dropdown-item>
                            <b-dropdown-item>Duplecate Album</b-dropdown-item>
                            <b-dropdown-item v-on:click="delete_project(project.id)">Delete</b-dropdown-item>
                            <b-dropdown-item v-on:click="download_project(project.id)">Download</b-dropdown-item>
                        </b-dropdown>
                        </div>
                        <a href="javascript:void(0)" class="btn" v-on:click="hite(project.id)">veiw project</a>
                    </div>
                </div>
            </div>
            <div class="d_content_data clearfix">
                <div class="d__content_data_l">
                    <h6>{{ project.name }}</h6>
                    <p>Project Price</p>
                </div>
                <div class="d__content_data_r">
                    <div class="d_date">12/08/2017</div>
                    <div class="d_money">${{project.price}}</div>
                </div>
            </div>
        </div>
        <modal :name="'share-project'+project.id" class="share_project_model">
            <div class="modal-header">
                <h5 class="modal-title">Share Project</h5>
                <button type="button" class="close" v-on:click="model_hide(project.id)">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" v-on:click="model_hide(project.id)">Close</button>
                <button type="button" class="btn btn-primary" v-on:click="project_share(project.real_id)">Share Project</button>
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
        },

        created() {
            //console.log(tweets);

        }
    }

</script>
