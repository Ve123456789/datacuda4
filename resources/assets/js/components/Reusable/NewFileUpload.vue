<template xmlns:v-img="http://www.w3.org/1999/xhtml">
    <div class="d_column">
        <div class="d_project_box">
            <div class="d_img_box">
                <b-dropdown class="image_dropdown" right size="sm">
                    <b-dropdown-item v-on:click="edit_fun(media.id,media.title)">Edit</b-dropdown-item>
                    <b-dropdown-item v-on:click="model_show(media.id)">Share Media</b-dropdown-item>
                    <b-dropdown-item v-on:click="delete_media(media.id)">Delete File</b-dropdown-item>
                </b-dropdown>
                <img   v-if="media.ext === 'jpg' || media.ext === 'png' || media.ext === 'gif'" v-bind:src="image_path+'thumb/'+  media.filename" v-img:name >
                <img   v-else-if="media.ext === 'mp4'" v-bind:src="'/assets/img/video.png'" v-on:click="view_video(media.id)">
                <a  v-else v-bind:href="image_path+'file/' + media.filename"><img v-bind:src="'/assets/img/pdf_icon.png'" ></a>
            </div>
            <div class="d_content_data clearfix">
                <div class="d__content_data_l">
                    <h6 :id="'image_title_e'+media.id" contenteditable="false" v-on:focusout="title_edit(media.id,media.title)">{{ this.media.title.substring(0,10) + '...' }}</h6>
                    <p>Image Price</p>
                </div>
                <div class="d__content_data_r">
                    <div class="d_date">12/08/2017</div>
                    <div class="d_money">$<input class="form-input image_price" type="text" :id="'image_amount_e'+media.id" :value="media.amount" readonly="readonly" v-on:focusout="amout_edit(media.id,media.amount)" ></div>
                </div>
            </div>
        </div>
        <modal :name="'share-image'+media.id" height="35%" width="40%">
            <div class="modal-header">
                <h5 class="modal-title">Share Image</h5>
                <button type="button" class="close" v-on:click="model_hide(media.id)">
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
                        <input type="password" class="form-control" name="Project Password" v-model="project_password" v-validate="'required'" >
                        <span class="error" v-if="errors.has('Project Password')">{{errors.first('Project Password')}}</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" v-on:click="model_hide(media.id)">Close</button>
                <button type="button" class="btn btn-primary" v-on:click="image_share(media.id)">Share Image</button>
            </div>
        </modal>
        <modal :name="'view_video_modal'+media.id" height="350px" width="600px">
           <Videos :option="{type: 'video/mp4',src: image_path +'file/' +media.filename}"></Videos>
        </modal>
    </div>
</template>
<style scoped>
    span.error {
        color: #9F3A38;
    }
    .image_price{
        width: 70px;
        border: 0px;
        background: transparent;
    }
    .image_dropdown{
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>
<script>
    import Videos from './Videos';
    export default {
        data() {
            let medias = '';
            return {
                medias: '',
                email:'',
                project_password:'',
                message: '',
                image_path : this.$parent.image_path,
            }
        },
        components: {
            Videos,
        },
        props: {
            media: Object
        },
        methods: {
            shuffle() {
                //.tweets = _.shuffle(this.tweets)
            },
            model_show (id) {
                this.$modal.show('share-image'+id);
            },
            model_hide (id) {
                this.$modal.hide('share-image'+id);
            },
            view_video (id) {
                this.$modal.show('view_video_modal'+id);
            },
            video_hide (id) {
                this.$modal.hide('view_video_modal'+id);
            },
            delete_media (id) {
                //console.log(id);
                let data = {
                    id: id
                };
                axios.post('/api/soft_delete_file', data)
                    .then(( response ) => {
                       // console.log(response);
                        this.$parent.getUserFiles();
                         this.flash('File Deleted!', 'success');
                    })
                    .catch(( response ) => {
                        this.$parent.getUserFiles();
                       // console.log('not deleted');
                        this.flash('File not Deleted!', 'error');
                    });
            },
            make_cover(id){
                let data = {
                    email: this.email,
                    image_id: id
                };
                axios.post('/api/make_cover', data)
                    .then(({ data }) => {
                        this.$modal.hide('share-image'+id);
                        this.flash('Cover Photo Changed !', 'success');
                    })
                    .catch(({ response }) => {
                       this.flash('Cover Photo not Changed!', 'error');
                    });
            },
            image_share(id){
                this.$validator.validateAll();
                if (this.errors.any()) {
                    return;
                }
                if(this.email == ''){
                    return;
                }
                let data = {
                    email: this.email,
                    pass : this.project_password,
                    id: id
                };
                axios
                    .post('/api/send_image_link', data)
                    .then(({ data }) => {
                         this.$modal.hide('share-image'+id);
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
            edit_fun(id,val)
            {
                $('#image_title_e'+id).html(val);
                $('#image_title_e'+id).attr('contenteditable', true);
                $('#image_amount_e'+id).attr('readonly', false);
            },
            amout_edit(id,img_val)
            {
                let old_val = img_val;
                let field_id =  '#image_amount_e'+id;
                if(!$(field_id).prop('readonly')) {
                    let value = $(field_id).val();
                    $(field_id).attr('readonly', true);
                    let data = {
                        id: id,
                        value: value,
                        field: 'amount'
                    };
                    axios
                        .post('/api/edit_image_data', data)
                        .then(({data}) => {
                            this.flash('Amount has updated!', 'success');
                        })
                        .catch(({response}) => {
                            $(field_id).val(old_val);
                        });
                }
            },
            title_edit(id,img_val)
            {
                let old_val = img_val.substr(0, 10)+'...';
                let field_id =  '#image_title_e'+id;
                let value = $(field_id).html();
                let new_val = value.substr(0, 10)+'...';
                $('#image_title_e'+id).html(new_val);
                $(field_id).attr('contenteditable', false);
                let data = {
                    id : id,
                    value : value,
                    field : 'title'
                };
                axios
                    .post('/api/edit_image_data', data)
                    .then(({ data }) => {
                          this.flash('File name has updated!', 'success');
                    })
                    .catch(({ response }) => {
                        $(field_id).val(old_val);
                    });
            }
        },
        created() {
        }
    }
</script>
