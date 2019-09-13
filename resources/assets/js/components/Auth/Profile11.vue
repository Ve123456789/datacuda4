<template>
	<div class="container clearfix">
		
		<ul class="inner_nav_Bar">
			<li><a href="javascript:void(0)" class="active" id="my_account_nav"> My Account</a></li>
			<li><a href="javascript:void(0)" id="finance_nav" >Finance</a></li>
			<li><a href="javascript:void(0)" id="plan_nav">Plans</a></li>
			<li><a href="javascript:void(0)" id="biling_nav">Subscriptions / Biling</a></li>
		</ul>
		<div class="my_Account" style="display: block;" id="my__Account_data">
			<div class="account_wrapper white_bg clearfix">
				<ul class="profile_nav">
					<li><a href="javascript:void(0)" class="active" id="my_profile">My Profile</a></li>
					<li><a href="javascript:void(0)" id="company_profile">Company Profile</a></li>
				</ul>
				<div class="account_content" style="display: block;" id="profile_data">
					<div class="row">
						<div class="col-md-6">
							<div class="account_profile">
								<div class="avatar-upload">
									<div class="avatar-edit">
										<input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" ref="file" v-on:change="companyUpload"/>
										<label for="imageUpload">Choose photo</label>

									</div>
									<div class="avatar-preview">
										<div id="imagePreview" :style="{ backgroundImage: 'url(' + imageLink + ')' }">
										</div>
									</div>
								</div>
								<form class="project_amount_input">
									<div class="form-group">
										<label class="account_lable">Project</label>
										<input type="text" class="form-control" placeholder="20">
									</div>
									<div class="form-group">
										<label class="account_lable">Amount</label>
										<label class="account_lable">Amount</label>
										<input type="text" class="form-control" placeholder="$150">
									</div>
								</form>
							</div>
						</div>
						<div class="col-md-6">
							<form class="account_form clearfix" id="user_detail_form" @submit.prevent="edit_save_profile">
								<label class="account_lable">Name *</label>
								<div class="row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<input type="text" class="form-control" name="Full Name" v-model="full_name" v-validate="'required|alpha_num'">
											<span class="error" v-if="errors.has('Full Name')">{{errors.first('Full Name')}}</span>
										</div>
									</div>
								</div>
								<label class="account_lable">Phone *</label>
								<div class="row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<input type="text" class="form-control" name="Phone" v-model="phone"  v-validate="'required|digits:10'">
											<span class="error" v-if="errors.has('Phone')">{{errors.first('Phone')}}</span>
										</div>
									</div>
								</div>

								<label class="account_lable">Address *</label>
								<div class="row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<textarea name="Address" class="form-control" id="address" cols="30" rows="10" v-model="address"  v-validate="'required'" ></textarea>
											<span class="error" v-if="errors.has('Address')">{{errors.first('Address')}}</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="account_lable">Email</label>
									<input type="text" class="form-control" name="Email" v-model="email"  v-validate="'required|email'" >
									<span class="error" v-if="errors.has('Email')">{{errors.first('Email')}}</span>
									<span class="tool_tip">Change email</span>
								</div>
								<div class="form-group">
									<label class="account_lable">Password</label>
									<input type="Password" class="form-control" v-model="password"  data-vv-name="newPassword" v-validate="'required'" >
									<span class="error" v-if="errors.has('Password')">{{errors.first('Password')}}</span>
									<span class="tool_tip">Change password</span>
								</div>
								<button type="submit" class="btn green_btn">Save</button>
							</form>
						</div>
					</div>
				</div>
				<div class="company_wrapper" id="company_data">
					<div class="row">
						<div class="col-md-8">
							<form class="company_profile_form" id="company_detail_form" @submit.prevent="edit_save_company_profile">
								<div class="form-group">
									<label>Company name</label>
									<input type="text" class="form-control" placeholder="Company name" name="Company Name" v-model="company_name"  v-validate="'required|alpha_num'" >
									<span class="error" v-if="errors.has('Company Name')">{{errors.first('Company Name')}}</span>
								</div>
								<div class="address_ form-group">
									<label>Address</label>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Address"  name="Company Address" v-model="company_address"  v-validate="'alpha_num'" >
										<span class="error" v-if="errors.has('Company Address')">{{errors.first('Company Address')}}</span>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="City"  name="Company City" v-model="company_city"  v-validate="'alpha_num'" >
												<span class="error" v-if="errors.has('Company City')">{{errors.first('Company City')}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="State"  name="Company State" v-model="company_state"  v-validate="'alpha_num'" >
												<span class="error" v-if="errors.has('Company State')">{{errors.first('Company State')}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Zip" name="Zip Code" v-model="company_zip"  v-validate="'alpha_num'" >
												<span class="error" v-if="errors.has('Zip Code')">{{errors.first('Zip Code')}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Country" name="Country Name" v-model="company_country"   v-validate="'alpha_num'" >
												<span class="error" v-if="errors.has('Country Name')">{{errors.first('Country Name')}}</span>
											</div>
										</div>
									</div>
								</div>
								<div class="phone_ form-group">
									<label>Phone</label>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Mobile" name="Phone Number" v-model="company_phone_buss"  v-validate="'numeric'" >
												<span class="error" v-if="errors.has('Phone Number')">{{errors.first('Phone Number')}}</span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Fax" name="Fax Number" v-model="company_phone_fax"  v-validate="'numeric'" >
												<span class="error" v-if="errors.has('Fax Number')">{{errors.first('Fax Number')}}</span>
											</div>
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
									<input type="text" class="form-control" placeholder="URL address" name="Website" v-model="company_website"  v-validate="'url:require_protocol'" >
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
										<label>Date format</label>
										<input type="text" class="form-control datepicker-here" placeholder="MM/DD/YYYY" data-language='en' v-model="company_join_date" />
									</div>
								</div>
								<div class="form-group">
									<button type="submit" class="save_btn1 btn green_btn">Save</button>
								</div>
							</form>
						</div>
						<div class="col-md-4">
							<form class="company_profile_form clearfix">
								<div class="form-group">
									<label>Upload logo</label>
									<section class="sec sec-select" id="fileDrag">
										<img src="/assets/img/upload.svg" class="uploa_d_icon">
										<h3>Drag & Drop</h3>or
										<input type="file" id="company_logo" accept=".png, .jpg, .jpeg" ref="file" v-on:change="companyUpload"/>
										<label class="btn_browse" for="company_logo"> Browse Files</label>
									</section>
								</div>
								<img v-bind:src="company_logo" width="100px" height="100px">
								<div class="form-group">
									<label>Upload film/image release</label>
									<section class="sec sec-select" id="fileDrag2">
										<img src="/assets/img/upload.svg" class="uploa_d_icon">
										<h3>Drag & Drop</h3>or
										<input type="file" id="company_film" accept=".png, .jpg, .jpeg" ref="file" v-on:change="companyUpload"/>
										<label class="btn_browse" for="company_film"> Browse Files</label>
									</section>
								</div>
								<img v-bind:src="company_film" width="100px" height="100px">
							</form>
						</div>
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
				<div class="col-lg-3 col-md-3 col-sm-6 col-12" v-for="payplan in payplans" v-bind:key="payplan.id" >
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
			<div class="payment_content_data">
				<div class="payment_data_heading">
					<h3>Transactions</h3>
				</div>
				<table class="table table_responsive">
					<thead>
					<tr>
						<th scope="col">Customer</th>
						<th scope="col">Project name</th>
						<th scope="col">Total Purchased</th>
						<th scope="col">Amount</th>
						<th scope="col">Status</th>
						<!--<th scope="col">Description</th>-->
						<th scope="col">Action</th>
					</tr>
					</thead>
					<tbody>
					<tr v-for="user_project in user_project_buy " v-bind:key="user_project.user_detail.id">
						<th>{{ user_project.user_detail.username  }}</th>
						<td>{{ user_project.project_name  }}</td>
						<td>{{ user_project.purchase_details  }}</td>
						<td>{{ user_project.project_price  }}</td>
						<!--<td>Nature picture</td>-->
						<td class="text-success" v-if="user_project.purchase_details >= 1">Payed</td>
						<td class="text-danger" v-else>Payment Awaited</td>

						<td><a href="#" class="btn default_btn">Withdrawal</a></td>
					</tr>
					</tbody>
				</table>
			</div>
			<div class="payment_content_data">
				<div class="payment_data_heading">
					<h3>Payments & Revenue</h3>
					<GChart
						type="LineChart"
						:data="chartData"
						:options="chartOptions"
					/>
				</div>
			</div>
			<div class="payment_content_data">
				<div class="payment_data_heading">
					<h3>Total Stats</h3>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="project_content_data">
							<h4>All PROJECTS</h4>
							<div class="clearfix">

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="finance_wrapper" id="biling_data">
			<ul class="profile_nav">
				<li><a href="#" class="active">Subscription </a></li>
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
import { GChart } from 'vue-google-charts'

export default {
  components: {
	Pay,
	GChart
  },
  data() {
    let userData = JSON.parse(window.localStorage.getItem("user"));
    return {
		chartData: [
        ['Year', 'Sales'],
        ['2014', 1000],
        ['2015', 1170],
        ['2016', 660],
        ['2016', 1800],
        ['2016', 300],
        ['2017', 1030]
      ],
      chartOptions: {
        chart: {
          title: 'Company Performance',
          subtitle: 'Sales: 2014-2017',
        }
	  },
	  
      imageLink: "/database/" +userData.email + '/'+ userData.picture,
      email: userData.email ? userData.email : "",
      password: userData.password ? userData.password : "",
      full_name: userData.user_profile.full_name
        ? userData.user_profile.full_name
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
      company_join_date: userData.company_profile.company_join_date
        ? userData.company_profile.company_join_date
        : " ",
      payplans: "",
      user_subscription: "",
      user_subscription_payplans: "",
      user_project_buy: "",
        message: '',
    };
  },
  methods: {
	   show_pay_plans() {
      this.$modal.show("plan_buy");
    },
    getUserData() {
      axios
        .get("/api/get_user_detail")
        .then(function(data) {
          this.flash(data.data.message, "success");
          window.localStorage.setItem("user", JSON.stringify(data.data.user));
        })
        .catch(function(response) {
          //console.log(response);
        });
    },
    edit_save_profile() {
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
        full_name: this.full_name,
        address: this.address,
        logo: this.logo,
        phone: this.phone,
        auth_token: auth_token
      };
      axios
        .post("/api/user_profile", data)
        .then(({ response }) => {
          this.getUserData();
          this.flash(response.data.message, "success");
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
      let auth_token = window.localStorage.getItem("token");
      let userData = JSON.parse(window.localStorage.getItem("user"));
      let data = {
        user_id: userData.id,
        company_name: this.company_name,
        company_address: this.company_address,
        company_city: this.company_city,
        company_state: this.company_state,
        company_zip: this.company_zip,
        company_country: this.company_country,
        company_phone_buss: this.company_phone_buss,
        company_phone_fax: this.company_phone_fax,
        company_business_email: this.company_business_email,
        company_website: this.company_website,
        company_join_date: this.company_join_date,
        auth_token: auth_token
      };
      axios
        .post("/api/company_profile", data)
        .then(({ response }) => {
          this.getUserData();
          this.flash(response.data.message, "success");
          //console.log(data.user);
        })
        .catch(({ response }) => {
          //console.log(response);
        });
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
      //console.log(upload_route);
      var selectedFile = event.target.files[0];
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
          //console.log(data;
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
    //   this.$router.push("/payment-pay");
    },
    get_user_project_buy_details() {
      axios
        .get("/api/get_user_project_buy_details")
        .then(data => {
          this.user_project_buy = data.data.user_project_data;
        })
        .catch(function(response) {
         // console.log(response);
        });
    }
  },
  mounted() {
    this.get_user_subscription();
    this.getPayplan();
    let cory = document.createElement("script");
    cory.setAttribute("src", "assets/external_js/cory.js");
    document.head.appendChild(cory);
  },
  created() {
    this.get_user_project_buy_details();
  },
  beforeMount() {}
};
</script>
