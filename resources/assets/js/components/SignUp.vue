<template>
  <div>
      <h1>Sign Up for Anaxi</h1>
      <form v-on:submit.prevent="onSubmit">
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
          password: ''
        }
    },
    methods: {
        onSubmit: function(){
            //data from inputs -- this.email, this.firstName, this.lastName and this.password
            console.log(this.firstName + " " +  this.lastName);
            axios.post('/createuser', this.$data)
              .then(function (response) {
                console.log(response);
              })
              .catch(function (error) {
                console.log(error.response.data);
              });
        }
    }


}
</script>
