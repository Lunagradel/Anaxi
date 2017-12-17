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
                        <div class="existing-trip">France</div>
                        <div class="existing-trip">Egypt</div>
                    </div>
                </div>
                <div class="trip-content-search">
                    <p>Make New</p>
                    <input class="anaxi-search" ref="createTripSearch" id="createTripSearch" type="text" name="search" placeholder="Search">
                </div>
            </div>
            <div class="anaxi-create-bottom">
                <div class="anaxi-primary-btn" id="tripDoneBtn">
                    Done
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
            tripName: ''
        }
    },


    mounted: function(){

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
</script>
