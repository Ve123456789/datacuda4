<template>
  <div>
        <section class="about_content_wrapper">
                <div class="container">
            <img src="../../../img/close.svg" class="m_close_btn" @click="hide_register">
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
                        <h2>Register To Datacuda here:</h2>
                        <flash-message class="myCustomClass"></flash-message>

                        <div class="form-group">
                                <input type="text" name = "name" class="form_cus form-control" id="name" placeholder="Name" v-model="name" v-validate="'required'">
                                <span class="error" v-if="errors.has('name')">{{errors.first('name')}}</span>
                        </div>
                            <div class="form-group">
                                <input type="email" name = "email" class="form_cus form-control" id="email" placeholder="Email" v-model="email" v-validate="'required|email'">
                                <span class="error" v-if="errors.has('email')">{{errors.first('email')}}</span>
                            </div>
                            <div class="form-group">
                                <input type="password" name = "password" ref="password" class="form_cus form-control" id="password" placeholder="Password" v-model="password" v-validate="'required'">
                                <div v-if="errors.has('password')">
                                    {{ errors.first('password') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="password" name = "c_password" class="form_cus form-control" id="c_password" placeholder="Confirm Password" v-model="c_password" v-validate="'required|confirmed:password'" data-vv-as="password">
                                <div v-if="errors.has('c_password')">
                                    {{ errors.first('c_password') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn big_btn" @click="register">Register</button>
                            </div>

                            <div class="dont_account">
                                <p> Don’t have an account? <router-link to="/register">SiGN UP</router-link></p>
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
        .then(({ data }) => {
          auth.login(data.token, data.user);
            this.hide_register();
            this.$router.push('/login');
        })
        .catch(({ response }) => {
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
