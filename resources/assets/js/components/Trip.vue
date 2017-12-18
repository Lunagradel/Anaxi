<template>

    <div class="anaxi-card">
        <div class="anaxi-card-post">
            <div class="anaxi-card-content">
                <div class="anaxi-card-content-user">
                    <div class="user-avatar">

                    </div>
                    <div class="user-name">
                        John Doe
                    </div>
                </div>
                <div class="anaxi-card-content-destination">
                    <p>went to</p>
                    <p class="destination-place">Egypt</p>
                </div>
                <div class="anaxi-card-content-map">
                    <div class="trip-map" ref="tripMap">

                    </div>
                </div>
                <div class="anaxi-card-content-experiences">
                    <div class="accordion-experience">
                        <div class="accordion-experience-btn" v-on:click.prevent="toggleExperiences(0)">
                            <div class="accordion-btn-circle"></div>
                            <p class="accordion-btn-title">{{experiences[0].title}}</p>
                        </div>
                        <div class="accordion-experience-content">
                            <div v-show="experiences[0].show" class="experience-container">
                                <div class="experience-container-content">
                                    <div class="anaxi-card-content-recommendations">
                                        <p class="recommendations-answer" id="true">Recommends</p>
                                        <p class="recommendations-place">{{experiences[0].title}}</p>
                                    </div>
                                    <div class="anaxi-card-content-extra">
                                        <div class="extra-text">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Need moore nfm.
                                        </div>
                                        <div class="extra-image">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-experience">
                        <div class="accordion-experience-btn" v-on:click.prevent="toggleExperiences(1)">
                            <div class="accordion-btn-circle"></div>
                            <p class="accordion-btn-title">{{experiences[1].title}}</p>
                        </div>
                        <div class="accordion-experience-content accordion-last-experience">
                            <div v-show="experiences[1].show" class="experience-container">
                                <div class="experience-container-content">
                                    <div class="anaxi-card-content-recommendations">
                                        <p class="recommendations-answer" id="false">Does not recommend</p>
                                        <p class="recommendations-place">{{experiences[1].title}}</p>
                                    </div>
                                    <div class="anaxi-card-content-extra">
                                        <div class="extra-text">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Need moore nfm.
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

    data: function(){
        return {
            experiences: [
                {
                    title: "Pyramid of Khufu",
                    show:false,
                    latitude: 29.983249,
                    longitude: 31.135060
                },
                {
                    title: "Lake Nasser",
                    show:false,
                    latitude: 22.881104,
                    longitude: 32.201058
                }
            ]
        }
    },

    methods: {
        toggleExperiences: function(index){
            for (var i = 0; i < this.experiences.length; i++){

                if (index === i){
                    this.experiences[index].show = !this.experiences[index].show;
                } else {
                    this.experiences[i].show = false;
                }
            }

        }
    },

    mounted: function() {

        let self = this;
        const bounds = new google.maps.LatLngBounds();
        let mapName = this.$refs.tripMap;
        const mapCenter = this.experiences[0];
        let marker;

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

}
</script>
