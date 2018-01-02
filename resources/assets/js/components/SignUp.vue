<template>
  <div id="signupContainer">
      <div v-bind:class="[signupSuccessful ? 'fadein' : 'hidden']">Thank you! Please login</div>
      <form v-on:submit.prevent="onSubmit" v-bind:class="{ fadeout : signupSuccessful }">
          <input v-model="email" placeholder="Email" type="email" />
          <input v-model="firstName" placeholder="First Name" type="text" />
          <input v-model="lastName" placeholder="Last Name" type="text" />
          <input v-model="password" placeholder="Password" type="password" />
          <input type="submit" name="submit" value="Sign Up" class="anaxi-primary-btn logSignBtn" v-bind:class="{ disabled: buttonDisabled }">
      </form>
      <span class="error-msg" v-bind:class="{ active: error }">{{error}}</span>
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
          signupSuccessful: false,
          error: '',
          buttonDisabled: false
        }
    },
    methods: {
        onSubmit: function(){
            let self = this;
            if (self.buttonDisabled){ console.log("Disabled"); return false;}
            self.buttonDisabled = true;
            self.error = '';
            axios.post('/createuser', this.$data)
              .then(function (response) {
                console.log(response);
                self.signupSuccessful = true;
                self.buttonDisabled = false;
              })
              .catch(function (error) {
                self.buttonDisabled = false;
                self.error = error.response.data.responseMessage
              });
        }
    }
}
</script>
