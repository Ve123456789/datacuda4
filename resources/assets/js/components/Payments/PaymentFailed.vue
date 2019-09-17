<template>
    <!-- <section class="payments_wrapper white_bg">
        <div class="container">
                 <flash-message class="myCustomClass"></flash-message>

            <div class="payments_main_box">
                <div class="row">
                    <div class="payment_left_content col-md-7">
                        <div class="payment_success">
                            <img src="../../../img/rocket.svg">
                            <h2>Payment Failed</h2>
                        </div>
                    </div>
                    <div class="payment_right_content white_bg col-md-5">
                        <div class="pay_success_right_content">
                            <h3 style="color: red">Your payment failed, Please Try again.</h3>
                            <img src="../../../img/datacuda.png" class="pay_logo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
  
          <div class="modal-body" >
              <div class="row p-0 m-0">
                  <div class="left-wrapper payment-modals" style="background:url(assets/img/payment_bg.png) center">
                      <div class="payment_success">
                            <!-- <img src="../../../img/rocket.svg" class="img-fluid"> -->
                            <h2 class="text-white">Payment not successfull!</h2>
                            <h3 style="color: red" class="text-center">Please Try again</h3>
                        </div>
                        <!-- <a href="#" class="btn payment_btn green_btn" @click="hide_payment">Cancel payment</a> -->
                  </div>
                  <div class="right-wrapper">
                    <div class="right-content">
                        <div class="pay_success_right_content">
                            <img src="../../../img/datacuda.png" class="pay_logo img-fluid mb-3">
                            
                            <a href="javascript:void(0)" class="btn btn-block green_btn mt-5 mb-4" v-on:click="show_payment()" >Pay Now</a>
                            <!-- <a href="#" class="btn btn-block btn-primary mt-4 mb-4"><i class="fa fa-paypal"></i> Paypal</a> -->
                        </div>
                    </div>
                </div>
              </div>
             
          </div>
  
        </div>
      </div>
</template>

<script>
    export default {
        data() {

        },
        methods:{
            show_payment() {
                //this.$modal.show("payment_modal");
                $("#myModal1").modal()
                $("#payment_modal_failed").modal('hide')
            },
        }
    }
</script>
