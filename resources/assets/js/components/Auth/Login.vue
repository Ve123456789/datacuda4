<template>
<div>
    <section class="about_content_wrapper">
            <div class="container">
        
        <img src="../../../img/close.svg" class="m_close_btn" @click="hide">
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
            <div class="col-md-12 col-lg-4">
                <div class="form_content_box">
                    <div class="form_logo"><img src="../../../img/datacuda.png"></div>
                    <flash-message class="myCustomClass"></flash-message>

                    <h2>Welcome Back</h2>
                        <div class="form-group">
                            <input type="email" name = "username" class="form_cus form-control" id="email" placeholder="Email" v-model="username" v-validate="'required|email'" >
                             <span class="error" v-if="errors.has('username')">{{errors.first('username')}}</span>
                        </div>
                        <div class="form-group">
                            <input type="password" name = "password" class="form_cus form-control" id="pwd" placeholder="Password" v-model="password" v-validate="'required'" >
                            <span class="error" v-if="errors.has('password')">{{errors.first('password')}}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn big_btn green_btn" @click="login">Login</button>
                        </div>
                        <!-- <div class="or">or continue with</div> -->
                        <div class="social_login">
                            <!-- <div class="mtb_20">
                                <a href="/redirect" class="btn social_btn facebook"><i class="fa fa-facebook-f"></i> LOGIN with facebook</a>

                            </div>
                            <div class="mtb_20">
                                <a href="#" class="btn social_btn linkedin"><i class="fa fa-linkedin"></i> LOGIN with linkedin</a>
                            </div> -->
                            <div class="googleSignup text-center">
                                <a href="#" class="btn google-btn text-white" @click="google_login" ><i class="fa fa-google-plus"></i> Sign In with Google+</a>
                            </div>
                            <div class="mtb_20">
                                <a href="javascript:void(0)" @click="show_forget_pass" >Forgot Password?</a>
                                <!-- <router-link class="forgot_pass"  @click="show_forget_pass" >Forgot Password?</router-link> -->
                            </div>
                        </div>
                        <div class="dont_account">
                            <p> Don’t have an account? <a @click="show_register" href="javascript:void(0)">SiGN UP</a></p>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <modal name="forget_pass" height="auto" width= "70%" :scrollable="true" draggable=".window-header">
            <ForgetPassword/>
        </modal>
         <modal name="user_register" height="auto" width= "70%" :scrollable="true" draggable=".window-header">
            <Register/>
        </modal>
        </div>
</template>

<script>
import ForgetPassword from "../Auth/ForgetPassword";
import Register from "../Auth/Register";
export default {
  components: {
    ForgetPassword
  },
  data() {
    return {
      username: "",
      password: ""
    };
  },
  methods: {

    google_login(){
      console.log("login called");
      this.$gAuth.signIn()
      .then(GoogleUser => {
        var data = GoogleUser.getBasicProfile();
        //console.log(data)
        // GoogleUser.getId() : Get the user's unique ID string.
        // GoogleUser.getBasicProfile() : Get the user's basic profile information.
        // GoogleUser.getAuthResponse() : Get the response object from the user's auth session. access_token and so on
        //this.isSignIn = this.$gAuth.isAuthorized
        //console.log(this.isSignIn);

        axios
        .post("/api/google_login", data)
        .then(({ data }) => {
          //console.log("pravin",data);
          auth.login(data.token, data.user);
          this.$modal.hide("user_login");
          this.$router.push("/dashboard");
          // if (this.$session.has("request_page")) {
          //   if (this.$session.has("request_value")) {
          //     this.$modal.hide("user_login");
          //     this.$router.push(
          //       this.$session.get("request_page") +
          //         this.$session.get("request_value")
          //     );
          //   } else {
          //     this.$modal.hide("user_login");
          //     this.$router.push(this.$session.get("request_page"));
          //   }
          // } else {
          //   this.hide();
          //   this.$router.push("/dashboard");
          // }

        })
        .catch(({ response }) => {
          this.flash(response.data.message, "success");
          //alert(response.data.message);
          console.log("111",response);
        });
        
      })
      .catch(error  => {
        //on fail do something
        console.log("fail",error);
      })
  },
    hide() {
      this.$modal.hide("user_login");
    },
   show_register() {
      this.$modal.show("user_register");
      this.$modal.hide("user_login");
    },
    show_forget_pass() {
      this.$modal.show("forget_pass");
    },
    login() {
       this.$validator.validateAll();
        if(this.errors.any()) {
            return;
        }
      let data = {
        username: this.username,
        password: this.password
      };
      axios
        .post("/api/login", data)
        .then(({ data }) => {
          auth.login(data.token, data.user);
          if (this.$session.has("request_page")) {
            if (this.$session.has("request_value")) {
              this.$modal.hide("user_login");
              this.$router.push(
                this.$session.get("request_page") +
                  this.$session.get("request_value")
              );
            }else {
              this.$modal.hide("user_login");
              this.$router.push(this.$session.get("request_page"));
            }
          }else {
            this.hide();
            this.$router.push("/dashboard");
          }
        })
        .catch(({ response }) => {
          this.flash(response.data.message, "success");
          //alert(response.data.message);
        });
    },
    logout() {
      axios
        .post("/api/logout")
        .then(({ data }) => {
          auth.login(data.token, data.user);
          this.$session.destroy();
          this.$router.push("/login");
        })
        .catch(({ response }) => {
          //alert(response.data.message);
        });
    }
  },
  mounted(){
    if(auth.check()){
      this.$router.push("/dashboard");
    }
  }

};
</script>
