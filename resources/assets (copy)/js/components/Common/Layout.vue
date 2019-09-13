<template>
    <div>
        <!-- Home Page -->
        <span v-if="!authenticated && !user">
            <HomeHeader></HomeHeader>
        </span>
        <span v-else>
            <Header></Header>
        </span>
        <div style="margin-top: 2rem">
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
        </div>
        <Footer></Footer>

        
    <!---->
	
    <!-- Login -->
    <div class="main_model_box log_in">
        <div class="model_box">
		
            <!-- <img src="{{url('assets/img/close.svg')}}" class="m_close_btn"> -->
            <img src="/assets/img/close.svg" class="m_close_btn">
            <div class="row">
                <div class="model_mob col-md-8">
                    <div class="model_cloud_business_content">
                        <h3>DataCuda Business Plan</h3>
                        <a href="#" class="btn blue_big_btn">Learn More</a>
                        <!-- <img src="{{url('assets/img/login_icon.png')}}" alt="" class="datacuda_img"> -->
                        <img src="/assets/img/login_icon.png" alt="" class="datacuda_img">
                        <div class="model_box_logos">
                            <ul class="logos_nav">
                                <li><img src="/assets/img/logo_1.png"></li>
                                <li><img src="/assets/img/logo_2.png"></li>
                                <li><img src="/assets/img/logo_3.png"></li>
                                <li><img src="/assets/img/logo_4.png"></li>
                                <li><img src="/assets/img/logo_5.png"></li>
                                <li><img src="/assets/img/logo_6.png"></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Signup -->
    <div class="main_model_box sign_up">
        <div class="model_box">
            <!-- <img src="{{url('assets/img/close.svg')}}" class="m_close_btn"> -->
            <img src="/assets/img/close.svg" class="m_close_btn">
            <div class="row">
                <div class="model_mob col-md-8">
                    <div class="model_cloud_business_content">
                        <h3>DataCuda Business Plan</h3>
                        <a href="#" class="btn blue_big_btn">Learn More</a>
                        <!-- <img src="{{url('assets/img/login_icon.png')}}" alt="" class="datacuda_img"> -->
                        <img src="/assets/img/login_icon.png" alt="" class="datacuda_img">
                        <div class="model_box_logos">
                            <ul class="logos_nav">
                                <li><img src="/assets/img/logo_1.png"></li>
                                <li><img src="/assets/img/logo_2.png"></li>
                                <li><img src="/assets/img/logo_3.png"></li>
                                <li><img src="/assets/img/logo_4.png"></li>
                                <li><img src="/assets/img/logo_5.png"></li>
                                <li><img src="/assets/img/logo_6.png"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
    <modal name="msg_popup" height="25%" width= "25%" :scrollable="false" draggable=".window-header">
        <div class="window-header">
            <div class="text-center">
                {{msg}}
            </div>
        </div>
    </modal>
    <!---->
    </div>
</template>
<script>
import HomeHeader from "./HomeHeader";
require('vue-flash-message/dist/vue-flash-message.min.css');

import Header from './Header.vue'
import Footer from './Footer.vue'
import EventBus from '../../app.js';

export default {
    components: {
        HomeHeader,
        Header,
        Footer
    },
    data() {
        return {
            authenticated: auth.check(),
            user: auth.user,
            msg : ''
        };
    },

    mounted() {
        Event.$on('userLoggedIn', () => {
            this.authenticated = true;
            this.user = auth.user;
        });
        Event.$on('userLoggedOut', () => {
            this.authenticated = false;
            this.user = null;
        });

    },

     methods: {
        logout() {
            this.authenticated = false;
            this.user = null;
            axios.post('/api/logout')
                .then(({data}) => {
                auth.login(data.token, data.user);
                this.$router.push('/');
            })
            .catch(({response}) => {
                alert(response.data.message);
            });

        },
         show_popup()
         {
             this.$modal.show('msg_popup');
         },
         hide_popup()
         {
             this.$modal.hide('msg_popup');
         },
         show_msg_popup(exp)
         {
             if(exp === 'mail') { this.msg = 'Mail Send Successfuly'; }
             if(exp === 'share') { this.msg = 'Share Project Mail Send Successfuly'; }
             this.show_popup();
             setTimeout(()=>{
                 this.hide_popup()
             },4000);
         },
		created() {
			let jquery= document.createElement('script');    jquery.setAttribute('src',"assets/external_js/jquery-3.3.1.min.js");
			document.head.appendChild(jquery);
			let datepicker= document.createElement('script');    datepicker.setAttribute('src',"assets/external_js/datepicker.min.js");
			document.head.appendChild(datepicker);
			let datepicker1= document.createElement('script');    datepicker1.setAttribute('src',"assets/external_js/datepicker.en.js");
			document.head.appendChild(datepicker1);
			let bootstrap= document.createElement('script');    bootstrap.setAttribute('src',"assets/external_js/bootstrap.min.js");
			document.head.appendChild(bootstrap);
			let carousel= document.createElement('script');    carousel.setAttribute('src',"assets/external_js/owl.carousel.min.js");
			document.head.appendChild(carousel);
			let cory= document.createElement('script');    cory.setAttribute('src',"assets/external_js/cory.js");
			document.head.appendChild(cory);

        }
    }
}
</script>