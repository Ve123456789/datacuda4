<template>

  <div class="container">

    <section class="margin_top_for_header"></section>
    
    <div v-if="Pass_show === 1">
      <section class="dashboard__filter">
        <div class="container">
          <div class="row clearfix">
            <div class="col-md-6 col-lg-6 offset-6">
              <ul class="btn_group_list_nav">
                <!-- <li><span class="money_text">{{ project_data.project_price }}</span></li> -->
                <li><a href="javascript:void(0)" v-on:click="download_project(project_data.id)"
                    v-if="payed === 1">Download</a></li>
                <li><span class="money_text"><b>$
                      <!--{{ totalAmount(project_data.medias) }}-->{{project_data.share_data.buy_amount}} </b></span>
                </li>
                <li><a href="javascript:void(0)" v-on:click="show_payment()" v-if="payed === 0">Buy now</a></li>
              </ul>
            </div>
          </div>
        </div>
      </section>
      <section class="project_client_datat grey_bg">
        <div class="container">
          
          

           
          

            <div class="row clearfix" v-if="share_data.watermark_preview != '1'" >
              
              <!-- <div class="col-12 col-md-3 col-sm-6" v-if="share_data.include_condition == '1' && release_logo ">
    
              <div class="project__data" v-if="release_logo_ext === 'jpg' || release_logo_ext === 'png' || release_logo_ext === 'gif' ">

                <img :src="release_logo" class="project_img__vid" v-img:shared>

              </div>
              <div class="project__data" v-else >
              
                <div class="imgThumbs">
                  <img v-bind:src="'/assets/img/video.png'" class="img-roundedss" width="100%" height="100%">
                  <div class="project_overlay_bg">
                    <div class="center_icon"><img src="/assets/img/play_icon.png" v-on:click="view_video1()">
                    </div>
                  </div>
                </div>
                <modal name="view_video_modalr1" width="600px" >
                  <Videos :option="{type: 'video/mp4',src: release_logo}"></Videos>
                </modal>
              </div>
              </div> -->

              <!-- <div class="col-12 col-md-3 col-sm-6" v-if="share_data.include_condition == '1' && release_video">
    
              <div class="project__data" v-if="release_video_ext === 'jpg' || release_video_ext === 'png' || release_video_ext === 'gif' ">

                <img :src="release_video" class="project_img__vid" v-img:shared>

              </div>
              <div class="project__data" v-else >
              
                <div class="imgThumbs">
                  <img v-bind:src="'/assets/img/video.png'" class="img-roundedss" width="100%" height="100%">
                  <div class="project_overlay_bg">
                    <div class="center_icon"><img src="/assets/img/play_icon.png" v-on:click="view_video2()">
                    </div>
                  </div>
                </div>
                <modal name="view_video_modalr2" width="600px" >
                  <Videos :option="{type: 'video/mp4',src: release_video}"></Videos>
                </modal>
              </div>
              </div> -->

            <div class="col-12 col-md-3 col-sm-6" v-for="img_data in project_data.medias" v-bind:key="img_data.id">
              
              
              <div class="project__data" v-if="img_data.ext === 'jpg' || img_data.ext === 'png' || img_data.ext === 'gif' ">

                <img v-if="img_data.img_360 == '0'" :src="project_path.image + img_data.filename" class="project_img__vid" v-img:shared>

                <Pano  v-if="img_data.img_360 == '1'"  :source="project_path.image + img_data.filename" ></Pano>
               

              </div>
              <div class="project__data" v-else-if="img_data.ext === 'mp4' ">
              
                <div class="imgThumbs">
                  <img v-bind:src="'/assets/img/video.png'" class="img-roundedss" width="100%" height="100%">
                  <div class="project_overlay_bg">
                    <div class="center_icon"><img src="/assets/img/play_icon.png" v-on:click="view_video(img_data.id)">
                    </div>
                  </div>
                </div>
                <modal :name="'view_video_modal'+img_data.id" height="350px" width="600px" >
                  <Videos :option="{type: 'video/mp4',src: project_path.file+img_data.filename}"></Videos>
                </modal>


              </div>
            </div>


          </div>

          <div class="row clearfix" v-else >
            <div class="col-12 col-md-3 col-sm-6" v-for="img_data in project_data.medias" v-bind:key="img_data.id">
              
              
              <div class="project__data" v-if="img_data.ext === 'jpg' || img_data.ext === 'png' || img_data.ext === 'gif' ">

                <img v-if="img_data.img_360 == '0'" :src="project_path.image + img_data.filename" class="project_img__vid" >

                <Pano  v-if="img_data.img_360 == '1'"  :source="project_path.image + img_data.filename" ></Pano>
               

              </div>
              <div class="project__data" v-else-if="img_data.ext === 'mp4' ">
              
                <div class="imgThumbs">
                  <img v-bind:src="'/assets/img/video.png'" class="img-roundedss" width="100%" height="100%">
                  <div class="project_overlay_bg">
                    <div class="center_icon"><img src="/assets/img/play_icon.png" v-on:click="view_video(img_data.id)">
                    </div>
                  </div>
                </div>
                <modal :name="'view_video_modal'+img_data.id" height="350px" width="600px" >
                  <Videos :option="{type: 'video/mp4',src: project_path.file+img_data.filename}"></Videos>
                </modal>


              </div>
            </div>


          </div>

        </div>
      </section>
    </div>
    <div class="row" v-else></div>

