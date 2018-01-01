<template>

    <div class="anaxi-card">
        <div class="anaxi-card-post">
            <div class="anaxi-card-content">
                <div class="anaxi-card-top">
                    {{date}}
                    <!--<p>Experience added top <span class="top-trip-btn">Egypt</span> trip.</p>-->
                </div>
                <div class="anaxi-card-content-user">
                    <div class="profile-btn-content">
                        <div class="profile-avatar">
                            <router-link :to="{ name: 'profile', params: { id: owner.id.$oid }}">
                                <img :src="'/img/' + owner.image" alt="">
                            </router-link>
                        </div>
                    </div>
                    <div class="user-name">
                        <router-link :to="{ name: 'profile', params: { id: owner.id.$oid }}">
                            {{owner.firstName}}
                            {{owner.lastName}}
                        </router-link>
                    </div>
                </div>
                <div class="anaxi-card-content-destination">
                    <p>went to</p>
                    <p class="destination-place">{{trip.geolocation.name}}</p>
                </div>
                <div class="anaxi-card-content-map">
                    <div class="trip-map" ref="tripMap">

                    </div>
                </div>
                <div class="anaxi-card-content-experiences">
                    <div class="accordion-experience" v-for="(experience, index) in experiences" :key="index">
                        <div class="accordion-experience-btn" v-on:click.prevent="toggleExperiences(index)">
                            <div class="accordion-btn-circle"></div>
                            <p class="accordion-btn-title">{{experience.title}}</p>
                        </div>
                        <div class="accordion-experience-content">
                            <div v-show="experiences[index].show" class="experience-container">
                                <div class="experience-container-content">
                                    <div class="anaxi-card-content-recommendations">
                                        <p v-if="experience.recommend" class="recommendations-answer" id="true">Recommends</p>
                                        <p v-else class="recommendations-answer" id="false">Does not recommend</p>
                                        <p class="recommendations-place">{{experience.title}}</p>
                                    </div>
                                    <div class="anaxi-card-content-extra">
                                        <div class="extra-text" v-if="experience.description">
                                            {{experience.description}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="anaxi-card-bottom">
            Comments should be here. need to find out if it should be a component.
        </div>
    </div>

</template>

<script>

export default {
    props: ['trip', 'date', 'owner'],

    data: function(){
        return {
            experiences: []
        }
    },

    mounted: function() {

        const tripExperiences = this.trip.experiences;
        let self = this;

        tripExperiences.forEach(function(item){
            let newExperienceObj = {
                title: item.geolocation.locationName,
                latitude: item.geolocation.lat,
                longitude: item.geolocation.lng,
                recommend: item.recommended,
                description: item.description,
                show: false
            }

            self.experiences.push(newExperienceObj);
//            console.log("experiences",self.experiences);
        });

        self.mapInit();

    },
    methods: {
        toggleExperiences: function(index){
          console.log(index);
          for (var i = 0; i < this.experiences.length; i++){

            if (index === i){
              this.experiences[index].show = !this.experiences[index].show;
            } else {
              this.experiences[i].show = false;
            }
          }
      },

      mapInit: function(){
          const bounds = new google.maps.LatLngBounds();
          let mapName = this.$refs.tripMap;
          const mapCenter = this.experiences[0];
          let marker;
          let self = this;

          const options = {
              center: new google.maps.LatLng(mapCenter.latitude, mapCenter.longitude),
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
              const position = new google.maps.LatLng(item.latitude, item.longitude);

              marker = new google.maps.Marker({
                  position,
                  map
              });

              //when marker is pressed it calls toggleExperiences and shows the experience belonging to the marker.
              google.maps.event.addListener(marker, 'click', function(){
                  self.toggleExperiences(index);
              });

              //makes the zoom so that every marker is visible
              map.fitBounds(bounds.extend(position));

          });
      }
    },

}
</script>
