<template>
    <div class="flexthis">
        <Loader v-if="loading"></Loader>
        <span v-if="noFeed" class="Feed message"> Seem like you're not following anyone yet? Try searching for a friend! </span>
        <div class="anaxi-home-feed" v-if="posts.length">
            <span class="error-msg" v-bind:class="{ active: error }">{{error}}</span>
            <Post v-for="(post, index) in posts" :key="index" v-bind:post="post" v-bind:index="index"></Post>
        </div>
    </div>
</template>

<script>

    import Post from './Post.vue';
    import Loader from './Loader.vue'
    export default {
        components: {
          Post,
          Loader
        },
      created () {
        // fetch the data when the view is created and the data is
        // already being observed
        let self = this;
        self.noFeed = false;
        if(this.userId){
          axios.post('/getuserexperiences', {'userId':self.userId})
            .then(function (response) {
              if(response.data[0].following.length){
                  response.data[0].following.forEach(function (followed) {
                    self.following.push(followed._id);
                  });
                  self.following.push(self.userId);
              }else {
                self.loading = false;
                self.noFeed = true;
              }
            })
        }
      },
      data: function () {
        return {
          following: [],
          posts: [],
          error: '',
          loading: true,
          noFeed: false,
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
            self.following.push(self.userId);
            axios.post('/getuserexperiences', {'userId':self.userId})
              .then(function (response) {
                if(response.data[0].following.length){
                  response.data[0].following.forEach(function (followed) {
                    self.following.push(followed._id);
                  });
                }else {
                  self.loading = false;
                  self.noFeed = true;
                }
              })
          },
        following: function () {
          let self = this;
          axios.post('/getfollowingfeed', {'following':self.following})
            .then(function (response) {
              self.posts = response.data.feed;
              self.loading = false;
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
