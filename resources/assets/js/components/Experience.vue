<template>

    <div class="anaxi-card">
        <div class="anaxi-card-post">
            <div class="anaxi-card-top">
                {{date}}
            </div>
            <div class="anaxi-card-content">
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
    props: ['experience', 'date', 'owner'],
    mounted: function() {
    },
    components: {
        Comments
    },
    computed: {
      userName: function () {
        return this.$root.store.user.fullName;
      }
    }

}
</script>
