<template>

    <div id="loginContainer">
        <form v-on:submit.prevent="onSubmit">
            <input v-model="email" placeholder="Email" type="email" />
            <input v-model="password" placeholder="Password" type="password" />
            <input type="submit" name="submit" value="Log in">
        </form>
    </div>

</template>

<script>
export default {
    data: function(){
        return{
            email: '',
            password: ''
        }
    },
    methods: {
        onSubmit: function(){

          //data from inputs -- this.email and this.password
           axios.post('/login', this.$data)
            .then(function (response) {
              console.log(response);
              if (response.data.loggedIn){
                location.reload();
              }
            })
            .catch(function (error) {
              console.log(error.response.data);
            });
        }
    }
}
</script>

<style lang="css">
</style>
