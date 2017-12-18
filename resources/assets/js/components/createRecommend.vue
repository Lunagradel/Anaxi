<template>

    <div class="anaxi-create anaxi-create-recommend">
        <div class="anaxi-create-content anaxi-inner">
            <div class="anaxi-create-top">
                <div class="top-progress">
                    2/3
                </div>
                <div class="top-close" v-on:click="$emit('closeRecommend')">
                    &#10005
                </div>
            </div>
      <div class="anaxi-create-main">
            <div class="anaxi-create-location-content">
                <div class="create-header recommend-content-header">
                    <p>Recommend?</p>
                </div>
                <div class="recommend-content-answer">
                    <input type="radio" class="answer-btn" v-model="recommended" :value=true id="recommendYes">
                    <label for="recommendYes">Yes</label>
                    <p>/</p>
                    <input type="radio" class="answer-btn" v-model="recommended" :value=false id="recommendNo">
                    <label for="recommendNo">No</label>
                </div>
            </div>
            <div class="anaxi-create-bottom anaxi-create-recommend-bottom">
                <div class="recommend-back-btn next-back-btns" v-on:click="showLocationModal">
                    <p>Back</p>
                </div>
                <p>/</p>
                <div class="recommend-back-btn next-back-btns" v-on:click="showExtraModal">
                    <p>Next</p>
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
      recommended: true,
    }
  },
    methods: {
        showLocationModal: function(){
            this.$emit('closeRecommend');
            this.$emit('showLocation');
        },
        showExtraModal: function(){
            this.$root.store.experienceToStore.recommended = this.recommended
            this.$emit('closeRecommend');
            this.$emit('showExtra');
        }
    }

}
</script>
