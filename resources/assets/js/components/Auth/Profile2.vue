<template>
	<div class="container clearfix pb-7">
		
		<ul class="inner_nav_Bar">
			<li><a href="javascript:void(0)" class="active" id="my_account_nav"> My Account</a></li>
			<li><a href="javascript:void(0)" id="finance_nav" >Finance</a></li>
			<li><a href="javascript:void(0)" id="plan_nav">Plans</a></li>
			<li><a href="javascript:void(0)" id="biling_nav">Subscriptions / Billing</a></li>
		</ul>
		
		<div class="my_Account" style="display: block;" id="my__Account_data">
			<div class="account_wrapper white_bg clearfix">
				<ul class="profile_nav">
					<li><a href="javascript:void(0)" class="active" id="my_profile">My Profile</a></li>
					<li><a href="javascript:void(0)" id="company_profile">Company Profile</a></li>
				</ul>
				<div class="account_content" style="display:block;" id="profile_data">
					<div class="row">
						<div class="col-md-6 custom-margin">
							<div class="account_profile">
								<div class="avatar-upload">
									<div class="avatar-edit">
										<div class="image-wrapper">
											<div class="avatar-preview">
												<div id="imagePreview"  v-if="userDatapicture" :style="{ backgroundImage: 'url(' + imageLink + ')' }">
												</div>
												<!-- <div id="imagePreview"  v-else :style="{ backgroundImage: 'url(../../../img/avatar.png)' }">
												</div> -->
											</div>
											<img v-if="!userDatapicture" src="../../../img/avatar.png">
											
										</div>
										<input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" ref="file" v-on:change="companyUpload"/>
										<label for="imageUpload">Choose photo</label>

									</div>
									<!-- <div class="avatar-preview">
										<div id="imagePreview" :style="{ backgroundImage: 'url(' + imageLink + ')' }">
										</div>
									</div> -->
								</div>
							
							</div>

								<form class="project_amount_input">
									<div class="form-group">
										<label class="account_lable">Project</label>
										<input type="text" class="form-control" :placeholder="user_project_buy.length">
									</div>
									<div class="form-group">

										<label class="account_lable">Amount</label>
										<input type="text" class="form-control" :placeholder="'$'+projectPriceTotal()">

									</div>
								</form>
						</div>

						
						<div class="col-md-6">
							
							<form class="account_form clearfix" id="user_detail_form" @submit.prevent="edit_save_profile">
								
								<div class="row">

										<div class="form-group col-md-6">
											<label class="account_lable">First Name *</label>
											<input type="text" class="form-control" name="First Name" v-model="first_name" v-validate="'required|alpha_num'" pla>
											<span class="error" v-if="errors.has('First Name')">{{errors.first('First Name')}}</span>
										</div>

										<div class="form-group col-md-6">
												<label class="account_lable">Last Name *</label>
											<input type="text" class="form-control" name="Last Name" v-model="last_name" v-validate="'required|alpha_num'" pla>
											<span class="error" v-if="errors.has('Last Name')">{{errors.first('Last Name')}}</span>
										</div>

										<div class="form-group col-md-12">
											<label class="account_lable">Email</label>
											<input type="text" class="form-control" name="Email" v-model="email"  v-validate="'required|email'" >
											<span class="error" v-if="errors.has('Email')">{{errors.first('Email')}}</span>
											<span class="tool_tip">Change email</span>
										</div>
										<div class="form-group col-md-12">
											<label class="account_lable">Password</label>
											<input type="Password" class="form-control" v-model="password"  data-vv-name="newPassword" v-validate="'required'" >
											<span class="error" v-if="errors.has('Password')">{{errors.first('Password')}}</span>
											<span class="tool_tip">Change password</span>
										</div>
										<div class="col-md-12">
											<button type="submit" class="btn green_btn">Save</button>
										</div>

									</div>								
							</form>
						</div>
					</div>
				</div>
				<div class="company_wrapper" id="company_data">
					
					<form method="POST" class="company_profile_form" id="company_detail_form" @submit.prevent="edit_save_company_profile">
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label>Company name</label>
									<div class="form-group">
										<!-- <select class="form-control" id="exampleFormControlSelect1">
											<option>Company Name</option>
											<option>2</option>
										</select> -->
									</div>
									<input type="text" class="form-control" placeholder="Company name" name="Company Name" v-model="company_name"  v-validate="'required'" >
									<span class="error" v-if="errors.has('Company Name')">{{errors.first('Company Name')}}</span>
								</div>
								<div class="address_ form-group">
									<label>Address</label>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Address"  name="Company Address" v-model="company_address"  v-validate="'required'" >
										<span class="error" v-if="errors.has('Company Address')">{{errors.first('Company Address')}}</span>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="City"  name="Company City" v-model="company_city"  v-validate="'required'" >
												<span class="error" v-if="errors.has('Company City')">{{errors.first('Company City')}}</span>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												
												<select class="form-control" id="exampleFormControlSelect1" name="Country Name" v-model="company_country"   v-validate="'required'" @change="getStateData($event)" >
														<option value="" >Countries</option>
														<option v-for="countrie in countries" v-bind:key="countrie.id" :value="countrie.id" >{{ countrie.name }}</option>
												</select>
												<span class="error" v-if="errors.has('Country Name')">{{errors.first('Country Name')}}</span>
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Zip" name="Zip Code" v-model="company_zip"  v-validate="'required|alpha_num'" >
												<span class="error" v-if="errors.has('Zip Code')">{{errors.first('Zip Code')}}</span>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<!-- <input type="text" class="form-control" placeholder="State"  name="Company State" v-model="company_state"  v-validate="'alpha_num'" > -->
													<select class="form-control" id="exampleFormControlSelect1" name="Company State" v-model="company_state"   v-validate="'alpha_num'" >
														<option  value=""  >State</option>
														<option v-if="state" v-for="state in states" v-bind:key="state.id" :value="state.id" >{{ state.name }}</option>
													</select>
												<span class="error" v-if="errors.has('Company State')">{{ errors.first('Company State') }}</span>
											</div>
										</div>

											<div class="form-group col-md-4">
												<label>Phone</label>
												<input type="text" class="form-control" placeholder="Business" name="Phone Number" v-model="company_phone_buss"  v-validate="'required'" >
												<span class="error" v-if="errors.has('Phone Number')">{{errors.first('Phone Number')}}</span>
											</div>

											<div class="form-group col-md-4">
												<label class="v-hidden">Mobile</label>
												<input type="text" class="form-control" placeholder="Mobile" name="Mobile Number" v-model="company_mobile_buss"  v-validate="'required'" >
												<span class="error" v-if="errors.has('Mobile Number')">{{errors.first('Phone Number')}}</span>
											</div>
											<div class="form-group col-md-4">
												<label class="v-hidden">Fax</label>
												<input type="text" class="form-control" placeholder="Fax" name="Fax Number" v-model="company_phone_fax"  v-validate="" >
												<span class="error" v-if="errors.has('Fax Number')">{{errors.first('Fax Number')}}</span>
											</div>
									</div>
								</div>
				

								<div class="form-group">
									<label>Business email</label>
									<input type="text" class="form-control" placeholder="Business Email" name="Business Email" v-model="company_business_email"  v-validate="'email'" >
									<span class="error" v-if="errors.has('Business Email')">{{errors.first('Business Email')}}</span>
								</div>
								<div class="form-group">
									<label>Website</label>
									<input type="text" class="form-control" placeholder="URL address" name="Website" v-model="company_website"  v-validate=""  >
									<!-- <input type="text" class="form-control" placeholder="URL address" name="Website" v-model="company_website"  v-validate="'url:require_protocol'" > -->
									<span class="error" v-if="errors.has('Website')">{{errors.first('Website')}}</span>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Currency</label>
											<select name="" class="form-control">
												<option>USD</option>
												<option>Select</option>
												<option>USD</option>
												<option>USD</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<label>Card No</label>
										<input type="text" name = "card_no" class="form_cus form-control" id="card_no" placeholder="Card No" v-model="card_no" >
									</div>
								</div>

								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label>Expiry Month</label>
											<input type="text" name = "month" class="form_cus form-control" id="month" placeholder="Expiry Month" v-model="month">
										</div>
									</div>
									<div class="col-md-4">
										<label>Year</label>
										<input type="text" name = "year" class="form_cus form-control" id="year" placeholder="Expiry Year" v-model="year">
									</div>
									<div class="col-md-4">
										<label>CVC</label>
										<input type="text" name = "" class="form_cus form-control" id="cvc" placeholder="cvv" v-model="cvc">
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Upload document </label>
											<input type="file" id=""  ref="file"  class="" v-on:change="stripeDocUpload" />
										</div>
									</div>
									<!-- <div class="col-md-6">
										<label>Year</label>
										<input type="text" name = "year" class="form_cus form-control" id="year" placeholder="Expiry Year" v-model="year">
									</div>
									 -->
								</div>

								
								<!-- <div class="form-group">
									<button type="submit" class="save_btn1 btn green_btn">Save</button>
								</div> -->
							<!-- </form> -->
						</div>
						<div class="col-md-4">
							<!-- <form class="company_profile_form clearfix"> -->
								<div class="form-group">
									<label>Upload logo</label>
									<section class="sec sec-select" id="fileDrag">
										<img src="/assets/img/upload.svg" class="uploa_d_icon">
										<h3>Drag & Drop</h3>
										<input type="file" id="company_logo" accept=".png, .jpg, .jpeg" ref="file" v-on:change="companyUpload" class="d-none"/>
										or <label class="btn_browse" for="company_logo"> Browse Files</label>
									</section>
								</div>
								
								<!-- <img v-bind:src="company_logo" width="100px" height="100px"> -->
								 <div class="form_logo_upload my-2" v-if="company_logo_name" ><img  :src="company_logo" class="img-fluid"></div>

								<div class="form-group">
									<label>Upload film/image release</label>
									<section class="sec sec-select" id="fileDrag2">
										<img src="/assets/img/upload.svg" class="uploa_d_icon">
										<h3>Drag & Drop</h3>
										<input type="file" id="company_film"  ref="file" v-on:change="companyUpload" class="d-none"/>
										or <label class="btn_browse" for="company_film"> Browse Files</label>
									</section>
								</div>
								<!-- <img v-bind:src="company_film" width="100px" height="100px"> -->
								<div class="form_logo_upload my-2" v-if="company_film_name" ><img  :src="company_film" class="img-fluid"></div>
								<!-- <div class="company_profile_form_img my-2">
									<div class="company_profile_form_image_inner">
											<div>
												<img :src="company_film" class="img-fluid">
											</div>
											<div class="namesize">
												<p>Flower.jpg</p>
												<span>4.6Mb</span>
											</div>
									</div>
								
								</div> -->
								<div class="form-group">
									<button type="submit" class="save_btn1 btn green_btn pull-right">Save</button>
								</div>
							
							</div>
						
						</div>
					</form>
				</div>
				<div class="row">
					<div class="col-md-12">
						<flash-message class="myCustomClass"></flash-message>
					</div>
				</div>
			</div>
			<div class="notification_wrapper white_bg">
				<ul class="profile_nav">
					<li><a href="javascript:void(0)" class="active">Notifications</a></li>
				</ul>
				<div class="notification_content">
					<p>Receive notifications for new updates on your account</p><img src="/assets/img/success_icon.svg" class="success_icon">
				</div>
			</div>
		</div>
		<div class="plan__box_wrapper clearfix" id="plan_data">
			<div class="row clearfix">
				<div class="col-lg-4 col-md-4 col-sm-6 col-12" v-for="payplan in payplans" >
					<div class="plan_price_main_box">
						<h3>{{payplan.name}}</h3>
						<img src="/assets/img/plan_icon_1.png" class="plan_icon">
						<div class="plan_time">
							<h1>{{payplan.amount/100}}</h1><span>/{{payplan.name}}</span>
						</div>
						<p>Lorem ipsum dolor sit amet. sed do eiusmod tempor incididunt ut. Labore et dolore magna aliqua.</p>
						<a href="javascript:void(0)" class="btn default_btn" v-if="payplan.activeplan === 'Active'" aria-disabled="true">Current Plan</a>
						<a href="javascript:void(0)" class="btn green_btn" v-on:click="planpay(payplan.id)" v-else>try it now</a>
						<!-- @click="show_register"><a href="javascript:void(0)">Register</a></li> -->
						<div class="dis_n small_text">for 14 days</div>
					</div>
				</div>
			</div>
		</div>
		<div class="finance_wrapper" id="finance_data">
			<ul class="profile_nav">
				<li><a href="#" class="active">PaymentS & withdrawalS </a></li>
			</ul>
			<div class="payment_content_data table_responsive">
				<div class="payment_data_heading">
					<h3>Transactions</h3>
				</div>
				<table class="table ">
					<thead>
					<tr>
						<th scope="col">Customer</th>
						<th scope="col">Project Name</th>
						<th scope="col">Total Purchased</th>
						<th scope="col">Amount</th>
						<th scope="col">Status</th>
						<!--<th scope="col">Description</th>-->
						<th scope="col">Action</th>
					</tr>
					</thead>
					<tbody>
					<tr v-for="user_project in user_project_buy " v-bind:key="user_project.project_id" v-if="user_project.project_ShareImage.length > 0" >
				
						<th>{{ user_project.user_detail.username  }}</th>
						<td>{{ user_project.project_name  }}</td>
						<td>{{ user_project.project_ShareImage.length  }}</td>
						<td  >${{ projectPrices(user_project.project_ShareImage)  }}</td>
						<td class="text-danger" >Awaiting Payment </td>
						<td ><a href="#" class="finance_btn">Withdrawal</a></td>
						
					</tr>
					<tr v-for="user_project in user_project_buy " v-bind:key="user_project.project_id" v-if="user_project.project_purchase.length > 0">
						<th>{{ user_project.user_detail.username  }}</th>
						<td>{{ user_project.project_name  }}</td>
						<td>{{ user_project.project_purchase.length  }}</td>
						<td  >${{ projectPrice(user_project.project_purchase)  }}</td>
						<!-- <td v-else >${{ projectPrices(user_project.project_ShareImage)  }}</td> -->
						<td class="text-success" >Paid</td>
						<!-- <td class="text-danger" v-else>Awaiting Payment </td> -->

						<td  ><a href="#" class="finance_btn active">Withdrawal</a></td>
						<!-- v-if="user_project.purchase_details >= 1"<td v-else ><a href="#" class="finance_btn">Withdrawal</a></td> -->
					</tr>
					
					</tbody>
				</table>
			</div>
			<div class="payment_content_data">
				<div class="payment_data_heading">
					<h3>Payments & Revenue</h3>
				</div>
				
				<Chart v-if="chartLoaded && user_project_buy" v-bind:chartLoaded="chartLoaded" v-bind:user_project="user_project_buy" ></Chart>

			</div>
			<div class="payment_content_data">
				<div class="payment_data_heading">
					<h3>Total Stats</h3>
				</div>
				<div class="row">
					<div class="col-md-4 text-center my-2">
						<p class="payment-section-heading">All Projects</p>
						<div class="payment_data">
							<div class="project">
								<h3>{{ project_awaited_count +  project_completed_count }}</h3>
								<span>Projects</span>
							</div>
							<div class="amount">
								<h3>${{ projectPriceTotal() }}</h3>
								<span>Amount</span>
							</div>
						</div>
					</div>

					<div class="col-md-4 text-center my-2">
						<p class="payment-section-heading">Awaiting Projects</p>
						<div class="payment_data">
							<div class="project">
								<h3>{{ project_awaited_count }}</h3>
								<span>Projects</span>
							</div>
							<div class="amount">
								<h3>${{ projectPriceAwaited_amount }}</h3>
								<span>Amount</span>
							</div>
						</div>
					</div>

					<div class="col-md-4 text-center my-2">
						<p class="payment-section-heading">completed projects</p>
						<div class="payment_data">
							<div class="project">
								<h3>{{ project_completed_count }}</h3>
								<span>Projects</span>
							</div>
							<div class="amount">
								<h3>${{ projectPriceCompleted_amount }}</h3>
								<span>Amount</span>
							</div>
						</div>
					</div>
				</div>
				<!-- <div class="row">
					<div class="col-md-4">
						<div class="project_content_data">
							<h4>All PROJECTS</h4>
							<div class="clearfix">

							</div>
						</div>
					</div>
				</div> -->
			</div>
		</div>
		<div class="finance_wrapper" id="biling_data">
			<ul class="profile_nav">
				<li><a href="#" class="active">Subscription </a></li>
				<ul class="nav justify-content-end pull-right plan-details">
					<li class="nav-item">
						<a class="btn green_btn" href="#">Upgrade Plan</a>
					</li>
					<li class="nav-item">
						<a class="nav-link short" href="#">Downgrage Plan</a>
					</li>
					<li class="nav-item">
						<a class="nav-link short" href="#">Cancel Plan</a>
					</li>
				</ul>
			</ul>

			<div class="payment_content_data">
				<div class="payment_data_heading clearfix">
					<h3>{{ user_subscription_payplans.name }}</h3>
					<a href="#" class="view_plan_btn tdn blue_color">View Plans</a>
				</div>
				<table class="table table_responsive">
					<thead>
					<tr>
						<th scope="col">Date</th>
						<th scope="col">Active</th>
						<th scope="col">Recurring </th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td>{{ user_subscription_payplans.created_at | formatDateTime }}</td>
						<td>True</td>
						<td>${{ user_subscription_payplans.amount/100 }}</td>
					</tr>

					</tbody>
				</table>
			</div>
			<div class="payment_content_data">
				<div class="payment_data_heading clearfix">
					<h3>Charges and Credits</h3>
					<a href="#" class="view_plan_btn tdn blue_color">View Plans</a>
				</div>
				<table class="table table_responsive">
					<thead>
					<tr>
						<th scope="col">Subscription</th>
						<th scope="col">Charged on</th>
						<th scope="col">Invoice date</th>
						<th scope="col">Amount</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td>{{ user_subscription_payplans.name }}</td>
						<td>{{ user_subscription_payplans.created_at | formatDateTime }}</td>
						<td>NA</td>
						<td>${{ user_subscription_payplans.amount/100 }}</td>
					</tr>

					</tbody>
				</table>
			</div>
		</div>
		 <modal name="plan_buy" height="auto" width= "70%" :scrollable="true" draggable=".window-header">
            <Pay/>
        </modal>

		
								
		
	</div>
	
