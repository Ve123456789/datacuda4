<template>
<div>
		<div v-if = "loading" class="main_model_box">
			<div class="model_box loader"></div>
		</div>
		<section class="margin_top_for_header"></section>
		<!-- Dashboard Project -->
		<section class="dashboard__filter">
			<div class="d_container container">
				<div class="row clearfix">
					<div class="col-md-2 col-lg-2 col-sm-6">
						<ul class="filter_list_nav ">
							<li>
								<div class="form-group">
									<select name="" id="" class="form-control" v-model="order_by">
										<option value="id">Sort</option>
										<option value="project_name">Name</option>
										<option value="created_at">Date</option>
									</select>
								</div>
							</li>
						</ul>
					</div>
					<div class="col-md-4 col-lg-3 col-sm-6">
						<p class=""><i class="fa fa-database" aria-hidden="true"></i> Disk Usage : {{datausag.value}} {{ datausag.type | uppercase }} <br/><i class="fa fa-pie-chart" aria-hidden="true"></i> Plan : {{ usagedata.plan  }} {{ usagedata.plan_unit | uppercase }}</p>
					</div>
					<div class="col-md-12 col-lg-7 col">
						<ul class="project_p_ost btn_group_list_nav d-flex custom-nav">
							<li>
								<form class="search__container">
									<!-- <div class="form-group">
                                        <input type="text" id="search-bar" v-model="keywords" class="form-control">
									<a href="#" class="p_search_icon"><img src="../../../img/search_icon.png"></a>
                                    </div> -->
                                    <input type="text" id="search-bar" v-model="keywords" class="form-control">
									<a href="#" class="p_search_icon"><img src="../../../img/search_icon.png"></a>
								</form>
							</li>
							<li><a href="javascript:void(0)" @click="show" :style="{'text-transform':'none'}" >Create Project </a></li>
							<li><a href="javascript:void(0)" @click="submit" :style="{'text-transform':'none'}" ><i class="fa fa-cloud-upload" aria-hidden="true"></i> Upload To Storage </a></li>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<!-- Project Post -->
		<section class="dashboard_wrapper grey_bg">
			<flash-message class="myCustomClass"></flash-message>
			<div class="d_container container">
				<div class="d_flex row">
					<div class="d_column">
						<div class="d_add_new">
							<div class="d_add_content" @click="show">
								<img v-bind:src="'/assets/img/plus.png'"> <div class="d_add_text">Create New Project</div>
							</div>
						</div>
					</div>
                  

					<UserProjectFiles v-for="project in projects" :project="project" :key="project.id"/>
                    
				</div>
				<!-- <div class="d_flex row">
					<div class="d_column">
						<div class="d_add_new">
							<div class="d_add_content">
									<input type="file" multiple="multiple" id="file" @change="uploadFieldChange">
									<label class="btn_browse" for="file"><img v-bind:src="'/assets/img/plus.png'"> <div class="d_add_text">Add New Image</div></label>
							</div>
						</div>
					</div>
					<NewFileUpload v-for="media in medias" :media="media" :key="media.id"/>
				</div> -->
			</div>
		</section>
        <modal name="create_project" height="auto" :scrollable="true" draggable=".window-header">
        <div class="window-header">
        <div class="form_content_box">
            <!-- <div class="form_logo"><img src="../../../img/datacuda.png"></div> -->
            <flash-message class="myCustomClass"></flash-message>
            <button type="button" class="close" aria-label="Close"  @click="hide"> &times; </button>

            <h2>Create New Project</h2>
            <div class="form-group">
                <input type="text" name = "project_name" class="form_cus form-control" id="project_name" placeholder="Enter your project name" v-model="project_name" v-validate="'required'">
				<div v-if="errors.has('project_name')" class="error" >
					{{ errors.first('project_name') }}
				</div>
            </div>
            <div class="form-group">
                <button class="btn green_btn btn-block mb-3" @click="createProject">CREATE PROJECT</button>
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
<script type="text/javascript">
    // $(document).ready(function(){
    //     //alert("yes ");
       
    // });
    
</script>

