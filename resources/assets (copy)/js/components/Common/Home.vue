<template>
    <div>
        <main class="main_tag">

            
            <div class="main_banner" v-if="homebannersection.homebanner_image" v-bind:style="{background:'url(/images/'+homebannersection.homebanner_image+')','background-repeat': 'no-repeat','background-position': 'top', 'background-size': 'cover'}" >
                <div class="banner_content">
                    <h2 v-html="homebannersection.homebanner_title" ></h2>
                    <a href="#" class="btn banner_btn" @click="show_register">TRY IT FREE</a>
                </div>
            </div>
        </main>
    <section class="simplicity">
            <div class="container">
                <div class="center_title_heading">
                    <h1>{{ homesecondsection.homesecond_topheading1 }} </h1>
                    <p>{{ homesecondsection.homesecond_topheading2 }} </p>
                </div>
                <div class="boxes_main_wraper">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-12">
                            <div class="iteam_box_wraper">
                                <!-- <img src="{{url('assets/img/iteam_icon_1.png')}}" class="iteam_icon"> -->
                                <img v-if="homesecondsection.homesecond_image1" :src="'/images/'+homesecondsection.homesecond_image1" class="iteam_icon">
                                <div class="iteam_content">
                                    <h4>{{ homesecondsection.homesecond_heading1 }}</h4>
                                    <p>{{ homesecondsection.homesecond_content1 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-12">
                            <div class="iteam_box_wraper">
                                <!-- <img src="{{url('assets/img/iteam_icon_2.png')}}" class="iteam_icon"> -->
                                <img v-if="homesecondsection.homesecond_image1" :src="'/images/'+homesecondsection.homesecond_image2" class="iteam_icon">
                                <div class="iteam_content">
                                    <h4>{{ homesecondsection.homesecond_heading2 }}</h4>
                                    <p>{{ homesecondsection.homesecond_content2 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-12">
                            <div class="iteam_box_wraper">
                                <!-- <img src="{{url('assets/img/iteam_icon_3.png')}}" class="iteam_icon"> -->
                                
                               <img v-if="homesecondsection.homesecond_image1" :src="'/images/'+homesecondsection.homesecond_image3" class="iteam_icon">
                                <!-- <img src="{{baseUrl}}/assets/img/iteam_icon_3.png" class="iteam_icon"> -->
                                <div class="iteam_content">
                                    <h4> {{ homesecondsection.homesecond_heading3 }}</h4>
                                    <p>{{ homesecondsection.homesecond_content3 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="payment_delivery">
            <div class="container-fluid">
                <div class="row">
                    <div class="payment_d_img col-md-6">
                       <!--  <img src="{{url('assets/img/payment_delivery.jpg')}}" class="img-responsive"> -->
                        <img v-if="homethirdsection.homethird_image" :src="'/images/'+homethirdsection.homethird_image" class="img-responsive">
                        
                    </div>
                    <div class="col-md-6">
                        <div class="payment_delivery_content">
                            <h2 class="title_heading">{{ homethirdsection.homethird_heading }}</h2>
                            <p>{{ homethirdsection.homethird_content }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Top Features -->

        <!-- Top Features -->
        <section class="top_features">
            <div class="container">
                <h2 class="title_heading">Top Features</h2>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="testimonials"  >
            <div class="container clearfix">
                <div class="testimonial_wrapper">
                    <h2>What our customers are saying </h2>
                    <div id="testimonial_slider" class="owl-carousel">


                        <div  v-for="homereview in homereviews" v-bind:key="homereview.homereviews_id" class="testimonial_content"  >
                            <div class="row">
                                <div class="col-md-2 col-sm-3 col-12">
                                    <div class="client_img">
                                       
                                        <img :src="'/images/'+homereview.homereviews_image" >
                                    </div>
                                    
                                </div>
                                <div class="col-md-10 col-sm-9 col-12">
                                    <p>{{ homereview.homereviews_review }}</p>
                                    <div class="client_name">{{ homereview.homereviews_user }}</div>
                                </div>
                            </div>
                        </div>


                        <!-- <div class="testimonial_content">
                            <div class="row">
                                <div class="col-md-2 col-sm-3 col-12">
                                    <div class="client_img">
                                        <img src="/assets/img/client_1.png">
                                    </div>
                                    
                                </div>
                                <div class="col-md-10 col-sm-9 col-12">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi, vel, ullam! Quam natus nostrum assumenda quia nam harum labore, voluptatum beatae fugit, maxime rem deleniti, et molestias optio! Iste, aspernatur.</p>
                                    <div class="client_name">TAYLOR SWIFT</div>
                                </div>
                            </div>
                        </div>

                        <div class="testimonial_content">
                            <div class="row">
                                <div class="col-md-2 col-sm-3 col-12">
                                    <div class="client_img">
                                        <img src="/assets/img/client_1.png">
                                    </div>
                                    
                                </div>
                                <div class="col-md-10 col-sm-9 col-12">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi, vel, ullam! Quam natus nostrum assumenda quia nam harum labore, voluptatum beatae fugit, maxime rem deleniti, et molestias optio! Iste, aspernatur.</p>
                                    <div class="client_name">TAYLOR SWIFT</div>
                                </div>
                            </div>
                        </div> -->


                    </div>
                </div>
            </div>
        </section>
        <section class="plan_needs">
            <div class="container clearfix">
                <h2 class="title_heading">Select the best plan for your needs</h2>
                <div class="row clearfix">


                    <div v-for="homeplan in homeplans" v-bind:key="homeplan.homeplans_id" class="col-lg-3 col-md-3 col-sm-6 col-12" >
                        <div class="plan_price_main_box">
                            <h3>{{ homeplan.homeplans_heading }}</h3>
                            
                            <img v-if="homeplan.homeplans_image"  :src="'/images/'+homeplan.homeplans_image" class="plan_icon">

                            <div v-if="homeplan.homeplans_duration != 'Call' " class="plan_time">
                                <h1>{{ homeplan.homeplans_price }}</h1><span>/{{ homeplan.homeplans_duration }}</span>
                            </div>

                            <div v-if="homeplan.homeplans_duration == 'Call' " class="no_t plan_time">
                                <h1>Call</h1><span></span>
                            </div>

                            <p>{{ homeplan.homeplans_content }}</p>
                            <a href="#" class="btn green_btn" @click="show_register">try it now</a>
                            <div v-if="homeplan.homeplans_heading == 'FREE'" class="dis_n small_text">for 14 days</div>
                            <div v-if="homeplan.homeplans_heading != 'FREE'" class="small_text">for 14 days</div>
                        </div>
                    </div>


                   <!-- <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                        <div class="plan_price_main_box">
                            <h3>Pro</h3>
                            
                            <img src="/assets/img/plan_icon_2.png" class="plan_icon">
                            <div class="plan_time">
                                <h1>14</h1><span>/month</span>
                            </div>
                            <p>Lorem ipsum dolor sit amet. sed do eiusmod tempor incididunt ut. Labore et dolore magna aliqua.</p>
                            <a href="#" class="btn green_btn" @click="show_register">try it now</a>
                            
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                        <div class="plan_price_main_box">
                            <h3>Business</h3>
                           
                            <img src="/assets/img/plan_icon_3.png" class="plan_icon">
                            <div class="plan_time">
                                <h1>49</h1><span>/month</span>
                            </div>
                            <p>Lorem ipsum dolor sit amet. sed do eiusmod tempor incididunt ut. Labore et dolore magna aliqua.</p>
                            <a href="#" class="btn green_btn" @click="show_register">try it now</a>
                            <div class="small_text">for 14 days</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                        <div class="plan_price_main_box">
                            <h3> Enterprise</h3>
                            
                            <img src="/assets/img/plan_icon_4.png" class="plan_icon">
                            <div class="no_t plan_time">
                                <h1>Call</h1><span></span>
                            </div>
                            <p>Lorem ipsum dolor sit amet. sed do eiusmod tempor incididunt ut. Labore et dolore magna aliqua.</p>
                            <a href="#" class="btn green_btn" @click="show_register">try it now</a>
                            <div class="small_text">for 14 days</div>
                        </div>
                    </div>-->


                </div>
            </div>
        </section>

</div>
</template>

<script>
export default {
    data(){
      return { 
        homebannersection:{},
        homesecondsection:{},
        homethirdsection:{},
        homereviews:[],
        homeplans:[]
      }
    },

    created(){
        this.bannerSection();
        this.secondSection();
        this.thirdSection();
        this.review();
        this.plan();
    },
    mounted() {
      setTimeout(function(){    
        // This works now
        $("#testimonial_slider").owlCarousel({
            loop: true,
            margin: 0,
            items: 1,
            nav: true,
            autoplay: true,
            mouseDrag: true,
            dots: false,
            navText: ["<img src='assets/img/Arrow_left.png'>","<img src='assets/img/Arrow_right.png'>"]
        });
     },800);
        // let carousel_loading = document.createElement("script");
        // carousel_loading.setAttribute("src", "assets/external_js/owl.carousel.min.js");
        // document.head.appendChild(carousel_loading);
        // let cory_js = document.createElement("script");
        // cory_js.setAttribute("src", "assets/external_js/cory.js");
        // document.head.appendChild(cory_js);
    },

    methods: {

        show_register() {
            this.$modal.show("user_register");
        },

        bannerSection(){
            console.log("pravin kumar 3");
            axios
            .get('/api/homebannersection')
            .then(result =>{
                this.homebannersection = result.data.response;
                console.log(this.homebannersection);
            })
        },
        secondSection(){
            console.log("pravin kumar 3");
            axios
            .get('/api/homesecondsection')
            .then(result =>{
                this.homesecondsection = result.data.response;
                
            })
        },

        thirdSection(){
            axios
            .get('/api/homethirdsection')
            .then(result=>{
                this.homethirdsection = result.data.response;
            });
            
        },

        review(){
            axios
            .get('/api/homereview')
            .then(result=>{ 
                this.homereviews = result.data.response;
                 
            });
        },
        plan(){
            axios
            .get('/api/homeplan')
            .then(result=>{ 
                this.homeplans = result.data.response;
                 
            });
        }
        
    }
};
</script>