<template>
    <div class="accordion-experience">
        <div class="accordion-experience-btn" v-on:click="toggleExperiences(index)">
            <div class="accordion-btn-circle"></div>
            <p class="accordion-btn-title">{{experience.geolocation.locationName}}</p>
        </div>
        <div class="accordion-experience-content">
            <div v-show="show" class="experience-container">
                <div class="experience-container-content">
                    <div class="anaxi-card-content-recommendations">
                        <p class="recommendations-answer" id="true">Recommends</p>
                        <p class="recommendations-place">{{experience.geolocation.locationName}}</p>
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
</template>

<script>
  export default {
    props: ['experience', 'index'],
    data: function(){
      return {
        show: false,
      }
    },
    mounted: function() {
    },
    components: {
//      Comments
    },
    methods: {
        toggleExperiences: function(index){
          console.log("Show emitted");
          for (var i = 0; i < this.trip.experiences.length; i++){

            if (index === i){
              this.trip.experiences[index].show = !this.trip.experiences[index].show;
            } else {
              this.trip.experiences[i].show = false;
            }
          }

        }
    },

  }
</script>
