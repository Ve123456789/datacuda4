<template>
    <div>
        <div>
            <router-link to="/">Home</router-link>
            <router-link to="/about">About</router-link>
            <router-link to="/dashboard">Dashboard</router-link>

            <div v-if="authenticated && user">
    		<p>Hello, {{ user.name }}</p>
				<button @click="logout">Logout</button>
				<router-link to="/profile">Profile</router-link>

			</div>

			<router-link to="/login" v-else>Login</router-link>
            <router-link to="/register">Register</router-link>

        </div>



        <div style="margin-top: 2rem">
            <router-view :key="$route.fullPath" ></router-view>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<script>
export default {
    data() {
        return {
            authenticated: auth.check(),
            user: auth.user
        };
    },

    mounted() {
        console.log("this is vue layout");
          console.info('App currentRoute:', this.$router.currentRoute);

        Event.$on('userLoggedIn', () => {
            this.authenticated = true;
            this.user = auth.user;
        });
        Event.$on('userLoggedOut', () => {
            this.authenticated = false;
            this.user = null;
        });
    },

     methods: {
        logout() {
        	this.authenticated = false;
            this.user = null;
        	axios.post('/api/logout')
    			.then(({data}) => {
        		auth.login(data.token, data.user);
        		this.$router.push('/login');
    		})
    		.catch(({response}) => {
        		alert(response.data.message);
    		});


        }
    }
}
</script>