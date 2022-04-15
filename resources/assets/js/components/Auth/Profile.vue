<template>
<div> profile for testing</div>
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
	Pay,
	Chart
  },
  data() {
    let userData = JSON.parse(window.localStorage.getItem("user"));
	var chunks=userData.username.split(/\s+/);
	var	arr = [chunks.shift(), chunks.join(' ')];
    return {
	 userDatapicture : userData.picture,
      imageLink: "/database/" +userData.email + '/'+ userData.picture,
      email: userData.email ? userData.email : "",
      password: userData.password ? userData.password : "",
	  
 
		      first_name: userData.user_profile.first_name != null 
        ? userData.user_profile.first_name
		: arr[0],

		last_name: userData.user_profile.last_name != null
        ? userData.user_profile.last_name
		: arr[1],
		dob:userData.user_profile.dob
		? userData.user_profile.dob:'',
		
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
		b_first_name:userData.banking_profile && userData.banking_profile.first_name ? userData.banking_profile.first_name : "",
		b_last_name:userData.banking_profile && userData.banking_profile.last_name ? userData.banking_profile.last_name : "",
		b_phone:userData.banking_profile && userData.banking_profile.phone ? userData.banking_profile.phone : "",
		b_email:userData.banking_profile && userData.banking_profile.email ? userData.banking_profile.email : "",
		b_dob:userData.banking_profile && userData.banking_profile.dob ? userData.banking_profile.dob : "",
		b_address:userData.banking_profile && userData.banking_profile.address ? userData.banking_profile.address : "",
		b_state:userData.banking_profile && userData.banking_profile.state ? userData.banking_profile.state : "",
		b_city:userData.banking_profile && userData.banking_profile.city ? userData.banking_profile.city : "",
		b_zip:userData.banking_profile && userData.banking_profile.zip ? userData.banking_profile.zip : "",
		card_no:userData.banking_profile && userData.banking_profile.card_no ? userData.banking_profile.card_no : "",
		month:userData.banking_profile && userData.banking_profile.month ? userData.banking_profile.month : "", 
		year:userData.banking_profile && userData.banking_profile.year ? userData.banking_profile.year : "",
		cvc : userData.banking_profile && userData.banking_profile.cvc ? userData.banking_profile.cvc : "",
		ssn:userData.banking_profile && userData.banking_profile.ssn?userData.banking_profile.ssn:"",
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
		cardValidCheck:true,
		expariValidCheck:true,
		cvcValidCheck:true, 
		debitCard_valid:'',
		currentSubscription:null,
		live_data:userData.live_data,
		cancelShow:false,
    };
  },
  methods: {
    	sortCountries(countries ) {
	 // let contriesData = contries.map( a => { return {...a}});
	  if(countries.length>0) {
	  const usaOptionData = countries.filter( country => country.code === "us")[0];
	  let listOptions =[];
	  listOptions.push(usaOptionData);

	  for(let i=0;i<countries.length;i++){
         if(countries[i].code !== "us"){
			 listOptions.push({...countries[i]})
		 }
	  }
     // return contriesData.sort((a, b) => a.name.toLowerCase() > b.name.toLowerCase() ? 1 : -1).reverse();
	 return listOptions;
	  }
	  else {
		  return [];
	  }
	},
  
	cancelSubscription () {
		axios
        	.delete("/api/cancel-subscription")
        	.then(({ response }) => {
          		console.log(response);		  
		  		this.flash(response.data.message, "success");
        	}).catch(({ error }) => {
				this.flash(error.data.message, "error");
        	});
	},
	cancelProcess(){
		console.log('dfdfdfdf');
		this.cancelShow = true;
	},
	paymentWithdraw(project_id){
		console.log("withdraw",project_id);
		let data = { project_id:project_id };
		 axios
        .post("/api/paymentWithdraw", data)
        .then(({ response }) => {
          	console.log(response);		  
		  	this.flash("Amount success fully transfered", "success");
        }).catch(({ response }) => {
			console.log(response);
			this.flash(response.data.message, "error");
        });
	},
	getImg:(id) =>{
		return '/assets/img/plan_icon_'+ id +'.png';
	},
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
	getCurrentSubscriptionPlan() {
		axios
        .post("/api/current-subscription-plan")
        .then(function(res) {
		  	this.currentSubscription = res.data.data;
        }.bind(this))
        .catch(function(response) {
          console.log("error",response);
        });
	},
    getUserData() {
      axios
        .get("/api/get_user_detail")
        .then(function(data) {
			console.log("user data print",data.data.user);
			window.localStorage.setItem("user", JSON.stringify(data.data.user));
			let userData1 = data.data.user;
			this.live_data = userData1.live_data;
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
		password: this.password,
		//dob:this.dob,
		first_name: this.first_name,
		last_name : this.last_name,
        address: this.address,
        logo: this.logo,
        phone: this.phone,
		auth_token: auth_token,
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
	validateCard(){
		var valid = Stripe.card.validateCardNumber(this.card_no);
		if(valid){
			this.cardValidCheck = true;
		}else{
			this.cardValidCheck = false;
		}
		console.log("card No",valid);
		return;
	},
	validateMonth(){
		var valid = Stripe.card.validateExpiry(this.month,this.year);
		if(valid){
			this.expariValidCheck = true;
		}else{
			this.expariValidCheck = false;
		}
		console.log("Expary ",valid);
		return;
	},
	validateYear(){
		var valid = Stripe.card.validateExpiry(this.month,this.year);
		if(valid){
			this.cvcValidCheck = true;
		}else{
			this.cvcValidCheck = false;
		}
		console.log("Expary ",valid);
		return;
	},
	validateCvc(){
		var valid = Stripe.card.validateCVC(this.cvc);
		console.log("pravin kumar",valid);
		return;
	},
    edit_save_company_profile() {

      this.$validator.validateAll();
      if (this.errors.any()){
        return;
	  }
	  	  
      let auth_token = window.localStorage.getItem("token");
      let userData = JSON.parse(window.localStorage.getItem("user"));
    

	let formData = new FormData();
	// if(this.stripDocFile && this.stripDocFile.name){
	// 	formData.append("file", this.stripDocFile, this.stripDocFile.name);
	// }
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
	// formData.append("card_no", this.card_no);
	// formData.append("month", this.month);
	// formData.append("year", this.year);
	// formData.append("cvc", this.cvc);
	// formData.append("ssn",this.ssn);

	

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
	edit_save_banking(){

		this.$validator.validateAll();
		if (this.errors.any()){
			return;
		}
			
		let auth_token = window.localStorage.getItem("token");
		let userData = JSON.parse(window.localStorage.getItem("user"));
				
		let formData = new FormData();
		if(this.stripDocFile && this.stripDocFile.name){
			formData.append("file", this.stripDocFile, this.stripDocFile.name);
		}

		formData.append("user_id", userData.id);
		formData.append("first_name", this.b_first_name);
		formData.append("last_name", this.b_last_name);
		formData.append("phone", this.b_phone);
		formData.append("email", this.b_email);
		formData.append("dob", this.b_dob);
		formData.append("address", this.b_address);
		formData.append("state", this.b_state);
		formData.append("city", this.b_city);
		formData.append("zip", this.b_zip);
		formData.append("auth_token", this.auth_token);
		formData.append("card_no", this.card_no);
		formData.append("month", this.month);
		formData.append("year", this.year);
		formData.append("cvc", this.cvc);
		formData.append("ssn",this.ssn);	

      	axios
        .post("/api/banking_profile", formData)
        .then(({ response }) => {
		  this.getUserData();
		  this.debitCard_valid = '';
		  this.flash("Banking profile updated successfully", "success");
		  
          //console.log(data.user);
        })
        .catch(({ response }) => {
			 
			if(response.data.code == '102'){
				
				this.debitCard_valid = "Only debit card accepted here";
			}
			
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
    //   axios.get("/api/get_payplans_detail").then(response => {
	axios.get("/api/subscription-plans").then(response => {
        //console.log(response.data.payplans);
		// this.payplans = response.data.payplans;
		this.payplans = response.data;
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
		$("#banking_data").hide();
        $("#plan_data").hide();
        $("#my__Account_data").hide();
		$("#biling_data").hide();
		this.chartLoaded = true;
	}
	if(this.$route.params.id =='plan' ){
		$('.inner_nav_Bar li a').removeClass("active");
		$("#plan_nav").addClass("active");
		$("#finance_data").hide();
		$("#banking_data").hide();
        $("#plan_data").show();
        $("#my__Account_data").hide();
		$("#biling_data").hide();
		this.chartLoaded = false;
	}


	$("#finance_nav").click(function(){
        $("#finance_data").show();
		$("#plan_data").hide();
		$("#banking_data").hide();
        $("#my__Account_data").hide();
		$("#biling_data").hide();
		this.chartLoaded = true;
		
    }.bind(this));
	
	
    $("#my_account_nav").click(function(){

        $("#my__Account_data").show();
		$("#finance_data").hide();
		$("#banking_data").hide();
        $("#plan_data").hide();
		$("#biling_data").hide();
		this.chartLoaded = false;

    }.bind(this));

    $("#plan_nav").click(function(){
		$("#plan_data").show();
		$("#banking_data").hide();
        $("#finance_data").hide();
        $("#my__Account_data").hide();
		$("#biling_data").hide();
		this.chartLoaded = false;

	}.bind(this));
	
	$("#biling_nav").click(function(){
		$("#biling_data").show();
		$("#banking_data").hide();
        $("#finance_data").hide();
        $("#plan_data").hide();
		$("#my__Account_data").hide();
		this.chartLoaded = false;
		
	}.bind(this));
	
	$("#banking").click(function(){
        $("#banking_data").show();
        $("#biling_data").hide();
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
	this.getCurrentSubscriptionPlan();
  },
  beforeMount() {}
};
</script>
