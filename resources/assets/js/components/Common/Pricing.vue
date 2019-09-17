<template>
	<div>
		<!-- Contact Content -->
		<section class="pricing_plans_wrapper">
			<div class="container clearfix">
				<div class="plan_S_wrapper">
					<h2>Choose the best plan for your needs</h2>
					<p>Brings you the business-class features with PRO account</p>
				</div>
				<div class="plan__box_wrappernew row clearfix">
					<div class="col-lg-3 col-md-3 col-sm-6 col-12" v-for="plan in plans">
						<div class="plan_price_main_box">
							<h3>{{ plan.name }}</h3>
							<img v-bind:src="getImg (plan.id)" class="plan_icon">
							<div class="plan_time">
								<h1>{{ plan.amount }}</h1>
								<span>/{{ plan.storage_quantity }} {{ plan.storage_unit }}</span>
							</div>
							<p v-for="benifit in plan.benifits">{{ benifit }}</p>
							<a href="#" class="btn green_btn"  >try it now</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- <modal name="plan_buy" height="auto" width= "70%" :scrollable="true" draggable=".window-header">
            <Pay/>
        </modal> -->
	</div>
</template>


<script>
	import Pay from "../Payments/Pay";
	export default {
		data (){
			return{
				plans: null,
			}
		},
		mounted () {
			axios.get('/api/subscription-plans')
			.then(response => {
				this.plans = response.data;
			})
		},
		methods: {
			// planpay(id){
			// 	window.localStorage.setItem("selected_plan_id", id);
			// 	this.show_pay_plans();
			// 	//this.$router.push("/payment-pay");
			// },
			// show_pay_plans(){
			// 	this.$modal.show("plan_buy");
			// },
			getImg:(id) =>{
				return '/assets/img/plan_icon_'+ id +'.png';
			}
		}
	}
</script>