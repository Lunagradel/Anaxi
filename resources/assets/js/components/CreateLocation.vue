<template>
  <div class="anaxi-create anaxi-create-location">
          <div class="anaxi-create-top">
              <div class="top-progress">
                  1/3
              </div>
              <div class="top-close" v-on:click="$emit('closeLocation')">
                  &#10005
              </div>
          </div>
    <div class="anaxi-create-main">
          <div class="anaxi-create-location-content">
              <div class="create-header location-content-header">
                  <p>Share </p>
                  <p>your location.</p>
              </div>
              <div class="location-content-search">
                  <input class="anaxi-search" id="locationSearch" type="search" name="" placeholder="Search">
              </div>
          </div>
          <div class="anaxi-create-bottom">
              <div class="location-bottom-btn next-back-btns" v-on:click="showNextModal">
                  Next
              </div>
          </div>
      </div>
  </div>
</template>

<script>
export default {


    methods: {
        showNextModal: function(){
            this.$emit('showRecommend');
            this.$emit('closeLocation');
        }
    }

}
</script>
