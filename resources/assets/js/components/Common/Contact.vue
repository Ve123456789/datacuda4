<template>
    <div>
    	<div class="inner_banner about" >
			<div class="container">
				<div class="inner_banner_content">
					<h2>Contact us</h2>
				</div>
			</div>
		</div>
		<!-- Contact Content -->
		<section class="contact_content_wrapper">
			<div class="container">
				
				<h2 class="contact_title_heading">Contact Us</h2>
				<div class="contact_form_wrapper">
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
							    <label>First Name</label>
							    <input type="text" class="form-control" name="First Name" v-model="first"  v-validate="'required'" >
								<span class="error" v-if="errors.has('First Name')">{{errors.first('First Name')}}</span>
						    </div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
							    <label>Last Name</label>
							    <input type="text" class="form-control" name="Last Name" v-model="last"  v-validate="'required'" >
								<span class="error" v-if="errors.has('Last Name')">{{errors.first('Last Name')}}</span>
						    </div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
							    <label>Email address</label>
							    <input type="email" class="form-control" name="Email address" v-model="email"  v-validate="'required|email'" >
								<span class="error" v-if="errors.has('Email address')">{{errors.first('Email address')}}</span>
						    </div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
							    <label>Phone number</label>
							    <input type="text" class="form-control" name="Phone number" v-model="phone"  v-validate="'required|numeric'" >
								<span class="error" v-if="errors.has('Phone number')">{{errors.first('Phone number')}}</span>
						    </div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
							    <label>Organization</label>
							    <input type="text" class="form-control" name="Organization" v-model="organization"  v-validate="'required'" >
								<span class="error" v-if="errors.has('Organization')">{{errors.first('Organization')}}</span>
						    </div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
							    <label>Company size</label>
							    <input type="text" class="form-control" name="Company size" v-model="companysize"  v-validate="'required'" >
								<span class="error" v-if="errors.has('Company size')">{{errors.first('Company size')}}</span>
						    </div>
						</div>
						<div class="col-lg-12 col-md-12">
							<div class="form-group">
							    <label>How we can help you?</label>
							    <textarea class="text_area form-control" rows="5" id="comment" name="How we can help you?" v-model="description"  v-validate="'required'" ></textarea>
								<span class="error" v-if="errors.has('How we can help you?')">{{errors.first('How we can help you?')}}</span>
						    </div>
						</div>
						<div class="col-lg-12 col-md-12 clearfix">
							<button class="green_btn btn pull-right" v-on:click="submit()">Submit</button>
						</div>
					</div>
				</div>
			</div>			
		</section>
		

		<div class="alert alert-success" role="alert" id="success_div" style="display:none;bottom: 29px;width: 508px;">
			Your query is sent to our expert team.
		</div>
</div>


</template>
<style scoped>
	span.error {
		color: #9F3A38;
	}
</style>
<script>
export default {
    data()
	{
	  return{
          first : '',
          last : '',
          email : '',
          phone : '',
          organization : '',
          companysize : '',
          description : '',
	  }
	},
    methods : {
        submit() {
            this.$validator.validateAll()
                .then(result => {
                    if (!result) {
                        return false
                    }
                    if(result)
                    {
                        let data = {
                            first : this.first,
                            last : this.last,
                            email : this.email,
                            phone : this.phone,
                            organization : this.organization,
                            companysize : this.companysize,
                            description : this.description,
                        };
                        axios
                            .post('/api/contact', data)
                            .then(({data}) => {
								var success_div = document.getElementById('success_div');
								success_div.style.display = 'block';

								setTimeout(function() {
									$('#success_div').fadeOut('fast');
								}, 3000);
							})
                            .catch(({response}) => {
                            });
                    }
                });

        }
    }
}

</script>