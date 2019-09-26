<template>
  <div>
        <section class="about_content_wrapper">
                <div class="container">
            <img src="../../../img/close.svg" class="m_close_btn" @click="hide_register">
            <div class="row">
                <div class="model_mob col-md-8">
                    <div class="model_cloud_business_content">
                        <h3>DataCuda Business Plan</h3>
                        <router-link to="/Pricing" class="btn blue_big_btn green_btn">Learn More</router-link>
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
                        <h2>Create an Account</h2>
                        <flash-message class="myCustomClass"></flash-message>

                        <div class="form-group">
                                <input type="text" name = "name" class="form_cus form-control" id="name" placeholder="Name" v-model="name" v-validate="'required'">
                                <span class="error" v-if="errors.has('name')">{{errors.first('name')}}</span>
                        </div>
                            <div class="form-group">
                                <input type="email" name = "email" class="form_cus form-control" id="email" placeholder="Email" v-model="email" v-validate="'required|email'" autocomplete="off" >
                                <span class="error" v-if="errors.has('email')">{{errors.first('email')}}</span>
                            </div>
                            <div class="form-group">
                                <input type="password" name = "password" ref="password" class="form_cus form-control" id="password" placeholder="Password" v-model="password" v-validate="'required|min:8'">
                                <div class="error" v-if="errors.has('password')" autocomplete="off" >
                                    {{ errors.first('password') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <input  type="password" name = "c_password" class="form_cus form-control" id="c_password" placeholder="Confirm Password" v-model="c_password" v-validate="'required|confirmed:password'" data-vv-as="password" autocomplete="off" >
                                <div class="error"  v-if="errors.has('c_password')">
                                    {{ errors.first('c_password') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn big_btn green_btn" @click="register">Sign UP</button>
                            </div>

                            <div class="dont_account">
                                <p> Already have an account <router-link to="/login">LOGIN HERE</router-link></p>
                            </div>

                            <div class="googleSignup text-center">
                                <a href="#" class="btn google-btn text-white" @click="google_login" ><i class="fa fa-google-plus"></i> Sign Up With Google</a>
                            </div>
                           
                     </div>
                </div>
              </div>
            </div>
            </section>
            </div>

</template>
<script>
export default {
  data() {
    return {
        name: '',
        email: '',
        password: '',
        c_password: '',
        message: '',
	  filters: null,
    };
  },

  methods: {
      
    google_login(){
      console.log("login called");
      this.$gAuth.signIn()
      .then(GoogleUser => {
        var data1 = GoogleUser.getBasicProfile();
        axios
        .post("/api/google_login", data1)
        .then(({ data }) => {
          //console.log("pravin",data);
          auth.login(data.token, data.user);
          if (this.$session.has("request_page")) {
            if (this.$session.has("request_value")) {
              this.$modal.hide("user_register");
              this.$router.push(
                this.$session.get("request_page") +
                this.$session.get("request_value")
              );
            } else {
              this.$modal.hide("user_register");
              this.$router.push(this.$session.get("request_page"));
            }
          } else {
            this.hide();
            this.$modal.hide("user_register");
            this.$router.push("/dashboard");
          }

        })
        .catch(({ response }) => {
          //console.log(response);
          this.flash(response.data.message, "success");
          //alert(response.data.message);
          //console.log("111",response);
        });
        
      })
      .catch(error  => {
        //on fail do something
        //console.log("fail",error);
      })
    },

    hide_register () {
        this.$modal.hide('user_register');
    },
    register() {
        this.$validator.validateAll();
        if (this.errors.any()) {
            return;
        }
      let data = {
        name: this.name,
        email: this.email,
        password: this.password,
		c_password: this.c_password,

      };

      axios
        .post('/api/register', data)
        .then(( data ) => {
            //console.log(data.data); 
            let datas = data.data;
            if(datas.error && datas.error.email[0]){
              this.flash(datas.error.email[0], "error");
            }else{
              auth.login(datas.token, datas.user);
              this.$modal.hide("user_register");
              this.$router.push("/dashboard");
            }
            //this.$modal.hide("user_register");
            //this.$router.push("/dashboard");
            // auth.login(data.token, data.user);
            // this.hide_register();
            // this.$router.push('/login');
        })
        .catch(({ response }) => {
         // console.log("register error response",response);
			      this.flash(response.data.message, 'danger');
        });
    },
  },
  mounted(){
      setTimeout(()=> this.filters = [
      { text: 'Monthly', value: 'plan_DbUcWAtp0sURnK' },
      { text: 'Yearly', value: 'yearly' }
    ], 30)
  },
};
</script>