</template>
<style scoped>
span.error {
  color: #9f3a38;
}
</style>
<script>

import Vue from "vue";
import VeeValidate from "vee-validate";
Vue.use(VeeValidate);
import Pay from "../Payments/Pay";
import Chart from "../Reusable/Chart";

export default {
  components: {
	//Card,
	Pay,
	Chart
	},
  data() {
    let userData = JSON.parse(window.localStorage.getItem("user"));
    return {
		
	 userDatapicture : userData.picture,
      imageLink: "/database/" +userData.email + '/'+ userData.picture,
      email: userData.email ? userData.email : "",
      password: userData.password ? userData.password : "",
      first_name: userData.user_profile.first_name
        ? userData.user_profile.first_name
		: "",
		last_name: userData.user_profile.last_name
        ? userData.user_profile.last_name
        : "",
      address: userData.user_profile.address
        ? userData.user_profile.address
        : "",
      logo: userData.user_profile.logo ? userData.user_profile.logo : "",
      phone: userData.user_profile.phone ? userData.user_profile.phone : "",
      name: userData.name,
      company_name: userData.company_profile.company_name
        ? userData.company_profile.company_name
        : "",
      company_city: userData.company_profile.company_city
        ? userData.company_profile.company_city
        : "",
      company_address: userData.company_profile.company_address
        ? userData.company_profile.company_address
        : "",
      company_state: userData.company_profile.company_state
        ? userData.company_profile.company_state
        : "",
      company_zip: userData.company_profile.company_zip
        ? userData.company_profile.company_zip
        : "",
      company_country: userData.company_profile.company_country
        ? userData.company_profile.company_country
        : "",
      company_phone_buss: userData.company_profile.company_phone_buss
        ? userData.company_profile.company_phone_buss
		: "",
	  company_mobile_buss:userData.company_profile.company_mobile_buss
        ? userData.company_profile.company_mobile_buss
		: "",
      company_phone_fax: userData.company_profile.company_phone_fax
        ? userData.company_profile.company_phone_fax
        : "",
      company_business_email: userData.company_profile.company_business_email
        ? userData.company_profile.company_business_email
        : "",
      company_website: userData.company_profile.company_website
        ? userData.company_profile.company_website
        : "",
      company_logo: "/database/" +userData.email + '/'+ userData.company_profile.company_logo,
	  company_film: "/database/" +userData.email + '/'+ userData.company_profile.other_image,
	  company_logo_name:userData.company_profile.company_logo,
	  company_film_name:userData.company_profile.other_image,
      company_join_date: userData.company_profile.company_join_date
        ? userData.company_profile.company_join_date
		: " ",
		card_no:'',
		month:'', 
		year:'', 
		cvc : '', 
      payplans: "",
      user_subscription: "",
      user_subscription_payplans: "",
      user_project_buy: "",
		message: '',
	projectPriceCompleted_amount:0,
	projectPriceAwaited_amount:0,
	project_completed_count:0,
	project_awaited_count:0,
	countries:[],
	states:[],
	chartLoaded:false,
	stripDocFile:{},

    };
  },
  methods: {
	
	projectCompletedCount(){
		this.user_project_buy.forEach(function(el){
			this.project_completed_count += parseFloat(el.project_purchase.length);
			this.project_awaited_count += parseFloat(el.project_ShareImage.length);
		}.bind(this));
	},
	projectPriceCompleted(){
		let x=0;
		this.user_project_buy.forEach(function(el){
				el.project_purchase.forEach(function(element){
				x += parseFloat(element.by_amount);		
			}.bind(this));
		}.bind(this));
		this.projectPriceCompleted_amount = x.toFixed(2);

	},
	projectPriceAwaited(){
		let y=0;
		this.user_project_buy.forEach(function(el){
				el.project_ShareImage.forEach(function(element){
				y += parseFloat(element.buy_amount);			
			}.bind(this));
		}.bind(this));
		this.projectPriceAwaited_amount = y.toFixed(2);
	},
	projectPriceTotal(){
		let x = parseFloat(this.projectPriceCompleted_amount) + parseFloat(this.projectPriceAwaited_amount);
		return x.toFixed(2);
	},
	projectPrice(priceData){
		var project_price=0;
		priceData.forEach(element => {
			project_price += parseFloat(element.by_amount);
		});
		
		return project_price.toFixed(2);
	},	
	projectPrices(priceData){
		var project_price=0;
		priceData.forEach(element => {
			project_price += parseFloat(element.buy_amount);
		});
		return project_price.toFixed(2);
	},			
	show_pay_plans() {
      this.$modal.show("plan_buy");
    },
    getUserData() {
      axios
        .get("/api/get_user_detail")
        .then(function(data) {
			console.log("user data print",data.data.user);
			window.localStorage.setItem("user", JSON.stringify(data.data.user));
			let userData1 = data.data.user;
			this.userDatapicture =  userData1.picture;
	        this.imageLink = "/database/" +userData1.email + '/'+ userData1.picture;
	  		this.company_logo = "/database/" +userData1.email + '/'+ userData1.company_profile.company_logo;
			this.company_film =  "/database/" +userData1.email + '/'+ userData1.company_profile.other_image;
			this.company_logo_name = userData1.company_profile.company_logo,
	        this.company_film_name = userData1.company_profile.other_image,
			this.getStateDataEdit(userData1.company_profile.company_country,userData1.company_profile.company_state);
			//this.company_state = userData1.company_profile.company_state;
			//this.flash(data.data.message,"success");
		  	
        }.bind(this))
        .catch(function(response) {
          console.log("error",response);
        });
    },
    edit_save_profile(){

      this.$validator.validateAll();
      if (this.errors.any()) {
        return;
      }
      let auth_token = window.localStorage.getItem("token");
      let userData = JSON.parse(window.localStorage.getItem("user"));
      let data = {
        email: userData.email,
        user_id: userData.id,
        password: userData.password,
		first_name: this.first_name,
		last_name : this.last_name,
        address: this.address,
        logo: this.logo,
        phone: this.phone,
        auth_token: auth_token
      };
      axios
        .post("/api/user_profile", data)
        .then(({ response }) => {
          this.getUserData();
		  this.flash("Profile updated successfully", "success");
          // console.log(data.user);
        })
          .catch(({ response }) => {
              //console.log(response);
          });
	},
	
    edit_save_company_profile() {

      this.$validator.validateAll();
      if (this.errors.any()) {
        return;
	  }
	  
	//   Stripe.card.validateCardNumber('4242424242424242').then(function(res){
	// 	  console.log("pravin kumar",res);
	//   });

	//  return;
	  
      let auth_token = window.localStorage.getItem("token");
      let userData = JSON.parse(window.localStorage.getItem("user"));
    //   let data = {
    //     user_id: userData.id,
    //     company_name: this.company_name,
    //     company_address: this.company_address,
    //     company_city: this.company_city,
    //     company_state: this.company_state,
    //     company_zip: this.company_zip,
    //     company_country: this.company_country,
	// 	company_phone_buss: this.company_phone_buss,
	// 	company_mobile_buss:this.company_mobile_buss,
    //     company_phone_fax: this.company_phone_fax,
    //     company_business_email: this.company_business_email,
    //     company_website: this.company_website,
    //     company_join_date: this.company_join_date,
	// 	auth_token: auth_token,
	// 	card_no: this.card_no,
	// 	month: this.month,
	// 	year: this.year,
	// 	cvc: this.cvc,
	// };

	let formData = new FormData();
	formData.append("file", this.stripDocFile, this.stripDocFile);
	formData.append("user_id", userData.id);
	formData.append("company_name", this.company_name);
	formData.append("company_address", this.company_address);
	formData.append("company_city", this.company_city);
	formData.append("company_state", this.company_state);
	formData.append("company_zip", this.company_zip);
	formData.append("company_country", this.company_country);
	formData.append("company_phone_buss", this.company_phone_buss);
	formData.append("company_mobile_buss", this.company_mobile_buss);
	formData.append("company_phone_fax", this.company_phone_fax);
	formData.append("company_business_email", this.company_business_email);
	formData.append("company_website", this.company_website);
	formData.append("company_join_date", this.company_join_date);
	formData.append("auth_token", this.auth_token);
	formData.append("card_no", this.card_no);
	formData.append("month", this.month);
	formData.append("year", this.year);
	formData.append("cvc", this.cvc);

	

      axios
        .post("/api/company_profile", formData)
        .then(({ response }) => {
          this.getUserData();
          this.flash("Company profile updated successfully", "success");
          //console.log(data.user);
        })
        .catch(({ response }) => {
          //console.log(response);
        });
    },
	stripeDocUpload(){
		
		var selectedFile = event.target.files[0];
		this.stripDocFile = selectedFile;
		console.log(this.stripDocFile);

		// let formData = new FormData();
		// formData.append("file", selectedFile, selectedFile.name);
		// axios.post("/api/" + upload_route, formData, {
		// 	headers: {
		// 		"Content-Type": "multipart/form-data"
		// 	}
		// 	}).then(({ data }) => {
		// 		this.getUserData();
		// 		console.log(data);
		// 	}).catch(({ response }) => {
		// 		//console.log(response);
		// 	});
	},
    companyUpload(event) {
      var upload_route = "";
      if (event.target.attributes.id.value == "company_logo") {
        upload_route = "company-file-upload/logo";
      }
      if (event.target.attributes.id.value == "company_film") {
        upload_route = "company-file-upload/other";
      }
      if (event.target.attributes.id.value == "imageUpload") {
        upload_route = "single-file";
      }
      console.log(upload_route);
	  var selectedFile = event.target.files[0];
	  console.log(selectedFile);


      this.url = URL.createObjectURL(selectedFile);
      let formData = new FormData();
      formData.append("file", selectedFile, selectedFile.name);
      axios
        .post("/api/" + upload_route, formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(({ data }) => {
          this.getUserData();
          console.log(data);
        })
        .catch(({ response }) => {
          //console.log(response);
        });
	},
	
    getPayplan() {
      axios.get("/api/get_payplans_detail").then(response => {
        //console.log(response.data.payplans);
        this.payplans = response.data.payplans;
      });
    },
    get_user_subscription() {
      axios
        .get("/api/get_user_subscription")
        .then(data => {
          this.user_subscription = data.data.subscription_details;
          this.user_subscription_payplans =
            data.data.subscription_details.active_plan_detail;
        })
        .catch(function(response) {
         // console.log(response);
        });
    },
    planpay(id) {
	  window.localStorage.setItem("selected_plan_id", id);
	  this.show_pay_plans();
      //this.$router.push("/payment-pay");
    },
    get_user_project_buy_details(){
      axios
        .get("/api/get_user_project_buy_details")
        .then(data => {
		  this.user_project_buy = data.data.user_project_data;
		  this.projectPriceCompleted();
		  this.projectPriceAwaited();
		  this.projectCompletedCount();
        })
        .catch(function(response) {
         // console.log(response);
        });
	},
	geCountryData() {
      axios
        .get("/api/countries")
        .then(function(res) {
			this.countries = res.data.data;
			//console.log("country data print",res.data.data);
			//this.flash(data.data.message, "success");
		  	
        }.bind(this))
        .catch(function(response) {
          console.log("error",response);
        });
	},
	getStateData(event) {
	  let formData = new FormData();
      formData.append("c_id",event.target.value);
      axios
        .post("/api/state",formData)
        .then(function(res) {
			this.states = res.data.data;
			//console.log("state data print",res.data.data);
			//this.flash(data.data.message, "success");
		  	
        }.bind(this))
        .catch(function(response) {
          console.log("error",response);
        });
	},
	getStateDataEdit(c_id,s_id) {
	  let formData = new FormData();
      formData.append("c_id",c_id);
      axios
        .post("/api/state",formData)
        .then(function(res) {
			this.states = res.data.data;
			this.company_state = s_id;
			console.log("state id ===",this.company_state);
			//console.log("state data print",res.data.data);
			//this.flash(data.data.message, "success");
		  	
        }.bind(this))
        .catch(function(response) {
          console.log("error",response);
        });
    },
  },
  mounted() {
	this.geCountryData();
	//this.getStateData(3);
	if(this.$route.params.id =='finance' ){
		$('.inner_nav_Bar li a').removeClass("active");
		$("#finance_nav").addClass("active");
		$("#finance_data").show();
        $("#plan_data").hide();
        $("#my__Account_data").hide();
		$("#biling_data").hide();
		this.chartLoaded = true;
	}
	if(this.$route.params.id =='plan' ){
		$('.inner_nav_Bar li a').removeClass("active");
		$("#plan_nav").addClass("active");
		$("#finance_data").hide();
        $("#plan_data").show();
        $("#my__Account_data").hide();
		$("#biling_data").hide();
		this.chartLoaded = false;
	}


	 $("#finance_nav").click(function(){
        $("#finance_data").show();
        $("#plan_data").hide();
        $("#my__Account_data").hide();
		$("#biling_data").hide();
		this.chartLoaded = true;
		
    }.bind(this));


	
	
    $("#my_account_nav").click(function(){

        $("#my__Account_data").show();
        $("#finance_data").hide();
        $("#plan_data").hide();
		$("#biling_data").hide();
		this.chartLoaded = false;

    }.bind(this));

    $("#plan_nav").click(function(){
        $("#plan_data").show();
        $("#finance_data").hide();
        $("#my__Account_data").hide();
		$("#biling_data").hide();
		this.chartLoaded = false;

	}.bind(this));
	
	$("#biling_nav").click(function(){
        $("#biling_data").show();
        $("#finance_data").hide();
        $("#plan_data").hide();
		$("#my__Account_data").hide();
		this.chartLoaded = false;
		
    }.bind(this));



    this.get_user_subscription();
    this.getPayplan();
    let cory = document.createElement("script");
    cory.setAttribute("src", "assets/external_js/cory.js");
	document.head.appendChild(cory);
	
  },
  created() {
	this.getUserData();
    this.get_user_project_buy_details();
  },
  beforeMount() {}
};
</script>
