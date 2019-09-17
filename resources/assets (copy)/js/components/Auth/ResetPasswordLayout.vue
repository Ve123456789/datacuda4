<template>
    <div>
        <!-- Home Page -->
        <Header></Header>
        <div style="margin-top: 2rem">
            <div>
                <section class="about_content_wrapper">
                    <div class="container">

                        <img src="../../../img/close.svg" class="m_close_btn">
                        <div class="row">
                            <div class="model_mob col-md-8">
                                <div class="model_cloud_business_content">
                                    <h3>DataCuda Business Plan</h3>
                                    <router-link to="/Pricing" class="btn blue_big_btn">Learn More</router-link>
                                    <img src="../../../img/login_icon.png" alt="" class="datacuda_img">
                                    <div class="model_box_logos">
                                        <ul class="logos_nav">
                                            <li><img src="../../../img/logo_1.png"></li>
                                            <li><img src="../../../img/logo_2.png"></li>
                                            <li><img src="../../../img/logo_3.png"></li>
                                            <li><img src="../../../img/logo_4.png"></li>
                                            <li><img src="../../../img/logo_5.png"></li>
                                            <li><img src="../../../img/logo_6.png"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_content_box">
                                    <div class="form_logo"><img src="../../../img/datacuda.png"></div>
                                    <flash-message class="myCustomClass"></flash-message>

                                    <h2>Create New Password to your account here:</h2>
                                    <div class="form-group">
                                        <input type="password" name = "password" class="form_cus form-control" id="password" placeholder="New Password" v-model="password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name = "c_password" class="form_cus form-control" id="c_password" placeholder="Confirm Password" v-model="c_password">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn big_btn" @click="ResetPass">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>


        <!-- Payment On Delivery  -->


        <!-- Select the best plan for your needs -->

        <!-- Footer -->
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
                                    <!-- <li><img src="{{url('assets/img/logo_1.png')}}"></li>
                                    <li><img src="{{url('assets/img/logo_2.png')}}"></li>
                                    <li><img src="{{url('assets/img/logo_3.png')}}"></li>
                                    <li><img src="{{url('assets/img/logo_4.png')}}"></li>
                                    <li><img src="{{url('assets/img/logo_5.png')}}"></li>
                                    <li><img src="{{url('assets/img/logo_6.png')}}"></li> -->
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


        <!---->

    </div>
</template>
<script>
    require('vue-flash-message/dist/vue-flash-message.min.css');

    import Header from '../Common/Header.vue'
    import Footer from '../Common/Footer.vue'

    export default {
        components: {
            Header,
            Footer
        },
        methods: {
            ResetPass() {
                let data = {
                    UserID  : window.location.pathname,
                    password: this.password,
                    c_password: this.c_password
                };

                axios
                    .post('/api/resetPassword', data)
                    .then(({ data }) => {
                        this.flash('Your Password Reset Successfully', 'success');
                        window.location.href = '../login';
                    })
                    .catch(({ response }) => {
                        this.flash(response.data.message, 'error');
                        });
            },
        },
        mounted() {

        },

    }
</script>