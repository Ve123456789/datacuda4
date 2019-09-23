<template>
    <div>
       <footer class="main_footer">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-6">
                        <div class="logo_social">
                            <!-- <div class="f_logo"><a href="#"><img src="{{url('assets/img/f_logo.png')}}"></a></div> -->
                            <div class="f_logo"><a href="#"><router-link to="/"><img src="/assets/img/white-logo.png" alt="Logo"></router-link></a></div>
                            <ul class="f_social_nav">
                                <li><a href="https://www.facebook.com/DataCuda/"><i class="fa fa-facebook-f"></i></a></li>
                                <li><a href="https://twitter.com/datacuda"><i class="fa fa-twitter"></i></a></li>
                                <!-- <li><a href="#"><i class="fa fa-linkedin"></i></a></li> -->
                                <li><a href="https://www.instagram.com/datacuda/"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="https://www.youtube.com/channel/UCKQs4pM3zwzBDtUqkG3DQYg?view_as=subscriber"><i class="fa fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="f_content">
                                    <h4>company</h4>
                                    <ul class="f_menu_nav">
                                        <li><router-link to="/about">About</router-link></li>
                                        <li><router-link to="/Pricing">Pricing</router-link></li>
                                        <!-- <li><router-link to="/Press">Press</router-link></li> -->
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="f_content">
                                    <h4>Support</h4>
                                    <ul class="f_menu_nav">
                                        <li><router-link to="/Faq">FAQ</router-link></li>
                                        <li><router-link to="/Contact">Contact us</router-link></li>
                                        <li><router-link to="/Terms-of-Service">Privacy & Terms</router-link></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="f_last_content">
                                    <a href="#" class="btn green_btn">try it free</a>
                                    <div class="copy_right">© 2019  All rights  reserved</div>
                                </div>  
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</template>

<script>
export default {

}
</script>










