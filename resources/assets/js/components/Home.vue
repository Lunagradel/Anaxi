<template>
    <div class="flexthis">
        <div class="anaxi-home-feed" v-if="posts.length">
            <span class="error-msg" v-bind:class="{ active: error }">{{error}}</span>
            <Post v-for="(post, index) in posts" :key="index" v-bind:post="post" v-bind:index="index"></Post>
        </div>
    </div>
</template>

<script>

    import Post from './Post.vue';

    export default {
        components: {
          Post,
        },
        mounted: function () {

        },
      data: function () {
        return {
          following: [],
          posts: [],
          error: '',
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
              self.posts = response.data.feed;
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
