<template>
    <div class="">
        <createLocation
        v-if="showCreate"
        @showRecommend="showRecommend = true"
        @closeLocation="showCreate = false"
        @closeModal="showCreate = false, modalOpen = false"
        ></createLocation>
        <createRecommend
        v-if="showRecommend"
        @closeRecommend="showRecommend = false"
        @showLocation="showCreate = true"
        @showExtra="showExtra = true"
        @closeModal="showRecommend = false, modalOpen = false"
        ></createRecommend>
        <createExtra
        v-if="showExtra"
        @showRecommend="showRecommend = true"
        @showTrip="showTrip = true"
        @closeExtra="showExtra = false"
        @closeModal="showExtra = false, modalOpen = false"
        ></createExtra>
        <createTrip
        v-if="showTrip"
        @closeTrip="showTrip = false, modalOpen = false"
        ></createTrip>
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
                    <div class="anaxi-primary-btn" id="postBtn" v-on:click="showCreate = true, modalOpen = true"><p>Post</p></div>
                    <i class="ion-android-globe"></i>
                    <router-link :to="{ name: 'profile', params: { id: userid }}">
                        <div class="profile-btn-content">
                            <p class="profile-name">{{userName}}</p>
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
import createRecommend from './CreateRecommend.vue';
import createExtra from './CreateExtra.vue';
import createTrip from './CreateTrip.vue';

export default {

  props: ['userid'],
  data: function(){
        return{
            showCreate: false,
            showRecommend: false,
            showExtra: false,
            showTrip: false,
            isActive: false,
            userName: '',
            modalOpen: false,
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
        createRecommend,
        createExtra,
        createTrip
    },


    mounted() {
      let self = this;
      axios.post('/getuserbyid', {'userID':self.userid})
        .then(function (response) {
          self.userName = response.data[0].firstName;
          self.$root.store.user.fullName = response.data[0].firstName + " " + response.data[0].lastName;
        })
        .catch(function (error) {
          console.log(error);
        })
  },
  watch: {
      modalOpen: function(newValue){
          let className = "modal-open";
          if (newValue) {
              document.body.classList.add(className);
          } else {
              document.body.classList.remove(className);
          }
      }
  }
}
</script>
