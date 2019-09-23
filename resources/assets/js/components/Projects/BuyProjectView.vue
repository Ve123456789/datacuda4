<template>
    <section class="pricing_plans_wrapper">
        <div v-if = "loading" class="main_model_box">
            <div class="model_box loader"></div>
        </div>
        <div class="container-fluid clearfix">
            <flash-message class="myCustomClass"></flash-message>
            <div class="file-upload customBox">
                <div class="form-group">
                    <div class="form-group clearBox">
                        <div class="row">
                            <div class="col-md-2" v-for="media in medias" :media="media" :key="media.id">
                                <div class="thumbnail thumbnailSec">
                                    <div   v-if="media.ext === 'jpg' || media.ext === 'png' || media.ext === 'gif' ">
                                        <div class="imgThumb">
                                            <img v-bind:src="image_path+'original/'+  media.filename" v-img:name class="img-rounded" width="100%">
                                        </div>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary dropdown-toggle"></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" v-on:click="model_show(media.id)">Share Media</a>
                                            </div>
                                        </div>
                                        <div class="caption">
                                            <p class="proName proNew">
                                                <i class="fa fa-picture-o" aria-hidden="true"></i>
                                                <span class="pronewName">{{ media.title.substring(0,10) + '...' }}</span> <span class="proDate">{{ media.created_at }}</span>
                                                <span class="amt">$ {{ media.amount }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div  v-else-if="media.ext === 'mp4' ">
                                        <div class="imgThumbs">
                                            <img v-bind:src="'/assets/img/video.png'" class="img-roundedss" width="100%" height="100%" v-on:click="view_video(media.id)">
                                        </div>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary dropdown-toggle"></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" v-on:click="model_show(media.id)">Share Media</a>
                                            </div>
                                        </div>
                                        <div class="caption">
                                            <p class="proName proNew">
                                                <i class="fa fa-file-video-o" aria-hidden="true"></i>
                                                <span :id="'image_title_e'+media.id" contenteditable="false" v-on:focusout="title_edit(media.id,media.title)" class="pronewName">{{ this.media.title.substring(0,10) + '...' }}</span> <span class="proDate">{{ media.created_at }}</span>
                                                <span class="amt">$ <input class = "form-input" type="number" :id="'image_amount_e'+media.id" :value="media.amount" readonly="readonly" v-on:focusout="amout_edit(media.id,media.amount)"></span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="onlyText caption" v-else>
                                        <a v-bind:href="image_path+'file/' + media.filename">
                                            <img v-bind:src="'/assets/img/pdf_icon.png'" class="img-roundedss" width="100%" height="50%">
                                        </a>
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
                                            <div class="form-group">
                                                <label lass="col-form-label">Enter password to secure file:</label>
                                                <input type="password" class="form-control" name="project_password" v-model="project_password" v-validate="'required'">
                                                <span class="error" v-if="errors.has('project_password')">{{errors.first('project_password')}}</span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" v-on:click="model_hide(media.id)">Close</button>
                                        <button type="button" class="btn btn-primary" v-on:click="image_share(media.id)">Share Image</button>
                                    </div>
                                </modal>
                                <modal :name="'view_video_modal'+media.id" height="auto" :scrollable="true">

                                    <video-player  class="video-player-box"
                                                   ref="videoPlayer"
                                                   :options="{muted: true,
                                    language: 'en',
                                    playbackRates: [0.7, 1.0, 1.5, 2.0],
                                    sources: [{
                                        type: 'video/mp4',
                                        src: image_path +'file/' +media.filename
                                    }],
                            poster: '/assets/img/video.png',
                            }"
                                                   :playsinline="true"
                                                   customEventName="customstatechangedeventname"
                                                   @play="onPlayerPlay($event)"
                                                   @pause="onPlayerPause($event)"
                                                   @ended="onPlayerEnded($event)"
                                                   @waiting="onPlayerWaiting($event)"
                                                   @playing="onPlayerPlaying($event)"
                                                   @loadeddata="onPlayerLoadeddata($event)"
                                                   @timeupdate="onPlayerTimeupdate($event)"
                                                   @canplay="onPlayerCanplay($event)"
                                                   @canplaythrough="onPlayerCanplaythrough($event)"
                                                   @statechanged="playerStateChanged($event)"
                                                   @ready="playerReadied">
                                    </video-player>
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
                medias: '',
                email:'',
                project_password:'null',
                image_path : '',
                playerOptions: {
                    // videojs options
                    muted: true,
                    language: 'en',
                    playbackRates: [0.7, 1.0, 1.5, 2.0],
                    sources: [{
                        type: "video/mp4",
                        src: "https://cdn.theguardian.tv/webM/2015/07/20/150716YesMen_synd_768k_vp8.webm"
                    }],
                    poster: "/static/images/author.jpg",
                },

            }
        },
        methods: {
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
            image_share(id){
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
                    id: id
                };
                axios
                    .post('/api/send_image_link', data)
                    .then(({ data }) => {
                        this.$modal.hide('share-image'+id);
                    })
                    .catch(({ response }) => {
                        //console.log(response);
                    });
            },
            getProjectData()
            {

                let data  = {
                    pro_id:this.$session.get('BuyProject'),
                    order_by: 'filename'
                };
                axios.post('/api/getbuyprojectdata',data)
                   .then((response)=>{
                    this.medias = response.data.project_medias;
                    this.image_path = response.data.path;
                      // console.log(this.image_path);
                })
                    .catch(({ response }) => {
                       // console.log(response);
                        //this.$router.push('/');
                    });
            },
        },
        created() {
            this.getProjectData();
        },
        updated() {
            // run something after dom has changed by vue

        }

    }
</script>



