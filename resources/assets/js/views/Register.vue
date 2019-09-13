<template>
    <div>
        <h1>Register with us</h1>
        <p>
            <label for="name">Name</label>

            <input type="text" name="name" v-model="name">
        </p>
        <p>
            <label for="email">Email</label>

            <input type="text" name="email" v-model="email">
        </p>


        <p>
            <label for="password">Password</label>

            <input type="password" name="password" v-model="password">
        </p>
        <p>
            <label for="c_password">Confirm Password</label>

            <input type="password" name="c_password" v-model="c_password">
        </p>

        <button @click="register">Resgister</button>
    </div>
</template>

<script>
export default {
  data() {
    return {
      username: '',
      password: '',
    };
  },

  methods: {
    register() {
      let data = {
        name: this.name,
        email: this.email,
        password: this.password,
        c_password: this.c_password,
      };

      axios
        .post('/api/register', data)
        .then(({ data }) => {
          auth.login(data.token, data.user);
          this.$router.push('/dashboard');
        })
        .catch(({ response }) => {
          alert(response.data.message);
        });
    },
  },
};
</script>
