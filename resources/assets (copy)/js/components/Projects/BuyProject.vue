<template>
    <section class="pricing_plans_wrapper" v-if="projects[0]">
        <div class="container-fluid clearfix">
            <flash-message class="myCustomClass"></flash-message>
            <label  >Buy Project</label><br>
            <div class="file-upload customBox">
                <div class="form-group">
                    <div class="form-group clearBox">

                        <div class="row">
                            <div class="col-md-2" v-for="project in projects" :project="project" :key="project.id">
                                <div class="thumbnail thumbnailSec">
                                    <div >
                                        <div class="imgThumb">
                                            <span v-if="!project.logo"><img :src="'assets/img/folder.png'" class="img-rounded" width="50%" style="aling:center"></span>
                                            <span v-else ><img :src="project.image_path+'original/'+ project.logo" class="img-rounded" width="100%"></span>
                                            <div class="textOverlay" v-on:click="hite(project.id,project.name)"><span><a href="javascript:void(0)">View Project</a></span></div>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-primary dropdown-toggle"></button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" v-on:click="model_show(project.id)">Share Album</a>
                                            <a class="dropdown-item" v-on:click="download_project(project.id)">Download</a>
                                        </div>
                                    </div>
                                    <div class="caption">
                                        <p class="proName">{{ project.name }} <span class="proDate">12/08/2017</span>
                                        </p>
                                        <p class="payment">Awaiting Payment <span class="amt">${{project.price}}</span>
                                        </p>
                                    </div>
                                </div>
                                <modal :name="'share-project'+project.id">
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
                        </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>
</template>
<script>
    export default {
        data() {
            return {
                projects : '',
            }
        },
        methods: {
            hite(id,name)
            {
                this.$session.set('BuyProject',id);
                this.$router.push('/buyproject/'+name);
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
                    .then(({ data }) => {
                        //this.getUserData();
                        // console.log(data);
                        this.$modal.hide('share-project'+id);
                          model_hide (id);
                          this.flash('Share Project Link Send Mail Id Successfully !', 'success');
                    })
                    .catch(({ response }) => {
                        //console.log(response);
                        // this.flash('Share Project Link not Sent !', 'error');
                    });
            },

            download_project(id){
                var id = id;
                let data = {
                    id: id,
                    id_type:'e',
                };
                axios
                    .post('/api/download_project', data)
                    .then(( response ) => {
                        var url = response.data.data.url;
                        window.location.href = url;
                    })
                    .catch(( response ) => {
                       // console.log(response);
                    });
            },
            getUserProjects(){
                axios.get( '/api/get_buy_project').then((response_data) => {
                    this.projects = response_data.data.UserProjects;
                }).catch(function(response){
                });
            },
        },
        created() {
            this.getUserProjects();
        },
    }
</script>