<!-- 
    <modal name="ask_for_password">
      <div class="window-header">
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8 form_content_box">
            <div class="form_logo"><img src="../../../img/datacuda.png"></div>
            <flash-message class="myCustomClass"></flash-message>
            <h2>Enter Your Project Password</h2>
            <div class="form-group">
              <input type="text" name="Project Password" class="form_cus form-control"
                placeholder="Enter your project Password" v-model="project_pass" v-validate="'required'">
              <span class="error" v-if="errors.has('Project Password')">{{errors.first('Project Password')}}</span>
              <span class="error" v-if="Pass_status === 1">Password Wrong</span>
            </div>
            <div class="form-group">
              <button class="btn green_btn btn-block" v-on:click="CheckPass()">Submit</button>
            </div>
          </div>
          <div class="col-md-2"></div>
        </div>
      </div>
    </modal> -->

    <div class="modal" id="myModal" name="ask_for_password">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

          <!-- Modal body -->
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 form_content_box">
              <div class="form_logo"><img src="../../../img/datacuda.png"></div>
              <flash-message class="myCustomClass"></flash-message>
              <h2>Enter Your Project Password</h2>
              <div class="form-group col-md-12">
                <input type="password" name="Project Password" class="form_cus form-control"
                  placeholder="Enter your project Password" v-model="project_pass" v-validate="'required'">
                <span class="error" v-if="errors.has('Project Password')">{{errors.first('Project Password')}}</span>
                <span class="error" v-if="Pass_status === 1">Password Wrong</span>
              </div>
              <div class="form-group col-md-12">
                <button class="hide-modal btn green_btn btn-block" v-on:click="CheckPass()">Submit</button>
              </div>
            </div>
            <div class="col-md-2"></div>
          </div>

          <!-- Modal footer -->
          <!-- <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div> -->

        </div>
      </div>
    </div>

     <div class="modal" id="myModal1" name="ask_for_password">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

          <!-- Modal Header -->
          <!-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> -->

          <!-- Modal body -->
          <div class="row p-0 m-0">
                <div class="left-wrapper  payment_left_content">
                    <div class="left-content payment_content" >
                        <h3 class="pay_heading">You order</h3>
                        <flash-message class="myCustomClass"></flash-message>
                        <div class="table-responsive max-height">
                          <table class="payment_table table">
                            <tbody>
                              <tr v-for="(v,k) in share_amount" v-bind:key="k">
                                <td>{{ share_amount_desc[k] }}</td>
                                <td class="text-right">$ {{ v }}</td>
                              </tr>
                            </tbody>
                          </table>
                          <hr>
                          <table class="payment_table table">
                            <tbody>
                              <!--<tr>
                              <td>Full set of photos</td>
                            &lt;!&ndash; <td class="text-right">{{ totalAmount(project_data.medias) }}</td>&ndash;&gt;
                              <td class="text-right">$ {{ share_data.buy_amount }} </td>
                            </tr>
                            <tr class="fz_small">
                              <td>Processing fee</td>
                              <td class="text-right">$ 30</td>
                            </tr>-->
                              <tr class="fz_big">
                                <td>TOTAL</td>
                                <td class="text-right">$ {{ share_data.buy_amount }}  </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <!-- <a href="#" class="btn payment_btn green_btn" @click="hide_payment">Cancel payment</a> -->
                    </div>
                </div>
                <div class="right-wrapper p-3">
                    <div class="right-content">
                       <form class="payment_form_data">
                <h2> Payment</h2>
                <div class="fail_payment">
                </div>
                <div class="payment_method">
                  <div class="row">
                    <div class="col-sm-12 col-12 form-group">
                      <input type="text" placeholder="Name on Credit Card" class="form-control" v-model="buyerName">
                    </div>
                    <div class="col-sm-12 col-12 from-group">
                      <input type="text" placeholder="Email" class="form-control"
                        v-model="buyerEmail">
                    </div>
                  </div>
                  <div class="card_number form-group mt-3">
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
                            <input type="text" placeholder="00" class="form-control" v-model="month" autocomplete="off" maxlength="2">
                          </div>
                          <div class="col-sm-6 col-3">
                            
                            <input type="text" placeholder="00" class="form-control" v-model="year" autocomplete="off" maxlength="2" >
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3 col-3">
                      <div class="form-group">
                        <label>CVV</label>
                        <input type="password" placeholder="" maxlength="3" class="form-control" style="display:none">
                        <input type="password" placeholder="" maxlength="3" class="form-control" v-model="cvc" autocomplete="off" >
                      </div>
                    </div>
                    <div class="col-md-12">
                      <a href="javascript:void(0)" v-on:click="pay()" class="btn green_btn">PAY NOW</a>
                    </div>
                     
                     
                  <!-- <a href="javascript:void(0)" v-on:click="show_payment_success">Show</a>-->
                  <!---->
                 
              
                  </div>
                 
                </div>
              </form>
                    </div>
                       
                </div>
            </div>

          <!-- Modal footer -->
          <!-- <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div> -->

        </div>
      </div>
    </div>







   

    <!-- <modal name="payment_modal_success" height="100%" width="90%" :scrollable="false" draggable=".window-header">
      <PaymentSuccess></PaymentSuccess>
    </modal> -->
     <div class="modal fade project-modal payment-modal-content" id="payment_modal_success" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <PaymentSuccess></PaymentSuccess>
      </div>
    <!-- <modal name="payment_modal_failed" height="100%" width="90%" :scrollable="false" draggable=".window-header">
      <PaymentFailed></PaymentFailed>
    </modal> -->
    <div class="modal fade project-modal payment-modal-content" id="payment_modal_failed" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <PaymentFailed></PaymentFailed>
    </div>
    
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
  import Videos from '../Reusable/Videos';
  import { Pano } from 'vuejs-vr'

  export default {
    components: {
      PaymentSuccess,
      PaymentFailed,
      Videos,
      Pano
    },
    data() {
      return {
        urls: [
              '/assets/img/360 image stitching error cellphone - 1280x640.jpg',
              '/assets/img/360 image stitching error cellphone - 1280x640.jpg'
            ],
        index: 0,
        Pass_show: 0,
        button_text: "Buy Now",
        project_data: [],
        total_amount: "",
        card_1: "",
        card_2: "",
        card_3: "",
        card_4: "",
        month: "",
        year: "",
        cvc: "",
        total_ack: "",
        Image_data: "",
        totalFinalAmountSend: "",
        payed: 0,
        order_by: "id",
        usagedata: "",
        buyerName: "",
        buyerEmail: "",
        password: "",
        project_path: '',
        Pass_status: 0,
        project_pass: '',
        message: '',
        filename: '',
        share_data: '',
        share_amount:[],
        share_amount_desc:[],
        release_logo:'',
        release_logo_ext:'',
        release_video:'',
        release_video_ext:'',
        password_protect:''
      };
    },
    methods: {
      view_video(id) {
        this.$modal.show("view_video_modal" + id);
      },
      video_hide(id) {
        this.$modal.hide("view_video_modal" + id);
        
      },

      view_video1(){
        this.$modal.show("view_video_modalr1");
      },
      view_video2(){
        this.$modal.show("view_video_modalr2");
      },
      show_payment() {
        //this.$modal.show("payment_modal");
         $("#myModal1").modal()
      },
      hide_payment() {
        //this.$modal.hide("payment_modal");
        $('#myModal1').modal('toggle');
      },
      show_payment_success() {
        // this.$modal.show("payment_modal_success");
         $("#payment_modal_success").modal()
      },
      hide_payment_success() {
        // this.$modal.hide("payment_modal_success");
        $("#payment_modal_success").modal('toggle')
      },
      show_payment_failed() {
        // this.$modal.show("payment_modal_failed");
         $("#payment_modal_failed").modal()
      },
      ask_for_password() {
        this.$modal.show("ask_for_password");
      },
      ask_for_password_hide() {
        this.$modal.hide("ask_for_password");
      },
      totalAmount: function (medias) {
        return medias.reduce((acc, val) => {
          this.total_ack = acc + parseInt(val.amount);
          return acc + parseInt(val.amount);
        }, 0);
      },

      pay() {
        let data = {
          amount: this.project_data.share_data.buy_amount,
          project_data: this.project_data,
          card_no: this.card_1 + this.card_2 + this.card_3 + this.card_4,
          month: this.month,
          year: this.year,
          cvc: this.cvc,
          buyerName: this.buyerName,
          buyerEmail: this.buyerEmail,
          rep_id: this.$route.params.id,
        };
        axios
          .post("/api/share_project_buy", data)
          .then(({
            response
          }) => {
            //console.log("here");
            this.paid_notification();
            this.get_data();
            this.hide_payment();
            this.flash("Payment Successfully done !", "success");
            this.show_payment_success();
            this.payed = 1;
          })
          .catch(({
            response
          }) => {
            //console.log("there");
            this.flash("Payment Failed !", "error");
            this.hide_payment();
            this.show_payment_failed();
            this.payed = 0;
          });
      },
      flip() {
        if (this.button_text === "Buy Now") {
          this.button_text = "Cancel Payment";
        } else {
          this.button_text = "Buy Now";
        }
        $(".card").toggleClass("flipped");
      },
      get_data() {
        let data = {
          img_id: this.$route.params.id
        };
        
        axios
          .post("/api/get_share_project_data", data)
          .then(response => {
            this.project_data = response.data.data;
            this.share_data = this.project_data.share_data;
            this.share_amount = JSON.parse(this.share_data.amount);
            this.share_amount_desc = JSON.parse(this.share_data.description);
            this.project_path = response.data.path;
            this.payed = response.data.buystatus;
            if(this.project_data.company.company_logo){
              this.release_logo = "/database/" +this.project_data.user.email + '/'+this.project_data.company.company_logo;
              this.release_logo_ext = this.project_data.company.company_logo.split('.').reverse()[0];
            }

            if(this.project_data.company.other_image){
              this.release_video = "/database/" +this.project_data.user.email + '/'+this.project_data.company.other_image;
              this.release_video_ext = this.project_data.company.other_image.split('.').reverse()[0];
            }
            
            this.password_protect =  this.share_data.amount.password_protect;
             
            if(this.share_data.password_protect == '0'){
              this.view_notification();
              $("#myModal .close").click()
              this.Pass_status = 0;
              this.Pass_show = 1;
              this.get_data();
              this.ask_for_password_hide();
            }

            console.log(this.release_video_ext);
          })
          .catch(({
            response
          }) => {
            //this.$router.push("/");
          });
      },
      CheckPass() {
        this.$validator.validate('Project Password')
          .then(result => {
            if (!result) {
              return false
            }
            if (result) {
              let data = {
                rep_id: this.$route.params.id,
                rep_pass: this.project_pass
              };
              axios
                .post("/api/project_pass_check", data)
                .then(({
                  response
                }) => {
                  
                  //$('#myModal').modal('toggle');
                  this.view_notification();
                  $("#myModal .close").click()
                  this.Pass_status = 0;
                  this.Pass_show = 1;
                  this.get_data();
                  this.ask_for_password_hide();
                })
                .catch(({
                  response
                }) => {
                  // console.log(response);
                  //this.$router.push("/");
                  this.Pass_status = 1;
                });
            }
          });
      },
      view_notification(){
       // console.log("view notification ");
          let data = {
            img_id: this.$route.params.id
          };
          axios
            .post("/api/project_view_notification", data)
            .then(({response}) => {
              console.log(response);
            })
            .catch(({
              response
            }) => {
              
          });
      },
      download_notification(){
       // console.log("view notification ");
          let data = {
            img_id: this.$route.params.id
          };
          axios
            .post("/api/project_download_notification", data)
            .then(({response}) => {
              console.log(response);
            })
            .catch(({
              response
            }) => {
              
          });
      },
       paid_notification(){
       // console.log("view notification ");
          let data = {
            img_id: this.$route.params.id
          };
          axios
            .post("/api/project_paid_notification", data)
            .then(({response}) => {
              console.log(response);
            })
            .catch(({
              response
            }) => {
              
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
      check_auth() {
        /*if (!auth.check()) {
          this.$session.start();
          this.$session.set("request_page", "/shareproject/");
          this.$session.set("request_value", this.$route.params.id);
          this.$router.push("/login");
        } else {
          this.session_unset();
          this.get_data();
        }*/

      },
      session_unset() {
        if (this.$session.has("request_page")) {
          this.$session.remove("request_page");
          if (this.$session.has("request_value")) {
            this.$session.remove("request_value");
          }
        }
      },

      download_project(id) {
        let data = {
          id: id,
          id_type: "share_project",
          rep_id: this.$route.params.id
        };
        axios
          .post("/api/download_project", data)
          .then(response => {
            var url = response.data.data.url;
            window.location.href = url;
            this.download_notification();
          })
          .catch(response => {
            //console.log(response);
          });
      }
    },
    mounted() {
      this.get_data();
      $("#myModal").modal()
     
      
    },
    computed: {
      totalFinalAmount: function () {
        let sum = 0;
        sum += this.total_ack + 30;
        this.totalFinalAmountSend = sum;
        return sum;
      }
    },
    updated() {
      this.ask_for_password();
    }
  };
</script>