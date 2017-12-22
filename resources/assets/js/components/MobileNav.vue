<template>

    <div class="anaxi-mobile-nav">
        <div class="anaxi-mobile-nav-btns">
            <div class="anaxi-mobile-nav-btn mobile-home-btn">
                <i class="ion-ios-home-outline"></i>
            </div>
            <div class="anaxi-mobile-nav-btn mobile-search-btn">
                <i class="ion-ios-search"></i>
            </div>
            <div class="anaxi-mobile-nav-btn anaxi-primary-btn mobile-post-btn" v-on:click="$emit('showCreate')">
                <p>+</p>
            </div>
            <div class="anaxi-mobile-nav-btn mobile-notifications-btn">
                <i class="ion-ios-world-outline"></i>
            </div>
            <router-link :to="{ name: 'profile', params: { id: userId }}">
            <div class="anaxi-mobile-nav-btn mobile-profile-btn">
                <i class="ion-ios-person-outline"></i>
            </div>
            </router-link>
        </div>
    </div>

</template>

<script>
export default {

    data: function(){
        return {
            userId: this.$root.store.user.id
        }
    }

}
</script>
