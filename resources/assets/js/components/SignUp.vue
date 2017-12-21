<template>
  <div id="signupContainer">
      <div v-bind:class="{ fadein: this.signupSuccessful }">Thank you! Please login</div>
      <form v-on:submit.prevent="onSubmit" v-bind:class="{ fadeout : this.signupSuccessful }">
          <input v-model="email" placeholder="Email" type="email" />
          <input v-model="firstName" placeholder="First Name" type="text" />
          <input v-model="lastName" placeholder="Last Name" type="text" />
          <input v-model="password" placeholder="Password" type="password" />
          <input type="submit" name="submit" value="Sign Up">
      </form>

  </div>
</template>

<script>
export default {

    data: function(){
        return{
          email: '',
          firstName: '',
          lastName: '',
          password: '',
          signupSuccessful: false
        }
    },
    methods: {
        onSubmit: function(){
            let self = this;
            axios.post('/createuser', this.$data)
              .then(function (response) {
                console.log(response);
                self.signupSuccessful = true
              })
              .catch(function (error) {
                console.log(error);
              });
        }
    }


}
</script>
