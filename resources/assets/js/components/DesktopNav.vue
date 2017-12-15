<template>
    <div class="">
        <createLocation
        v-if="showCreate"
        @showRecommend="showRecommend = true"
        @closeLocation="showCreate = false"
        ></createLocation>
        <createRecommend
        v-if="showRecommend"
        @closeRecommend="showRecommend = false"
        @showLocation="showCreate = true" 
        ></createRecommend>
        <nav class="anaxi-nav">
            <div class="anaxi-nav-content">
                <router-link to="/" exact>
                    <div class="logo">
                        <p>
                            Anaxi
                        </p>
                    </div>
                </router-link>
                <div class="anaxi-nav-content-btns">
                    <div class="anaxi-primary-btn" id="postBtn" v-on:click="showCreate = true"><p>Post</p></div>
                    <i class="ion-android-globe"></i>
                    <router-link to="/profile" >
                        <div class="profile-btn-content">
                            <p class="profile-name">Anders</p>
                            <div class="profile-avatar"></div>
                        </div>
                    </router-link>
                    <div class="profile-arrow" v-on:click="toggleDropdown"></div>
                    <div v-bind:class="{ active: isActive }" class="profile-dropdown">
                        <span v-on:click="logoutUser">Logout</span>
                    </div>
                </div>
            </div>
        </nav>
    </div>

</template>

<script>

import createLocation from './CreateLocation.vue';
import createRecommend from './createRecommend.vue';

export default {

    data: function(){
        return{
            showCreate: false,
            showRecommend: true,
            isActive: false
        }
    },
    methods: {
      toggleDropdown: function () {
        this.isActive = !this.isActive;
        },
      logoutUser: function () {
        axios.post('/logout')
          .then(function (response) {
            console.log(response);
            location.reload();
          })
          .catch(function (error) {
            console.log(error.response.data);
          })
      }
    },


    components: {
        createLocation,
        createRecommend
    },


    mounted() {
      console.log('Desktop Nav mounted.')
  }
}
</script>
