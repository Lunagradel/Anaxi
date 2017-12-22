<template>

    <div class="anaxi-card">
        <div class="anaxi-card-post">
            <div class="anaxi-card-top">
                <p>Experience added top <span class="top-trip-btn">Egypt</span> trip.</p>
            </div>
            <div class="anaxi-card-content">
                <div class="anaxi-card-content-user">
                    <div class="user-avatar">

                    </div>
                    <div class="user-name">
                        {{userName}}
                    </div>
                </div>
                <div class="anaxi-card-content-recommendations">
                    <p v-if="experience.recommended" class="recommendations-answer" id="true">Recommends</p>
                    <p v-else class="recommendations-answer" id="false">Does not recommend</p>
                    <p class="recommendations-place">{{experience.geolocation.locationName}}</p>
                </div>
                <div class="anaxi-card-content-extra">
                    <div class="extra-text" v-if="experience.description">
                        {{experience.description}}
                    </div>
                    <div class="extra-image" v-if="experience.image">
                        <img :src="'/img/'+experience.image">
                    </div>
                </div>
            </div>
        </div>

        <div class="anaxi-card-bottom">
            <comments v-bind:experience="experience"></comments>
        </div>

    </div>

</template>

<script>

import Comments from './Comments.vue';

export default {
    props: ['experience'],
    data: function(){
        return {
            userName: "Bob Ole",
            Recommends: true,
            place: "Pyramid of Khufu",
            text: "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Need moore nfm.",
            image: ''
        }
    },
    mounted: function() {
    },
    components: {
        Comments
    }

}
</script>
