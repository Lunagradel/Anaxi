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
                                <p>{{followers}}</p>
                            </div>
                            <div class="information-item">
                                <p>5. Following</p>
                                <p>{{following}}</p>
                            </div>
                        </div>
                        <div class="anaxi-primary-btn" id="profileBtn">
                            Edit
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="anaxi-profile-map" ref="profileMap">

        </div>
        <div class="anaxi-profile-feed">
            <Experience v-for="(experience, index) in experiences" :key="index" v-bind:experience="experience"></Experience>
        </div>
    </div>


</template>

<script>
  import Experience from './Experience.vue';
export default {
  components: {
    Experience
  },
  data: function(){
    return {
        lastName: '',
        firstName: '',
        description: 'heyo this is a description that is very long. maybe even two lines.',
        followers: 100,
        following: 100,
        experiences: [],
    }
  },

  methods: {
      mapInit: function(){

          //Google map
          const bounds = new google.maps.LatLngBounds();
          let mapName = this.$refs.profileMap;
          const mapCenter = this.experiences[0].geolocation;
          console.log(mapCenter);
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
                  console.log("you clicked a marker with index: ", index );
              });

              //makes the zoom so that every marker is visible
              map.fitBounds(bounds.extend(position));

          });

      }
  },
  mounted(){
    const self = this;
    axios.post('/getuserexperiences', this.$data)
      .then(function (response) {
        console.log(response.data[0]);
        self.experiences = response.data[0].experiences;
        self.firstName = response.data[0].firstName;
        self.lastName = response.data[0].lastName;

        self.mapInit();
//        this.$set('experiences', JSON.parse(response.data[0].experiences));
      })
      .catch(function (error) {
        console.log(error);
      });


  }



}
</script>
