<template>
    <div class="anaxi-create anaxi-create-location">
        <div class="anaxi-create-location-background anaxi-inner">
            <div class="location-circle location-circle-1">
                <div class="location-circle location-circle-2">
                    <div class="location-circle location-circle-3">
                        <div class="location-circle location-circle-4">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="anaxi-create-content anaxi-inner">

                <div class="anaxi-create-top">
                    <div class="top-progress">
                        1/3
                    </div>
                    <div class="top-close" v-on:click="$emit('closeModal')">
                        &#10005
                    </div>
                </div>
          <div class="anaxi-create-main">
                <div class="anaxi-create-location-content">
                    <div class="create-header location-content-header">
                        <p>Where were you?</p>
                    </div>
                    <div class="location-content-search">
                        <input class="anaxi-search" ref="locationSearch" id="locationSearch" type="text" name="search" placeholder='E.g. "New York" or "Café Casual"'>
                        <span class="form-message"> {{message}} </span>
                    </div>
                </div>
                <div class="anaxi-create-bottom">
                    <div class="location-bottom-btn next-back-btns" v-on:click="showNextModal">
                        Next
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

export default {

    data: function(){
        return{
            latitude: '',
            longitude: '',
            locationName: '',
            message: '',
        }
    },

    methods: {
        showNextModal: function(){
          if ( !this.latitude ){
            this.message = "Please fill out the location form"
          }else {
            let store = this.$root.store.experienceToStore
            store.locationName = this.locationName
            store.latitude = this.latitude
            store.longitude = this.longitude
            this.$emit('showRecommend');
            this.$emit('closeLocation');
          }
        }
    },

    mounted: function(){

        let self = this;
        let input = this.$refs.locationSearch;

        let bounds = new google.maps.LatLngBounds(
            new google.maps.LatLng(-90,-180),
            new google.maps.LatLng(90,180)
        )

        const options = {
            bounds: bounds,
            types: ['geocode', 'establishment']
        }

        let autocomplete = new google.maps.places.Autocomplete(input, options);

        autocomplete.addListener('place_changed', function(){
            let place = autocomplete.getPlace();
            let lat = place.geometry.location.lat();
            let lng = place.geometry.location.lng();
            let name = place.name;

            self.latitude = lat;
            self.longitude = lng;
            self.locationName = name;

        });

    }

}
</script>
