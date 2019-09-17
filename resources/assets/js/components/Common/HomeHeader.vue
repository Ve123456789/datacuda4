<template>
    <div>
        <header class="HomepageHeader inner_header top_header homepage_header">
            <div class="container clearfix">
                <div class="header_content">
                    <a href="" class="logo" router-link to="/"><router-link to="/"><img src="/assets/img/white-logo.png" alt="Logo" class="white_logo"><img src="/assets/img/color-logo.png" class="color_logo" alt="Logo"></router-link></a>

                    <ul v-if="(authenticated && user) && currentRouteName" class="user_navbar">
                        <li class="userImg"><a href="#"><span v-if="!userData.picture">
                            <img :src="'/assets/img/avatar_header.png'" ></span>
                            <span v-else ><img :src="'/database/' + userData.email + '/' +userData.picture" ></span></a>
                            <!-- <router-link to="/profile">
                                <i class="fa fa-user" aria-hidden="true"></i>  -->
                                  <!-- Hello, {{ userData.username }}  <i class="fa fa-caret-down" aria-hidden="true"></i> -->
                                <!-- </router-link> -->
                            <div class="dropdown-menu">
                                <router-link to="/profile"><a href="#" class="dropdown-item"><i class="fa fa-user" aria-hidden="true"></i>Hello, {{ userData.username }} </a></router-link>

                                <a href="#" class="dropdown-item" @click="logout"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
                            </div>

                        </li>
                        <li v-if="(authenticated && user) && currentRouteName" class="userName">
                            <a>  </a>

                        </li>
                    </ul>

                     <NoticeAlert v-if="(authenticated && user) && currentRouteName"></NoticeAlert>
                    <div class="navBtn" id="navBtn111" >
                        <input id="click" name="exit" type="checkbox" />
                        <label for="click"><span class="burger"></span></label>
                    </div>
                    <nav class="header_navBar">
                        <ul class="inner_nav menu_nav_bar">
                            <!-- <li><router-link to="/">Home</router-link></li> -->
                            <li><router-link to="/about">About</router-link></li>
                           
                            <!--<li v-if="(authenticated && user) && currentRouteName"> <router-link to="/buyproject">Bought Projects</router-link></li>-->
                            <!-- <li v-if="(authenticated && user) && currentRouteName" class="userImg">
                                <router-link to="/profile">
                                <i class="fa fa-user" aria-hidden="true"></i> Hello, {{ userData.username }}
                                </router-link>
                            </li> -->
                            <li  ><router-link to="/Features">Features</router-link></li>
                            <li  ><router-link to="/pricing">Pricing</router-link></li>
                             <li v-if="(authenticated && user) && currentRouteName"> <router-link to="/dashboard">Dashboard</router-link></li>
                            <li v-else @click="show"><a href="javascript:void(0)">Login</a> </li>
                            <!--<li v-else><router-link to="/login">Login</router-link></li>-->
                            <!--<li v-if="(authenticated && user) && currentRouteName"> <a @click="logout">Logout</a> </li>-->
                            <li @click="show_register"><a href="javascript:void(0)">Sign Up</a></li>
                            
                        </ul>
                    </nav>


                </div>
            </div>
        </header>
        <!---->
        <modal name="user_login" height="auto" width= "70%" :scrollable="true" draggable=".window-header">
            <Login/>
        </modal>
        <modal name="user_register" height="auto" width= "70%" :scrollable="true" draggable=".window-header">
            <Register/>
        </modal>
    
    </div>
</template>

<script>
import Login from "../Auth/Login";
import Register from "../Auth/Register";
import NoticeAlert from "../Reusable/NoticeAlert";
// import notificationDetails from '../Common/notificationDetails';

export default {
  components: {
    Login,
    Register,
    NoticeAlert
  },
  data() {
    return {
      authenticated: auth.check(),
      user: auth.user,
      userData: ""
    };
  },
   computed: {
    currentRouteName() {
        return this.$route.name=='shareproject'?false:true;
    }
  },
  mounted() {
    Event.$on("userLoggedIn", () => {
      this.authenticated = true;
      this.user = auth.user;
    });
    Event.$on("userLoggedOut", () => {
      this.authenticated = false;
      this.user = null;
    });
  },
  created() {
      if(this.authenticated ) {
          axios
              .get("/api/get_user_detail")
              .then(response => {
                  this.userData = response.data.user;
                  //console.log(this.userData);
              })
              .catch(function () {
                  // console.log(this.userData);
              });
      }
  },
  methods: {
    logout() {
      this.authenticated = false;
      this.user = null;
      axios
        .post("/api/logout")
        .then(({ data }) => {
          auth.login(data.token, data.user);
          window.localStorage.clear();
          this.$router.push("/");
        })
        .catch(({ response }) => {
          alert(response.data.message);
        });
    },
    show() {
      this.$modal.show("user_login");
    },
    hide() {
      this.$modal.hide("user_login");
    },
    show_register() {
      this.$modal.show("user_register");
    },
    hide_register() {
      this.$modal.hide("user_register");
    },
    created() {
      this.$Progress.start();
      
    },
  }
};
</script>