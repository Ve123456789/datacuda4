<template>
	<section class="pricing_plans_wrapper">
		<div v-if = "loading" class="main_model_box">
			<div class="model_box loader"></div>
		</div>
		<!-- <div class="container clearfix">
			<flash-message class="myCustomClass"></flash-message>
			<div class="file-upload">
				<div class="form-group">
					<div class="row">
						<div class="col-md-4 col-lg-3 ml-auto">
							<div class="uploadSection">
								<button class="btn btn-primary uploadBtn blue_btn" @click="submit"> <i class="fa fa-cloud-upload" aria-hidden="true"></i>Upload to storage</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> -->
		<section class="dashboard_wrapper grey_bg">
			<div class="d_container container">
				<div class="d_flex row">
					<div class="d_column">
						<div class="d_add_new">
							<div class="d_add_content">
								<input type="file" multiple="multiple" id="file" @change="uploadFieldChange">
								<label class="btn_browse" for="file"><img v-bind:src="'/assets/img/plus.png'"> <div class="d_add_text">Add New Image</div></label>
							</div>
						</div>
					</div>
					<NewFileUpload v-for="media in medias" :media="media" :key="media.id"/>
				</div>
			</div>
		</section>
	</section>
</template>
<script>
    import NewFileUpload from '../Reusable/NewFileUpload';

    export default {
        components: {
            NewFileUpload,
        },
        props: [
            'settings'
        ],
        data() {
            return {
                keywords: null,
                order_by: 'id',
                id : this.$route.params.id,
                loading: 0,
                img_amount:'',
                medias : [],
                file: [],
                attachment_labels: [], // List of old uploaded files coming from the server
                categories: [],
                // Each file will need to be sent as FormData element
                data: new FormData(),
                percentCompleted: 0,
                imageData: null,
            }
        },
        watch: {
            keywords(after, before) {
                this.fetch();
            },
            order_by(after, before) {
                this.getProjectData();
            }
        },
        methods: {
            fetch() {
                axios.get('/api/search_files', { params: { keywords: this.keywords, id: this.id } })
                    .then(response => this.medias = response.data)
                    .catch(error => {});
            },
            getProjectData()
            {
                let data  = {
                    pro_id:this.$route.params.id,
                    order_by: this.order_by
                };
                axios
                    .post('/api/getprojectdata',data).then((response)=>{
                    this.medias = response.data.project_medias;
                    this.image_path = response.data.path;
                })
                    .catch(({ response }) => {
                        //console.log(response);
                        this.$router.push('/');
                    });
            },
            getUserFiles() {
                let data  = {
                    pro_id:this.$route.params.id,
                    order_by: this.order_by
                };
                axios
                    .post('/api/getprojectdata',data).then((response)=>{
                    this.medias = response.data.project_medias;
                })
                    .catch(({ response }) => {
                       // console.log(response);
                        this.$router.push('/');
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
                this.$validator.validate('Image Amount').then((res)=>{ if(!res){ check_amount = 1;}});
                if (!this.validate()) {
                    return false;
                }
                this.loading = 1;
                var config = {
                    headers: { 'Content-Type': 'multipart/form-data' } ,
                    onUploadProgress: function(progressEvent) {
                        this.percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                        window.Event.fire('percent', this.percentCompleted);
                        //console.log(this.percentCompleted);
                        this.$forceUpdate();
                    }.bind(this)
                };
                this.data.append('imgamount', this.img_amount);
                this.data.append('project_id', this.$route.params.id);
                axios.post('/api/project-multiple-files',this.data,config)
                    .then(function (response) {

                        if (response.data.success) {
                            this.flash('Files uploaded!', 'success');
                            this.resetData();
                            this.getProjectData();
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
            resetData() {
              //  console.log('reset data');
                this.data = new FormData(); // Reset it completely
                this.file = [];
                this.percentCompleted = 0;
            },
            start() {
                this.getProjectData();

            },
        },
        created() {
            this.start();
        },
        updated() {
            // run something after dom has changed by vue

        }

    }
</script>
<style>
	.loading {
		position: fixed;
		z-index: 999;
		height: 2em;
		width: 2em;
		overflow: show;
		margin: auto;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
	}
</style>


