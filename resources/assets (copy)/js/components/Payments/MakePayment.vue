<template>
            <section class="payments_wrapper white_bg">
                <div class="container">
                    <div class="payments_main_box">
                        <div class="row">
                            <div class="payment_left_content col-md-7">
                                <div class="payment_content">
                                    <h3 class="pay_heading">You order</h3>
                                    <table class="payment_table table">
                                        <tbody>
                                        <tr v-for="img_data in project_data.medias">
                                            <td>{{ img_data.filename.substring(0,20) + '...' }}</td>
                                            <td class="text-right">$ {{ img_data.amount }}</td>
                                            {{ }}
                                        </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <table class="payment_table table">
                                        <tbody>
                                        <tr>
                                            <td>Full set of photos</td>
                                            <td class="text-right">{{ totalAmount(project_data.medias) }}</td>
                                        </tr>
                                        <tr class="fz_small">
                                            <td>Processing fee</td>
                                            <td class="text-right">$ 30</td>
                                        </tr>
                                        <tr class="fz_big">
                                            <td>TOTAL</td>
                                            <td class="text-right">$ {{ totalFinalAmount }} </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <a href="#" class="btn payment_btn" @click="hide_payment">Cancel payment</a>
                            </div>
                            <div class="payment_right_content white_bg col-md-5">
                                <form class="payment_form_data">
                                    <h2> Payment</h2>

                                    <div class="fail_payment">
                                    </div>
                                    <div class="payment_method">

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
                                        <a href="javascript:void(0)" v-on:click="show_payment_success">Show</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <modal name="payment_modal_success" height="100%" width= "48%" :scrollable="false" draggable=".window-header">

                    <PaymentSuccess/>
                </modal>
                <modal name="payment_modal_failed" height="100%" width= "48%" :scrollable="false" draggable=".window-header">

                    <PaymentFailed/>
                </modal>
            </section>
    </template>

<script>
    import MakePayment from '../Payments/MakePayment';
    import PaymentSuccess from '../Payments/PaymentSuccess';
    import PaymentFailed from '../Payments/PaymentFailed';

    export default {
        components: {
            MakePayment,
            PaymentSuccess,
            PaymentFailed
        },
        data() {
            return {
                button_text:'Buy Now',
                project_data:'',
                total_amount:'',
                card_1:'',
                card_2:'',
                card_3:'',
                card_4:'',
                month:'',
                year:'',
                cvc:'',
                total_ack:'',
                Image_data:'',
                totalFinalAmountSend:'',
                payed:0

            };
        },
        methods: {
            show_payment () {
                this.$modal.show('payment_modal');
            },
            hide_payment () {
                this.$modal.hide('payment_modal');
            },
            show_payment_success () {
                this.$modal.show('payment_modal_success');
            },
            hide_payment_success () {
                this.$modal.hide('payment_modal_success');

            },
            show_payment_failed () {
                this.$modal.show('payment_modal_failed');
            },
            totalAmount: function (medias) {
                return medias.reduce((acc, val) => {
                    this.total_ack = acc + parseInt(val.amount);
                    return acc + parseInt(val.amount);
                }, 0);
            },
            pay() {
                let data = {
                    amount: this.totalFinalAmountSend,
                    project_data : this.project_data,
                    card_no: this.card_1+this.card_2+this.card_3+this.card_4,
                    month: this.month,
                    year: this.year,
                    cvc: this.cvc,
                };
                axios
                    .post('/api/imagebuy', data)
                    .then(({ data }) => {
                        this.$parent.payed = 1;
                        this.hide_payment();
                    })
                    .catch(({ response }) => {
                        this.flash(response.data.message, 'error');

                        this.$parent.payed = 0;
                        this.hide_payment();
                    });
            },
            flip() {
                if(this.button_text === 'Buy Now')
                {
                    this.button_text = 'Cancel Payment';
                }
                else {
                    this.button_text = 'Buy Now';
                }
                $('.card').toggleClass('flipped');
            },
            get_data()
            {
                let data  = {
                    img_id:this.$route.params.id
                };
                axios
                    .post('/api/get_share_project_data',data).then((response)=>{
                    this.project_data = response.data.data;
                    //console.log(this.project_data);
                })
                    .catch(({ response }) => {

                        this.$router.push('/');
                    });
            },
            check_auth()
            {
                if (!auth.check()) {
                    this.$session.start();
                    this.$session.set('request_page','/shareproject/');
                    this.$session.set('request_value',this.$route.params.id);
                    this.$router.push('/login');
                }
                else
                {
                    this.session_unset();
                    this.get_data();
                }
            },
            session_unset(){
                if(this.$session.has('request_page'))
                {
                    this.$session.remove('request_page');
                    if(this.$session.has('request_value')){
                        this.$session.remove('request_value');
                    }
                }
            }
        },
        mounted(){
            this.check_auth();
        },
        computed: {
            totalFinalAmount: function () {
                let sum = 0;
                sum += (this.total_ack) + 30;
                this.totalFinalAmountSend = sum;
                return sum;
            }
        }
    };
</script>
