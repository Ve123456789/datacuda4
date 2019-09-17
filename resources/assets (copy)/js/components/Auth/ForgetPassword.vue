<template>
    <div>
        <section class="about_content_wrapper">
            <div class="container">

                <img src="../../../img/close.svg" class="m_close_btn" @click="hide_forget_pass">
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

                            <h2>Reset Password to your account here:</h2>
                            <div class="form-group">
                                <input type="email" name = "username" class="form_cus form-control" id="email" placeholder="Email" v-model="username">
                            </div>
                            <div class="form-group">
                                <button class="btn big_btn" @click="forgetpass">Submit</button>
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
      username: ""
    };
  },

  methods: {
    hide_forget_pass() {
      this.$modal.hide("forget_pass");
    },
    forgetpass() {
      let data = {
        username: this.username
      };
      axios
        .post("/api/forgetpassword", data)
        .then(({ data }) => {
          /*auth.login(data.token, data.user);
                        this.$router.push("/dashboard");*/
          /*this.flash('Your Reset Password Link Send Your Email Id', "success");*/
          this.flash(data.message, "success");
        })
        .catch(({ response }) => {
          /*  this.flash(response.data.message, "success");*/
          //alert(response.data.message);
          //console.log(response.data);
        });
    }
  }
};
</script>
