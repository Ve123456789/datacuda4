<template xmlns:v-img="http://www.w3.org/1999/xhtml">
    <div class="col-md-6 detailList">
        	<!-- <flash-message class="myCustomClass"></flash-message> -->
        <div class="thumbnail thumbnailSec">
            <div   v-if="media.ext === 'jpg' || media.ext === 'png' || media.ext === 'gif' || media.ext === 'jpeg'">
                <div class="imgThumb">
                    <img v-bind:src="image_path+'thumb/' + media.filename" v-img:name class="img-rounded" width="100%">
                </div>

                <div class="caption">
                    <p class="proName">
                        <span :id="'image_title_e'+media.id" contenteditable="false" v-on:focusout="title_edit(media.id,media.title)">{{ this.media.title.substring(0,10) + '...' }}</span>
                        <!--<span class="proDate">12/08/2017</span>-->
                    </p>
                    <p class="listBott">
                        <span class="fileSize"> {{ Number((media.size/(1024*1024)).toFixed(1)) }} <span>mb</span></span>
                        <span class="fileRename"> <i class="fa fa-pencil" aria-hidden="true" v-on:click="edit_fun(media.id,media.title)"></i><i class="fa fa-trash-o" aria-hidden="true" v-on:click="delete_media(media.id)"></i></span>
                    </p>
                    <!--<p class="payment"><span class="amt">$ <input type="number" :id="'image_amount_e'+media.id" :value="media.amount" readonly="readonly" v-on:focusout="amout_edit(media.id,media.amount)"></span></p>-->
                </div>
            </div>
            <div  v-else-if="media.ext === 'mp4' ">
                <div class="imgThumb">
                    <img v-bind:src="'/assets/img/video.png'" class="img-rounded" width="100%" height="100%" v-on:click="view_video(media.id)">
                </div>
                <div class="caption">
                    <p class="proName">
                        <span :id="'image_title_e'+media.id" contenteditable="false" v-on:focusout="title_edit(media.id,media.title)">{{ this.media.title.substring(0,10) + '...' }}</span>
                        <!--<span class="proDate">12/08/2017</span>-->
                    </p>
                    <p class="listBott">
                        <span class="fileSize">{{ Number((media.size/(1024*1024)).toFixed(1)) }} <span>mb</span></span>
                        <span class="fileRename"> <i class="fa fa-pencil" aria-hidden="true" v-on:click="edit_fun(media.id,media.title)"></i><i class="fa fa-trash-o" aria-hidden="true" v-on:click="delete_media(media.id)"></i></span>
                    </p>
                    <!--<p class="payment"><span class="amt">$ <input type="number" :id="'image_amount_e'+media.id" :value="media.amount" readonly="readonly" v-on:focusout="amout_edit(media.id,media.amount)"></span></p>-->
                </div>

            </div>
            <div class="onlyText" v-else>
                <a v-bind:href="'storage/user_files/' + media.filename">
                    <img v-bind:src="'/assets/img/pdf_icon.png'" class="img-roundedss" width="100%" height="50%">
                </a>
                <p class="listBott">
                    <span class="fileSize"> {{ Number((media.size/(1024*1024)).toFixed(1)) }} <span>mb</span></span>
                    <span class="fileRename"> <i class="fa fa-pencil" aria-hidden="true" v-on:click="edit_fun(media.id,media.title)"></i><i class="fa fa-trash-o" aria-hidden="true" v-on:click="delete_media(media.id)"></i></span>
                </p>
            </div>

        </div>
        <modal :name="'share-image'+media.id">
            <div class="modal-header">
                <h5 class="modal-title">New message</h5>
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" v-on:click="model_hide(media.id)">Close</button>
                <button type="button" class="btn btn-primary" v-on:click="image_share(media.id)">Share Image</button>
            </div>
        </modal>
        <modal :name="'view_video_modal'+media.id" height="350px" width="600px">
            <Videos :option="{type: 'video/mp4',src: image_path+'file/'+ media.filename}"></Videos>
        </modal>
    </div>
</template>
<style scoped>
    span.error {
        color: #9F3A38;
    }
</style>
<script>
    import Videos from './Videos';
    export default {
        components: {
            Videos,
        },
        data() {
            let medias = '';
            return {
                medias: '',
                email:'',
                project_password:'',
                image_path : this.$parent.image_path
            }
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
                axios
                    .post('/api/soft_delete_file', data)
                    .then(( response ) => {
                        //console.log(response);
                        this.$parent.getUserFiles();
                        this.$parent.getStorageData();
                        this.flash('File Deleted!', 'success');

                    })
                    .catch(( response ) => {
                        this.$parent.getUserFiles();
                        //console.log('not deleted');
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
                       this.flash('Cover Photo Changed!', 'success');

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
                    id: id
                };
                axios.post('/api/send_image_link', data)
                    .then(({ data }) => {
                         this.$modal.hide('share-image'+id);
                    })
                    .catch(({ response }) => {
                        //console.log(response);
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
                let value = $(field_id).val();
                $(field_id).attr('readonly', true);
                let data = {
                  id : id,
                  value : value,
                  field : 'amount'
                };
                axios
                    .post('/api/edit_image_data', data)
                    .then(({ data }) => {
                        this.flash('Amount has updated!', 'success');
                    })
                    .catch(({ response }) => {
                        $(field_id).val(old_val);
                    });
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
