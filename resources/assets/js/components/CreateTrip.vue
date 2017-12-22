 <template>

    <div class="anaxi-create anaxi-create-trip">
        <div class="anaxi-create-content anaxi-inner">
            <div class="anaxi-create-top anaxi-create-trip-top">
                <div class="top-close" v-on:click="$emit('closeTrip')">
                    &#10005
                </div>
            </div>
      <div class="anaxi-create-main">
            <div class="anaxi-create-location-content">
                <div class="create-header trip-content-header">
                    <p>Add your Experience </p>
                    <p>to a Trip?</p>
                </div>
                <div class="trip-content-existing">
                    <p>Choose existing</p>
                    <div class="existing-trips">
                        <div class="existing-trip" v-on:click="addToExistingTrip" v-for="trip in existingTrips" :data-trip-id="trip._id.$oid">
                            {{trip.geolocation.name}}
                        </div>
                    </div>
                </div>
                <div class="trip-content-search">
                    <p>Make New</p>
                    <input class="anaxi-search" ref="createTripSearch" id="createTripSearch" type="text" name="search" placeholder="Search"  v-bind:class="{ hidden: existingTripChosen }">
                    <div class="anaxi-primary-btn" v-on:click="clearTripLocal" id="tripAddBtn">
                        Clear
                    </div>
                </div>
            </div>
            <span class="form-message"> {{message}} </span>
            <div class="anaxi-create-bottom">
                <div class="anaxi-primary-btn" v-on:click="submitTrip" id="tripDoneBtn" v-if="latitude">
                    Add new trip
                </div>
                <div class="anaxi-primary-btn" v-on:click="submitToExistingTrip" id="existingExperienceDoneBtn" v-else-if="existingTripChosen">
                    Add to trip
                </div>
                <div class="anaxi-primary-btn" v-on:click="submitPost" id="experienceDoneBtn" v-else>
                    Add experience
                </div>
            </div>
        </div>
        </div>

    </div>

</template>

<script>
export default {

    data: function(){
        return {
            latitude: '',
            longitude: '',
            tripName: '',
            message: '',
            existingTrips: [],
            existingTripChosen: false,
        }
    },
    mounted: function(){
        this.getUserTrips();
        this.initGoogleMapAutocompleter();
    },
  methods: {
    submitPost: function(){
      let self = this;
      let experience = self.$root.store.experienceToStore
      axios.post('/createexperience', {
        recommended: experience.recommended,
        geolocation: {
          lat: experience.latitude,
          lng: experience.longitude,
          locationName: experience.locationName
        },
        description: experience.description,
        image: experience.image
      })
        .then(function (response) {
          self.$emit('closeTrip');
          console.log(response);
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    submitTrip: function () {
      console.log("Submitting a trip");
      let self = this;
      let experience = self.$root.store.experienceToStore
      axios.post('/createtrip', {
        experience: {
            recommended: experience.recommended,
            geolocation: {
              lat: experience.latitude,
              lng: experience.longitude,
              locationName: experience.locationName
            },
            description: experience.description,
            image: experience.image
        },
        trip: {
          lat: self.latitude,
          lng: self.longitude,
          name: self.tripName
        }
      })
        .then(function (response) {
          console.log(response);
          self.$emit('closeTrip');
        })
        .catch(function (error) {
          console.log(error.response.data);
        });
    },
    clearTripLocal: function () {
      let self = this;
      let input = self.$refs.createTripSearch;
      if (input) { input.value = ''; }
      self.latitude = '';
      self.longitude = '';
      self.tripName = '';
      self.existingTripChosen = false;
      this.initGoogleMapAutocompleter();
    },
    getUserTrips: function () {
      let self = this;
      let sessionId = document.head.querySelector("[name=user]").content;
      axios.post('/getUserTrips', {'userId':sessionId})
        .then(function (response) {
          console.log(response.data);
          self.existingTrips = response.data[0].trips;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    addToExistingTrip: function (event) {
      let self = this;
      self.existingTripChosen = event.target.getAttribute("data-trip-id");
    },
    submitToExistingTrip: function () {
      let self = this;
      let experience = self.$root.store.experienceToStore;
      let tripId = self.existingTripChosen;
      axios.post('/addexperiencetotrip', {
        experience: {
          recommended: experience.recommended,
          geolocation: {
            lat: experience.latitude,
            lng: experience.longitude,
            locationName: experience.locationName
          },
          description: experience.description
        },
        trip: {
          id: tripId
        }
      })
        .then(function (response) {
          self.$emit('closeTrip');
          console.log(response.data);
        })
        .catch(function (error) {
          console.log(error.response.data);
        });
    },
    initGoogleMapAutocompleter: function () {
      let self = this;
      let input = this.$refs.createTripSearch;

      let bounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(-90,-180),
        new google.maps.LatLng(90,180)
      )

      const options = {
        bounds: bounds,
        types: ['(regions)']
      }

      let autocomplete = new google.maps.places.Autocomplete(input, options);

      autocomplete.addListener('place_changed', function(){
        let place = autocomplete.getPlace();
        let lat = place.geometry.location.lat();
        let lng = place.geometry.location.lng();
        let name = place.name;

        self.latitude = lat;
        self.longitude = lng;
        self.tripName = name;
      })


    }
  }
}
</script>
