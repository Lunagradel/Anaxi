<template>
    <div class="anaxi-profile-page">
        <div class="anaxi-profile">
            <div class="anaxi-profile-background anaxi-profile-inner">
                <div class="circle circle-15">
                    <div class="circle circle-14">
                        <div class="circle circle-13">
                            <div class="circle circle-12">
                                <div class="circle circle-11">
                                    <div class="circle circle-10">
                                        <div class="circle circle-9">
                                            <div class="circle circle-8">
                                                <div class="circle circle-7">
                                                    <div class="circle circle-6">
                                                        <div class="circle circle-5">
                                                            <div class="circle circle-4">
                                                                <div class="circle circle-3">
                                                                    <div class="circle circle-2">
                                                                        <div class="circle circle-1">
                                                                            <div class="circle" id="circle">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <div class="anaxi-profile-passport anaxi-profile-inner">
                <div class="anaxi-profile-passport-graphic">
                    <div class="graphic-title">
                        <p>PROFILE PAGE</p>
                        <p>PAGE DE PROFIL</p>
                        <p>PROFILSEITE</p>
                    </div>
                    <div class="graphic-image">

                    </div>
                </div>
                <div class="anaxi-profile-passport-information">
                    <div class="information-left">
                        <div class="information-mobile">
                            <div class="information-item">
                                <p>1. Lastname</p>
                                <p>{{lastName}}</p>
                            </div>
                            <div class="information-item">
                                <p>2. Firstname</p>
                                <p>{{firstName}}</p>
                            </div>
                        </div>
                        <div class="information-item">
                            <p>3. Description</p>
                            <p>{{description}}</p>
                        </div>
                    </div>
                    <div class="information-right">
                        <div class="information-mobile">
                            <div class="information-item">
                                <p>4. Followers</p>
                                <p>{{followersAmount}}</p>
                            </div>
                            <div class="information-item">
                                <p>5. Following</p>
                                <p>{{following.length}}</p>
                            </div>
                        </div>
                        <div class="anaxi-primary-btn" id="profileBtn" v-if="isOwnProfile" v-on:click="showEdit = true">
                            Edit
                        </div>
                        <div class="anaxi-primary-btn" id="profileFollowBtn" v-else-if="!isFollowing" v-on:click="followUser">
                            Follow
                        </div>
                        <div class="anaxi-primary-btn" id="profileFollowBtn" v-else-if="isFollowing" v-on:click="unFollowUser">
                            Unfollow
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="anaxi-profile-map" ref="profileMap">

        </div>
        <div class="anaxi-profile-feed">
            <span class="error-msg" v-bind:class="{ active: error }">{{error}}</span>
            <Experience v-for="(experience, index) in experiences" :key="index" v-bind:experience="experience" v-bind:id="index"></Experience>
            <Trip v-for="(trip, index) in trips" :key="index" v-bind:trip="trip" v-bind:id="index"></Trip>
        </div>
        <EditProfile
        v-if="showEdit"
        @closeEdit="showEdit = false"
        @updateProfileInfo="updateProfileInfo"
        v-bind:userFirstName="firstName"
        v-bind:userLastName="lastName"
        v-bind:userDescription="description"
        ></EditProfile>
    </div>
</template>

<script>
  import Experience from './Experience.vue';
  import Trip from './Trip.vue';
  import EditProfile from './EditProfile.vue';
