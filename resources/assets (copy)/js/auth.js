class Auth {
    constructor() {

        let userToken = window.localStorage.getItem('token');
        let userData = window.localStorage.getItem('user');
        if (typeof userToken !== 'undefined' || typeof userData !== 'undefined') {
            this.user = userData;
            this.token = userToken;
        } else {
            this.user = null;
            this.token = null;
        }
        if (this.token !== null && this.token !== 'undefined') {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
            
		} else {
			this.authenticated = false;
			this.logout();
		}
		
	}

    login(token, user) {
        window.localStorage.setItem('token', token);
        window.localStorage.setItem('user', JSON.stringify(user));
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        this.token = token;
        this.user = user;

        Event.$emit('userLoggedIn');
    }

    check() {
		
        return !!this.token;
    }

    getUser() {
    axios.get('/api/get-user')
        .then(({user}) => {
            this.user = user;
        })
        .catch(({response}) => {
            if (response.status === 401) {
            }
        });
	}
	
	
	
	logout(token, user) {
		window.localStorage.setItem('token', token);
        window.localStorage.setItem('user', JSON.stringify(user));
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        this.token = token;
        this.user = user;
       // Event.$emit('userLoggedOut');

    }
}

export default Auth;