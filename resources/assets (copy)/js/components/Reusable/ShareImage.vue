<template>
  <div class="container" >
    <section class="margin_top_for_header"></section>
    <div  v-if="Pass_show === 1">
      <section class="dashboard__filter">
        <div class="container">
          <div class="row clearfix">
            <div class="col-md-6 col-lg-6 offset-6">
              <ul class="btn_group_list_nav">
                <!-- <li><span class="money_text">{{ project_data.project_price }}</span></li> -->
                <li><a href="javascript:void(0)" v-on:click="download_project(share_data.id)" v-if="payed === 1">Download</a></li>
                <li><span class="money_text"><b>${{share_data.buy_amount}} </b></span></li>
                <li><a href="javascript:void(0)" v-on:click="show_payment()" v-if="payed === 0" >Buy now</a></li>
              </ul>
            </div>
          </div>
        </div>
      </section>
      <section class="project_client_datat grey_bg">
        <div class="container">
          <div class="row clearfix">
            <div class="col-12 col-md-3 col-sm-6" >
              <div class="project__data" v-if="image_data.ext === 'jpg' || image_data.ext === 'png' || image_data.ext === 'gif' ">
                <img :src="image_path.image + image_data.filename" class="project_img__vid" v-img:shared>
              </div>
              <div  class="project__data" v-else-if="image_data.ext === 'mp4' ">
                <div class="imgThumbs">
                  <img v-bind:src="'/assets/img/video.png'" class="img-roundedss" width="100%" height="100%">
                  <div class="project_overlay_bg">
                    <div class="center_icon"><img src="/assets/img/play_icon.png" v-on:click="view_video(image_data.id)"></div>
                  </div>
                </div>
                <modal :name="'view_video_modal'+image_data.id" height="auto" :scrollable="true">
                  <Videos :option="{type: 'video/mp4',src: image_path.file + image_data.filename}"></Videos>
                </modal>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div class="row" style="height: 800px" v-else></div>
    <modal name="ask_for_password" height="90%" width= "90%" :scrollable="false" draggable=".window-header">
      <div class="window-header">
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6 form_content_box">
            <div class="form_logo"><img src="../../../img/datacuda.png"></div>
            <flash-message class="myCustomClass"></flash-message>
            <h2>Enter Your Project Password</h2>
            <div class="form-group">
              <input type="text" name="Project Password" class="form_cus form-control" placeholder="Enter your project Password" v-model="project_pass" v-validate="'required'">
              <span class="error" v-if="errors.has('Project Password')">{{errors.first('Project Password')}}</span>
              <span class="error" v-if="Pass_status === 1">Password Wrong</span>
            </div>
            <div class="form-group">
              <button class="btn big_btn" v-on:click="CheckPass()">Submit</button>
            </div>
          </div>
          <div class="col-md-3"></div>
        </div>
      </div>
    </modal>
    <modal name="payment_modal" height="80%" width= "60%" :scrollable="false" draggable=".window-header">
      <div class="payments_wrapper white_bg">
        <div class="payments_main_box">
          <div class="row">
            <div class="payment_left_content col-md-7">
              <div class="payment_content">
                <h3 class="pay_heading">You order</h3>
                <flash-message class="myCustomClass"></flash-message>
                <table class="payment_table table">
                  <tbody>
                  <tr>
                    <td>{{ filename.substring(0,20) + '...' }}</td>
                    <td class="text-right">$ {{ image_data.amount }}</td>
                  </tr>
                  </tbody>
                </table>
                <hr>
                <table class="payment_table table">
                  <tbody>
                 <!-- <tr>
                    <td>Full set of photos</td>
                    <td class="text-right">{{ image_data.amount }}</td>
                  </tr>
                  <tr class="fz_small">
                    <td>Processing fee</td>
                    <td class="text-right">$ 30</td>
                  </tr>-->
                  <tr class="fz_big">
                    <td>TOTAL</td>
                    <td class="text-right">$ {{ share_data.buy_amount}} </td>
                  </tr>
                  </tbody>
                  <a href="#" class="btn payment_btn" @click="hide_payment">Cancel payment</a>
                </table>

              </div>
            </div>
            <div class="payment_right_content white_bg col-md-5">
              <form class="payment_form_data">
                <h2> Payment</h2>
                <div class="fail_payment">
                </div>
                <div class="payment_method">
                  <div class="row">
                    <div class="col-sm-12 col-12">
                      <input type="text" placeholder="Please enter your name." class="form-control" v-model="buyerName">
                    </div>
                    <div class="col-sm-12 col-12">
                      <input type="text" placeholder="Please enter your Email."  class="form-control" v-model="buyerEmail">
                    </div>
                  </div>
                  <div class="card_number form-group">
                    <label>Credit card number</label>
                    <div class="row">
                      <div class="col-sm-3 col-3">
                        <input type="text" placeholder="1223" maxlength="4" class="form-control" v-model="card_1">
                      </div>
                      <div class="col-sm-3 col-3">
                        <input type="text" placeholder="1223" maxlength="4" class="form-control" v-model="card_2">
                      </div>
                      <div class="col-sm-3 col-3">
                        <input type="text" placeholder="1223" maxlength="4" class="form-control" v-model="card_3">
                      </div>
                      <div class="col-sm-3 col-3">
                        <input type="text" placeholder="1223" maxlength="4" class="form-control" v-model="card_4">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6 col-6">
                      <div class="expir_Cvv form-group">
                        <label>Expiration date</label>
                        <div class="row">
                          <div class="col-sm-6 col-3">
                            <input type="text" placeholder="12" class="form-control" v-model="month"></div>
                          <div class="col-sm-6 col-3">
                            <input type="text" placeholder="18" class="form-control" v-model="year"></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-6">
                      <div class="form-group">
                        <label>CVV</label>
                        <input type="password" placeholder="● ● ● " maxlength="3" class="form-control" v-model="cvc">
                      </div>
                    </div>
                  </div>
                  <a href="javascript:void(0)" v-on:click="pay()" class="btn green_btn">PAY NOW</a>
                  <!--<a href="javascript:void(0)" v-on:click="show_payment_success">Show</a>-->
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </modal>
    <modal name="payment_modal_success" height="100%" width= "90%" :scrollable="false" draggable=".window-header">
      <PaymentSuccess></PaymentSuccess>
    </modal>
    <modal name="payment_modal_failed" height="100%" width= "90%" :scrollable="false" draggable=".window-header">
      <PaymentFailed></PaymentFailed>
    </modal>
  </div>