export default {
  components: {
    Experience,
    EditProfile,
    Trip
  },
  data: function(){
    return {
        followers: [],
        following: [],
        followersAmount: '',
        experiences: [],
        trips: [],
        lastName: '',
        firstName: '',
        description: '',
        showEdit: false,
        isOwnProfile: false,
        isFollowing: false,
        error: ''
    }
  },

  methods: {
      mapInit: function(){

          //Google map
          const bounds = new google.maps.LatLngBounds();
          let mapName = this.$refs.profileMap;
          const mapCenter = this.experiences[0].geolocation;
          let marker;

          const options = {
              center: new google.maps.LatLng(mapCenter.lat, mapCenter.lng),
              zoom: 14,
              mapTypeControl: false,
              streetViewControl: false,
              fullscreenControl: false,
              styles: [
                      {
                          "featureType": "poi",
                          "elementType": "geometry.fill",
                          "stylers": [
                              {
                                  "color": "#5c9a8d"
                              }
                          ]
                      },
                      {
                          "featureType": "road",
                          "elementType": "geometry",
                          "stylers": [
                              {
                                  "lightness": 100
                              },
                              {
                                  "visibility": "simplified"
                              }
                          ]
                      },
                      {
                          "featureType": "road",
                          "elementType": "geometry.fill",
                          "stylers": [
                              {
                                  "color": "#D1D1B8"
                              }
                          ]
                      },
                      {
                          "featureType": "water",
                          "elementType": "geometry",
                          "stylers": [
                              {
                                  "visibility": "on"
                              },
                              {
                                  "color": "#5b7c8d"
                              }
                          ]
                      },
                      {
                          "featureType": "water",
                          "elementType": "labels.text.fill",
                          "stylers": [
                              {
                                  "color": "#ffffff"
                              }
                          ]
                      }
                  ]
          }

          let map = new google.maps.Map(mapName, options);

          //adding markers from the experiences array.
          this.experiences.forEach((item, index)=> {
              const position = new google.maps.LatLng(item.geolocation.lat, item.geolocation.lng);

              marker = new google.maps.Marker({
                  position,
                  map
              });

              //when marker is pressed it calls toggleExperiences and shows the experience belonging to the marker.
              google.maps.event.addListener(marker, 'click', function(){
                  var experienceElement = document.getElementById(index);
                  experienceElement.scrollIntoView({behavior: 'smooth'});
              });

              //makes the zoom so that every marker is visible
              map.fitBounds(bounds.extend(position));

          });

      },
      updateProfileInfo: function(description, lastName, firstName){

          let self = this;

          self.description = description;
          self.lastName = lastName;
          self.firstName = firstName;
      },

      checkIfFollowing: function(){

          let self = this;
          let followers = this.followers;

          followers.forEach(function(item){
             let followerId = item.$oid;
             let userId = self.$root.store.user.id;
             if (followerId === userId){
                 self.isFollowing = true;
             }

          });


      },

      followUser: function(){
          let followId = this.$route.params.id;
          let self = this;

          axios.post('/followuser', {'followId':followId})
            .then(function (response) {
                console.log(response.data);
                if (response.data){
                    self.isFollowing = true;
                    self.followersAmount++;
                }
            })
            .catch(function (error) {
              console.log(error);
            });
      },

      unFollowUser: function(){

          let followId = this.$route.params.id;
          let self = this;

          axios.post('/unfollowuser', {'unFollowId':followId})
            .then(function (response) {
                console.log(response.data);
                if (response.data){
                    self.isFollowing = false;
                    self.followersAmount--;
                }

            })
            .catch(function (error) {
              console.log(error);
            });
      },

  },
  mounted(){
    // Set variables
    const self = this;
    let userId = self.$route.params.id;
    // Get user data
    axios.post('/getuserexperiences', {'userId':userId})
      .then(function (response) {
        self.firstName = response.data[0].firstName;
        self.lastName = response.data[0].lastName;
        self.description = response.data[0].description;
        if (!response.data[0].followers){
            //do nothing
        } else {
            self.followers = response.data[0].followers;
            self.followersAmount = response.data[0].followers.length;
        }
        if (!response.data[0].following){
            //do nothing
        } else {
            self.following = response.data[0].following;
        }

        if (!self.isOwnProfile){
            self.checkIfFollowing()
        }
//        this.$set('experiences', JSON.parse(response.data[0].experiences));
      })
      .catch(function (error) {
        console.log(error);
      });

    axios.post('/getprofilefeed', {'userId':userId})
      .then(function (response) {
        self.experiences = response.data[1].experiences;
        self.trips = response.data[0].trips;
        self.mapInit();
        console.log(response.data);
      })
      .catch(function (error) {
        self.error = error.response.data.responseMessage;
        console.log(error.response.data.responseMessage);
      });
  },
  created: function () {
    const self = this;
    let userId = self.$route.params.id;
    let sessionId = document.head.querySelector("[name=user]").content;
    // Check if own or other persons profile page
    if (userId === sessionId){
      this.isOwnProfile = true;
    }

  },
  watch: {
      showEdit: function(newValue){
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
