<template>

    <div id="loginContainer">
        <form v-on:submit.prevent="onSubmit">
            <input v-model="email" placeholder="Email" type="email" />
            <input v-model="password" placeholder="Password" type="password" />
            <input type="submit" name="submit" value="Log in" class="anaxi-primary-btn logSignBtn" v-bind:class="{ disabled: buttonDisabled }">
        </form>
        <span class="error-msg" v-bind:class="{ active: error }">{{error}}</span>
    </div>

</template>

<script>
export default {
    data: function(){
        return{
            email: '',
            password: '',
            error: '',
          buttonDisabled: false
        }
    },
    methods: {
        onSubmit: function(){
          self = this;
          if (self.buttonDisabled){ console.log("Disabled"); return false;}
          self.buttonDisabled = true;
          //data from inputs -- this.email and this.password
           axios.post('/login', this.$data)
            .then(function (response) {
              location.reload();
              self.buttonDisabled = false;
            })
            .catch(function (error) {
              self.error = error.response.data.responseMessage
              self.buttonDisabled = false;
            });
        }
    }
}
</script>

<style lang="css">
</style>