</template>
<style scoped>
  span.error {
    color: #9F3A38;
  }
</style>
<script>
    import PaymentSuccess from "../Payments/PaymentSuccess";
    import PaymentFailed from "../Payments/PaymentFailed";
    import Videos from './Videos';
    export default {
        components: {
            PaymentSuccess,
            PaymentFailed,
            Videos,
        },
        data() {
            return {
                Pass_show: 0,
                button_text: "Buy Now",
                total_amount: "",
                card_1: "",
                card_2: "",
                card_3: "",
                card_4: "",
                month: "",
                year: "",
                cvc: "",
                total_ack: "",
                image_data: "",
                totalFinalAmountSend: "",
                payed: 0,
                order_by: "id",
                usagedata: "",
                buyerName:"",
                buyerEmail:"",
                password: "",
                image_path:'',
                Pass_status : 0,
                share_data :'',
                message: '',
                project_pass :'',
                filename : ''
            };
        },
        methods: {
            view_video(id) {
                this.$modal.show("view_video_modal" + id);
            },
            video_hide(id) {
                this.$modal.hide("view_video_modal" + id);
            },
            show_payment() {
                this.$modal.show("payment_modal");
            },
            hide_payment() {
                this.$modal.hide("payment_modal");
            },
            show_payment_success() {
                this.$modal.show("payment_modal_success");
            },
            hide_payment_success() {
                this.$modal.hide("payment_modal_success");
            },
            show_payment_failed() {
                this.$modal.show("payment_modal_failed");
            },
            ask_for_password() {
                this.$modal.show("ask_for_password");
            },
            ask_for_password_hide() {
                this.$modal.hide("ask_for_password");
            },
            pay() {
                let data = {
                    amount: this.share_data.buy_amount,
                    share_data: this.share_data,
                    card_no: this.card_1 + this.card_2 + this.card_3 + this.card_4,
                    month: this.month,
                    year: this.year,
                    cvc: this.cvc,
                    buyerName:this.buyerName,
                    buyerEmail:this.buyerEmail,
                };
                axios
                    .post("/api/share_image_buy", data)
                    .then(({ response }) => {
                        this.get_data();
                        this.hide_payment();
                        this.show_payment_success();
                        this.payed = 1;
                    })
                    .catch(({ response }) => {
                        this.hide_payment();
                        this.show_payment_failed();
                        this.payed = 0;
                    });
            },
            get_data() {
                let data = {
                    img_id: this.$route.params.id
                };
                axios
                    .post("/api/get_share_image_data", data)
                    .then(response => {
                        this.image_data = response.data.data.media;
                        this.filename = this.image_data.filename
                        this.share_data = response.data.data.share;
                        this.image_path = response.data.path;
                        this.payed        = response.data.buystatus;
                        // this.checkBuyStatus(response.data.data.id);
                    })
                    .catch(({ response }) => {
                        this.$router.push("/");
                    });
            },
            CheckPass()
            {
                this.$validator.validate('Project Password')
                    .then(result => {
                        if (!result) {
                            return false
                        }
                        if(result)
                        {
                            let data = {
                                rep_id   : this.$route.params.id,
                                rep_pass : this.project_pass
                            };
                            axios
                                .post("/api/project_pass_check", data)
                                .then(({response}) => {
                                    //console.log(response);
                                    this.Pass_status = 0;
                                    this.Pass_show =  1;
                                    this.get_data();
                                    this.ask_for_password_hide();
                                })
                                .catch(({ response }) => {
                                    //console.log(response);
                                    //this.$router.push("/");
                                    this.Pass_status = 1;
                                });
                        }
                    });
            },
            checkBuyStatus(project_id) {
                axios
                    .get("api/checkProjectBuy/" + project_id)
                    .then(response => {
                        this.payed = response.data.data;
                    })
                    .catch(response => {
                       // console.log(response);
                    });
            },
            download_project(id) {
                let data = {
                    id: id,
                };
                axios
                    .post("/api/download_single_image", data)
                    .then(response => {
                        var url = response.data.data.url;
                        window.location.href = url;
                    })
                    .catch(response => {
                        //console.log(response);
                    });
            }
        },
        mounted() {
            this.get_data();

        },
        updated()
        {
            this.ask_for_password();
        }
    };
</script>
