<template>

    <div id="loginContainer">
        <form v-on:submit.prevent="onSubmit">
            <input v-model="email" placeholder="Email" type="email" />
            <input v-model="password" placeholder="Password" type="password" />
            <input type="submit" name="submit" value="Log in">
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
            error: ''
        }
    },
    methods: {
        onSubmit: function(){
          self = this;
          //data from inputs -- this.email and this.password
           axios.post('/login', this.$data)
            .then(function (response) {
              console.log(response);
              location.reload();
              if (response.data.status < 400){

              }
            })
            .catch(function (error) {
              self.error = error.response.data.responseMessage
            });
        }
    }
}
</script>

<style lang="css">
</style>
