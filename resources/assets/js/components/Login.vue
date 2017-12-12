<template>

    <div>
        <h1>Login to Anaxi</h1>
        <form v-on:submit.prevent="onSubmit">
            <input v-model="email" placeholder="Email" type="email" />
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
            password: ''
        }
    },
    methods: {
        onSubmit: function(){
            //data from inputs -- this.email and this.password
            console.log(this.email + " " +  this.password);
        }
    }
}
</script>

<style lang="css">
</style>
