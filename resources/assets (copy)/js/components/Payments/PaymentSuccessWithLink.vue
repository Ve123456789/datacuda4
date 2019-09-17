<template>
    <section class="payments_wrapper white_bg">
        <div class="container">
            <div class="payments_main_box">
                <div class="row">
                    <div class="payment_left_content col-md-7">
                        <div class="payment_success">
                            <img src="/assets/img/rocket.svg">
                            <h2>Files sent successful</h2>
                        </div>
                    </div>
                    <div class="payment_right_content white_bg col-md-5">
                        <div class="pay_link_wrapper">
                            <h3>A link to your files is below </h3>
                            <input type="text" class="form-control" id="copy_link" value="https://datacuda/alamtest" readonly>
                            <button class="btn green_btn" onclick="copyLink()">Copy Link</button>
                            <p>Password: &nbsp;<span>12345678</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

    <script>
        export default {
            data() {

            }
        }
    </script>