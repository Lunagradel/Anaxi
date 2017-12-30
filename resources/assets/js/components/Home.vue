<template>
    <div class="flexthis">
        <h2>I AM HOME HONEY</h2>
    </div>
</template>

<script>

    import Experience from './Experience.vue';
    import Trip from './Trip.vue';

    export default {
        components: {
            Experience,
            Trip
        },
        mounted: function () {

        },
      data: function () {
        return {
          following: []
        }
      },
      computed: {
        userId() {
          let self = this;
          return self.$root.store.user.id;
        }
      },
      watch: {
          userId: function () {
            let self = this;
            axios.post('/getuserexperiences', {'userId':self.userId})
              .then(function (response) {
                response.data[0].following.forEach(function (followed) {
                  self.following.push(followed._id);
                });
              })
          },
        following: function () {
          let self = this;
          axios.post('/getfollowingfeed', {'following':self.following})
            .then(function (response) {
              console.log(response);
            })
        }
      }
    }
</script>

<style lang="css">

    .flexthis {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 20px;
    }
</style>
