<template>
    <div>
    <div class="inner_banner about" v-if="top.aboutus_image" v-bind:style="{background:'url(/images/'+top.aboutus_image+')'}" >
			<div class="container">
				<div class="inner_banner_content">
					<h2>About us</h2>
				</div>
			</div>
		</div>
		<!-- About Content -->
		<section class="about_content_wrapper">
			<div class="container">
				<h2 class="title_heading">{{ top.aboutus_heading }}</h2>
				
				<div class="services_content_wrapper row clearfix"  >
					<div class="col-lg-12 col-md-12 col-sm-12" v-html="top.aboutus_content" ></div>
					<!-- <div class="col-lg-6 col-md-6 col-sm-12">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem</p>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem</p>
					</div> -->
				</div>
			</div>
		</section>
		<!-- SERVICE CONTENT -->
		<section class="service_content_wrapper grey_bg">
			<div class="container">
				<div class="row">

					<div class="col-lg-4 col-md-4 col-sm-12" v-for="bottom in bottoms" v-bind:key="bottom.aboutus_id" >
						<div class="service_content">
							<div class="service_icon"><img :src="'/images/'+bottom.aboutus_image"  ></div>
							<h4>{{ bottom.aboutus_heading }}</h4>
							<p v-html="bottom.aboutus_content" > </p>
						</div>
					</div>

					<!-- <div class="col-lg-4 col-md-4 col-sm-12">
						<div class="service_content">
							<div class="service_icon"><img src="/assets/img/service_icon_2.png"></div>
							<h4>Lorem ipsum dolor</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis</p>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-12">
						<div class="service_content">
							<div class="service_icon"><img src="/assets/img/service_icon_3.png"></div>
							<h4>Lorem ipsum dolor</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis</p>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-12">
						<div class="service_content">
							<div class="service_icon"><img src="/assets/img/service_icon_4.png"></div>
							<h4>Lorem ipsum dolor</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis</p>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-12">
						<div class="service_content">
							<div class="service_icon"><img src="/assets/img/service_icon_5.png"></div>
							<h4>Lorem ipsum dolor</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis</p>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-12">
						<div class="service_content">
							<div class="service_icon"><img src="/assets/img/service_icon_6.png"></div>
							<h4>Lorem ipsum dolor</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis</p>
						</div>
					</div> -->
				</div>
			</div>
		</section>
		<!-- Mission Goal -->
		<section class="mission_and_goal">
			<div class="container-fluid">
				<div class="row">
					<div class="mission_wrapper left_wrapper_c col-lg-6">
						<div class="sec_wrapper_content">
							<h2>{{ left.aboutus_heading }}</h2>
							<p v-html="left.aboutus_content" ></p>
						</div>
					</div>
					<div class="goal_wrapper right_wrapper_c col-lg-6">
						<div class="sec_wrapper_content">
							
							<h2>{{ right.aboutus_heading }}</h2>
							<p v-html="right.aboutus_content" ></p>
						</div>
					</div>
				</div>
			</div>
		</section>



    </div>
</template>

<script>
export default {
	data(){
		return{
			top:{},
			bottoms:[],
			right:{},
			left:{} 
		}			
	},
	created(){
			this.aboutTop();
			this.aboutBottom();
			this.aboutRight();
			this.aboutLeft();
	},
	methods : {
		aboutTop(){
			axios
            .get('/api/aboutustop')
            .then(result =>{
                this.top = result.data.response;
            })
		},
		aboutBottom(){
			axios
            .get('/api/aboutusbottom')
            .then(result =>{
                this.bottoms = result.data.response;
               // console.log(this.top);
            })
		},
		aboutRight(){
			axios
            .get('/api/aboutusright')
            .then(result =>{
                this.right = result.data.response;
                //console.log(this.top);
            })
		},
		aboutLeft(){
			axios
            .get('/api/aboutusleft')
            .then(result =>{
                this.left = result.data.response;
                //console.log(this.top);
            })
		}
	}

}
</script>