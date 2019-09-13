<template>
    <div>
        <header class="inner_header top_header homepage_header">
            <div class="container clearfix">
                <div class="header_content">
                    <a href="" class="logo" router-link to="/"><router-link to="/"><img src="/assets/img/white-logo.png" alt="Logo"></router-link></a>
                  
                    <ul v-if="authenticated && user" class="user_navbar">
                        <li class="userImg"><a href="#"><span v-if="!userData.picture">
                            <img :src="'/assets/img/avatar_header.png'" ></span>
                            <span v-else ><img :src="'/database/' + userData.email + '/' +userData.picture" ></span></a>
                            <!-- <router-link to="/profile">
                                <i class="fa fa-user" aria-hidden="true"></i>  -->
                                  <!-- Hello, {{ userData.username }}  <i class="fa fa-caret-down" aria-hidden="true"></i> -->
                                <!-- </router-link> -->
                            <!-- <div class="dropdown-menu">
                                <a href="javascript:void(0)" class="dropdown-item disable"><i class="fa fa-user" aria-hidden="true"></i>Hello, {{ userData.email }} </a>
                                <router-link to="/profile"><a href="#" class="dropdown-item"><i class="fa fa-user" aria-hidden="true"></i>My Account</a></router-link>
                                <router-link to="/profile"><a href="#" class="dropdown-item"><i class="fa fa-money" aria-hidden="true"></i>Finance</a></router-link>
                                
                              
                                <a href="#" class="dropdown-item" @click="logout"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
                                <router-link to="/profile"><a href="#" class="dropdown-item btn green_btn"><i class="fa fa-level-up" aria-hidden="true"></i>Upgrade Plan</a></router-link>
                            </div> -->
                            <div class="dropdown-menu custom-nav">
                                <a href="javascript:void(0)" class="dropdown-item with-bottom-border pl-0 no_hover plain-text"  ><strong>Login</strong><br>{{ userData.email }} </a>
                                
                                <router-link to="/profile"><a  class="dropdown-item mb-2 pl-0   no_hover">My Account</a></router-link>
                                <router-link to="/profile/finance"><a  class="dropdown-item mb-2  pl-0 no_hover" ></i>Finance</a></router-link>
                                
                              
                                <a href="#" class="dropdown-item mb-2  pl-0 no_hover" @click="logout">Logout</a>
                                <!-- <router-link to="/profile"><a href="#" class="dropdown-item blue_btn blue-btn-white-text mt-2">Upgrade Plan</a></router-link> -->
                                 <router-link to="/profile"><a href="#" class="dropdown-item green_btn btn py-3 mt-2">Upgrade Plan</a></router-link>
                            </div>

                        </li>
                        <li v-if="authenticated && user" class="userName">
                            <a>  </a>

                        </li>
                    </ul> 

                     <NoticeAlert v-if="authenticated && user"></NoticeAlert>
                    <div class="navBtn">
                        <input id="click" name="exit" type="checkbox" />
                        <label for="click"><span class="burger"></span></label>
                    </div>
                    <nav class="header_navBar">
                        <ul class="inner_nav menu_nav_bar">
                            <!-- <li v-if="!user" ><router-link to="/">Home</router-link></li> -->
                            <li v-if="!user" ><router-link to="/about">About</router-link></li>
                            <li v-if="!user" ><router-link to="/Features">Features</router-link></li>
                            <li v-if="!user" ><router-link to="/pricing">Pricing</router-link></li>
                            <li v-if="user"> <router-link to="/dashboard">Dashboard</router-link></li>
                            <!--<li v-if="authenticated && user"> <router-link to="/buyproject">Bought Projects</router-link></li>-->
                            <!-- <li v-if="authenticated && user" class="userImg"> 
                                <router-link to="/profile">
                                <i class="fa fa-user" aria-hidden="true"></i> Hello, {{ userData.username }}
                                </router-link>
                            </li> -->
                            <li v-else @click="show"><a href="javascript:void(0)">Login</a> </li>
                            <!--<li v-else><router-link to="/login">Login</router-link></li>-->
                            <!--<li v-if="authenticated && user"> <a @click="logout">Logout</a> </li>-->
                            <li v-if="!user" @click="show_register"><a href="javascript:void(0)">Sign Up</a></li>
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

  mounted() {
    Event.$on("userLoggedIn", () => {
      this.authenticated = true;
      this.user = auth.user;
    });
    Event.$on("userLoggedOut", () => {
      this.authenticated = false;
      this.user = false;
    });
  },
  created() {
    axios
      .get("/api/get_user_detail")
      .then(response => {
        this.userData = response.data.user;
       // console.log(this.userData);
      })
      .catch(function() {
       // console.log(this.userData);
      });
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