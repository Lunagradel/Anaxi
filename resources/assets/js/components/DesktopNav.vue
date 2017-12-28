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
                <div class="anaxi-nav-content-search-container" v-if="!mobileSize">
                    <div class="anaxi-nav-content-search">
                        <input type="text" v-model="searchInput" placeholder="Search" class="anaxi-search desktop-search">
                        <div class="anaxi-primary-btn search-btn" v-on:click="searchForValue">
                            <i class="ion-ios-search-strong"></i>
                        </div>
                    </div>
                    <div class="anaxi-nav-content-result" v-show="showSearchDropdown">

                        <p v-if="!searchResult">Sorry, nothing was found.</p>
                        <div class="result-items" v-for="(item, index) in searchResultData" :key="index" v-else>
                            <router-link :to="{ name: 'profile', params: { id: item._id.$oid}}" v-on:click.native="searchLinkClicked">
                                <p>{{item.firstName}} {{item.lastName}}</p>
                            </router-link>
                        </div>

                    </div>
                </div>
                <div class="anaxi-nav-content-btns">
                    <div class="anaxi-primary-btn" id="postBtn" v-on:click="showCreate = true, modalOpen = true" v-if="!mobileSize"><p>Post</p></div>
                    <i class="ion-android-globe" v-if="!mobileSize"></i>
                    <router-link :to="{ name: 'profile', params: { id: userid }}" v-if="!mobileSize">
                        <div class="profile-btn-content">
                            <p class="profile-name">{{userName}}</p>
                            <div class="profile-avatar">
                                <img :src="'/img/' + imageUrl" alt="">
                            </div>
                        </div>
                    </router-link>
                    <div class="profile-arrow" v-on:click="toggleDropdown"></div>
                    <div v-bind:class="{ active: isActive }" class="profile-dropdown">
                        <span v-on:click="logoutUser">Logout</span>
                    </div>
                </div>
            </div>
        </nav>
        <MobileNav
        v-if="mobileSize"
        @showCreate="showCreate = true, modalOpen = true"
        ></MobileNav>
    </div>

</template>

<script>

import createLocation from './CreateLocation.vue';
import createRecommend from './CreateRecommend.vue';
import createExtra from './CreateExtra.vue';
import createTrip from './CreateTrip.vue';
import MobileNav from './MobileNav.vue';

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
            windowWidth: 0,
            mobileSize: false,
            imageUrl: 'default.jpg',
            searchInput: '',
            searchResult: false,
            searchResultData: [],
            showSearchDropdown: false
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
      },
      getWindowWidth: function(e){
          this.windowWidth = document.documentElement.clientWidth;
      },
      searchForValue: function(){
          if (this.searchInput === '') {
              //nothing to search for
          } else {
              let self = this;
              axios.post('/searchforvalue', {'searchValue':self.searchInput})
                .then(function (response) {
                    console.log("response from search", response.data);
                    if (response.data.length > 0){
                        self.searchResult = true;
                        self.searchResultData = response.data;
                        self.showSearchDropdown = true;
                    } else {
                        self.searchResult = false;
                        self.searchResultData = [];
                        self.showSearchDropdown = true;
                    }
                })
                .catch(function (error) {
                  console.log(error);
                })
          }
      },
      searchLinkClicked: function(){
          this.searchResult = false;
          this.searchResultData = [];
          this.showSearchDropdown = false;
          this.searchInput = '';
      }
    },

    components: {
        createLocation,
        createRecommend,
        createExtra,
        createTrip,
        MobileNav
    },

    mounted() {
      let self = this;
      axios.post('/getuserbyid', {'userID':self.userid})
        .then(function (response) {
          self.userName = response.data[0].firstName;
          self.$root.store.user.fullName = response.data[0].firstName + " " + response.data[0].lastName;

          if (response.data[0].image) {
              self.imageUrl = response.data[0].image;
          }
        })
        .catch(function (error) {
          console.log(error);
        })


    this.$nextTick(function(){
        window.addEventListener('resize', this.getWindowWidth);

        this.getWindowWidth()
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
      },
      windowWidth: function(newWidth){
          if (newWidth < 736){
              this.mobileSize = true;
          }
          if (newWidth > 736){
              this.mobileSize = false;
          }
      },
      searchInput:function(newValue){
          if (newValue === ""){
              this.searchResult = false;
              this.searchResultData = [];
              this.showSearchDropdown = false;
          }
      }
  },
  beforeDestroy() {
      window.removeEventListener('resize', this.getWindowWidth);
  }
}
</script>
