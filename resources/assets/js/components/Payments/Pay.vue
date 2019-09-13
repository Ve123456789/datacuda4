<template>
    <div>
        <section class="about_content_wrapper">
            <div class="container">

                <!-- <img src="{{url('assets/img/close.svg')}}" class="m_close_btn"> -->
                <img src="../../../img/close.svg" class="m_close_btn"  @click="hide_pay_plan">
                <div class="row">
                    <div class="model_mob col-md-8">
                        <div class="model_cloud_business_content">
                            <h3>DataCuda Business Plan</h3>
                            <router-link to="/Pricing" class="btn blue_big_btn">Learn More</router-link>

                            <!-- <img src="{{url('assets/img/login_icon.png')}}" alt="" class="datacuda_img"> -->
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
                            <!-- <div class="form_logo"><img src="{{url('assets/img/datacuda.png')}}"></div> -->
                            <div class="form_logo"><img src="../../../img/datacuda.png"></div>
                            <flash-message class="myCustomClass"></flash-message>

                            <h2>Pay for this Plan</h2>
                            <card class='stripe-card'
                                :class='{ complete }'
                                stripe='pk_test_yXJ1wEyO40adxsXnE2PsnifG00eStoSozK'
                                :options='stripeOptions'
                                @change='complete = $event.complete'
                                />
                            <button class='pay-with-stripe' @click='payToken' :disabled='!complete'>Pay with credit card</button>
                            <!-- <p>
                                <b>Selected Plan :</b> {{PlanName}}<br>
                                <b>Pay Amount :</b> <i class="fa fa-dollar"></i> {{PlanAmount/100}}
                            </p>
                            <div class="form-group">
                                <input type="text" name = "card_no" class="form_cus form-control" id=
                                "card_no" placeholder="Card No" v-model="card_no">
                            </div>
                            <div class="form-group">
                                <input type="text" name = "month" class="form_cus form-control" id="month" placeholder="Expiry Month" v-model="month">
                            </div>
                            <div class="form-group">
                                <input type="text" name = "year" class="form_cus form-control" id="year" placeholder="Expiry Year" v-model="year">
                            </div>
                            <div class="form-group">
                                <input type="text" name = "" class="form_cus form-control" id="cvc" placeholder="cvv" v-model="cvc">
                            </div>
                            <div class="form-group">
                                <button class="btn big_btn" @click="pay">Pay</button>
                            </div> -->


                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>

import { Card, createToken } from 'vue-stripe-elements-plus';

    export default {
        data() {
            return {
                PlanName :'',
                PlanAmount : '',
                PlanId :'',
                complete: false,
                stripeOptions: {
                    // see https://stripe.com/docs/stripe.js#element-options for details
                }
            };
        },

        components: { Card },

        methods: {
            payToken(){
                
                createToken().then((data) => { 
                    //console.log(data);
                    console.log(data.token)
                    axios
                    .post('/api/planpay', data.token)
                    .then(({ data }) => {
                        // this.$router.push('/dashboard');
                        console.log ('disco dancer')
                    })
                    .catch(({ response }) => {
                        this.flash(response.data.message, 'error');
                    });
                })

            },
            // pay() {
            //     let data = {
            //         pay_plan : this.PlanId,
            //         card_no: this.card_no,
            //         month: this.month,
            //         year: this.year,
            //         cvc: this.cvc,
            //     };
            //     axios
            //         .post('/api/planpay', data)
            //         .then(({ data }) => {
            //             this.$router.push('/dashboard');
            //         })
            //         .catch(({ response }) => {
            //             this.flash(response.data.message, 'error');
            //         });
            // },

            hide_pay_plan(){
                 this.$modal.hide("plan_buy");
            }

        },
        mounted(){
            let data  = {id:window.localStorage.getItem('selected_plan_id')};
            axios.post('/api/getplandetails',data).then((response)=>{
                this.PlanName   = response.data.data.name;
                this.PlanAmount = response.data.data.amount;
                this.PlanId     = response.data.data.plan_id;
            })
            .catch(({ response }) => {
                this.$router.push('/dashboard');
            });
        },
    };
</script>