<script>
    import NewFileUpload from '../Reusable/NewFileUpload';
    import UserProjectFiles from '../Reusable/UserProjectFiles';
    import BuyProject from '../Projects/BuyProject.vue';

    export default {
        components: {
            NewFileUpload,
            UserProjectFiles,
            BuyProject
        },
        props: [
            'settings'
        ],
        data() {
            return {
                order_by: 'id',
                keywords: null,
                loading: 0,
                img_amount:'',
                project_name: '',
                medias : [],
                projects : [],
                file: [],
                attachment_labels: [], // List of old uploaded files coming from the server
                categories: [],
                data: new FormData(),
                percentCompleted: 0,
                imageData: null,
                usagedata : '',
                datausag : '',
                image_path : '',
            }
        },
        watch: {
            keywords(after, before) {
                this.fetch();
            },
            order_by(after, before) {
                this.getUserProjects();
            }
        },
        methods: {

            fetch() {
                axios.get('/api/search', { params: { keywords: this.keywords } })
                    .then((response) => {
                            this.projects = response.data.UserProjects;
                       })
                    .catch(error => {});
            },
            getUserFiles() {
                axios.get( '/api/get_user_files').then((response) => {
                    this.medias = response.data.user_medias;
                    this.image_path = response.data.image_path;
                }).catch(function(response){
                });
            },
            getUserProjects(){
                //console.log("kjkljk"+this.order_by);
                axios.get( '/api/get_user_project', { params: { order_by: this.order_by } }).then((response_data) => {
                    this.projects = response_data.data.UserProjects;
                    this.usagedata = response_data.data.usagedata;
                    this.datausag = response_data.data.usagedata.usag;
                }).catch(function(response){
                });
            },
            selectCategory(attachment, category_id) {
                attachment.category_id = category_id;
               // console.log(attachment);
                this.$forceUpdate();
            },
            validate() {
                    if (!this.file.length) {
                        this.flash('Please select at least one file', "warning");
                        return false;
                    }
                    return true;
            },
            show () {
                this.$modal.show('create_project');
            },
            hide () {
                this.$modal.hide('create_project');
            },
            createProject(){

                let data = {
                    project_name: this.project_name,
                };

                axios
                    .post("/api/create_project", data)
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
                this.$modal.hide('create_project');
                this.getUserProjects();
            },
            pullCategories() {
              // Make HTTP request to store announcement
              //  axios.post('/api/none')
              //       .then(function (response) {
              //           console.log(response);
              //           if (response.data.success) {
              //               this.categories = response.data.data;
              //               console.log('Categories: ', this.categories);
              //               toastr.success('We just pulled all the categories', 'Background Task: Success');
              //           } else {
              //               console.log(response.data.errors);
              //               toastr.warning('Cannot pull categories. User has to be logged in', 'Background Task: Warning');
              //           }
              //       }.bind(this)) // Make sure we bind Vue Component object to this funtion so we get a handle of it in order to call its other methods
              //       .catch(function (error) {
              //           console.log(error);
              //       });
            },
            getfileize() {
                this.upload_size = 0; // Reset to beginningƒ
                this.file.map((item) => { this.upload_size += parseInt(item.size); });
                this.upload_size = Number((this.upload_size).toFixed(1));
                this.$forceUpdate();
            },
            getImagePreviews(){
                for( let i = 0; i < this.file.length; i++ ){
                  if ( /\.(jpe?g|png|gif)$/i.test( this.file[i].name ) ) {
                    let reader = new FileReader();
                    reader.addEventListener("load", function(){
                      this.$refs['image'+parseInt( i )][0].src = reader.result;
                    }.bind(this), false);
                    reader.readAsDataURL( this.file[i] )
                   }
                }
            },
            prepareFields() {
                for (var i = this.file.length - 1; i >= 0; i--) {
                    //console.log(this.file[i].category_id);
                    this.data.append("file[][0]", this.file[i]);
                    this.data.append("file[][1]", this.file[i].category_id);
                }
                for (var i = this.attachment_labels.length - 1; i >= 0; i--) {
                }
            },
            removeAttachment(attachment) {
                this.file.splice(this.file.indexOf(attachment), 1);
                this.getfileize();
                this.fileInput.file = null

            },
            uploadFieldChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                for (var i = files.length - 1; i >= 0; i--) {
                    this.file.push(files[i]);
		    }

		// Reset the form to avoid copying these files multiple times into this.file
            document.getElementById("file").value = [];
		        this.getImagePreviews();
            },
            submit() {
                this.prepareFields();
                let check_amount = 0;
                this.$validator.validate('Image Amount').then((res)=>{ if(!res){ check_amount = 1;}});
                if(check_amount === 1)
                {
                    return;
                }
                if (!this.validate())  {

                    return false;
                }
                this.loading = 1;
                var config = {
                    headers: { 'Content-Type': 'multipart/form-data' } ,
                    onUploadProgress: function(progressEvent) {
                        this.percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                       // window.Event.fire('percent', this.percentCompleted);
                        //console.log(this.percentCompleted);
                        this.$forceUpdate();
                    }.bind(this)
                };
                // Make HTTP request to store announcement
                this.data.append('imgamount', this.img_amount);
                axios.post('/api/multiple-files', this.data, config)
                    .then(function (response) {
                        if (response.data.success) {
                            this.flash('Files uploaded!', 'success');
                            this.resetData();
                            this.getUserFiles();
                            this.loading = 0;
                            //window.Event.fire('reload_files'); // Tell AttachmentList component to refresh its list
                        } else {
                            this.loading = 0;

                            this.flash('Something went wrong', 'error');
                        }
                    }.bind(this)) // Make sure we bind Vue Component object to this funtion so we get a handle of it in order to call its other methods
                    .catch(function (error) {
                        //console.log(error);
                        this.loading = 0;
                    });

            },
			 // We want to clear the FormData object on every upload so we can re-calculate new files again.
            // Keep in mind that we can delete files as well so in the future we will need to keep track of that as well
            resetData() {
                //console.log('reset data');
                this.data = new FormData(); // Reset it completely
                this.file = [];
                this.percentCompleted = 0;
            },
            start() {
                this.getUserFiles();
                this.getUserProjects();
                this.pullCategories();
            },
            
        },
        created() {
                this.start();
        },
        filters: {
            uppercase: (v) => {
                return v ? v.toUpperCase() : null;
            }
        },
        mounted(){
            var winHeight = $(window).height();
            var margin_top_for_header = $('.margin_top_for_header').outerHeight();
            var dashboard__filter = $('.dashboard__filter').outerHeight();
            var main_footer = $('.main_footer').outerHeight();
            var grey_bg = winHeight - margin_top_for_header - dashboard__filter - main_footer;
            $('.grey_bg').css('min-height', grey_bg)


            $(window).resize(function(){
                var winHeight = $(window).height();
                var margin_top_for_header = $('.margin_top_for_header').outerHeight();
                var dashboard__filter = $('.dashboard__filter').outerHeight();
                var main_footer = $('.main_footer').outerHeight();
                var grey_bg = winHeight - margin_top_for_header - dashboard__filter - main_footer;
                $('.grey_bg').css('min-height', grey_bg)
            })
        },
        updated() {
            // run something after dom has changed by vue

        }

    }
</script>


