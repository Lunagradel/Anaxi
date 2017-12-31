<template>

    <div class="anaxi-mobile-nav">
        <div class="anaxi-mobile-nav-btns">
            <router-link to="/" exact>
                <div class="anaxi-mobile-nav-btn mobile-home-btn">
                    <i class="ion-ios-home" v-if="buttons[0].active"></i>
                    <i class="ion-ios-home-outline" v-else></i>
                </div>
            </router-link>
            <router-link to="/search">
                <div class="anaxi-mobile-nav-btn mobile-search-btn">
                    <i class="ion-ios-search-strong" v-if="buttons[1].active"></i>
                    <i class="ion-ios-search" v-else></i>
                </div>
            </router-link>
            <div class="anaxi-mobile-nav-btn anaxi-primary-btn mobile-post-btn" v-on:click="$emit('showCreate')">
                <p>+</p>
            </div>
            <div class="anaxi-mobile-nav-btn mobile-notifications-btn">
                <i class="ion-ios-world" v-if="buttons[2].active"></i>
                <i class="ion-ios-world-outline" v-else></i>
            </div>
            <router-link :to="{ name: 'profile', params: { id: userId }}">
            <div class="anaxi-mobile-nav-btn mobile-profile-btn">
                <i class="ion-ios-person" v-if="buttons[3].active"></i>
                <i class="ion-ios-person-outline" v-else></i>
            </div>
            </router-link>
        </div>
    </div>

</template>

<script>
export default {

    data: function(){
        return {
            userId: this.$root.store.user.id,
            buttons: [
                {active:false},
                {active:false},
                {active:false},
                {active:false}
            ]
        }
    },
    mounted: function(){
        let routeName = this.$route.name;
        let index;
        if (routeName === 'home'){
            index = 0;
        } else if (routeName === 'search') {
            index = 1;
        } else if (routeName === 'profile'){
            index = 3;
        }

        this.buttons[index].active = true;
    },
    watch: {
        $route: function(newValue){
            let routeName = newValue.name;
            let index;
            if (routeName === 'home'){
                index = 0;
            } else if (routeName === 'search') {
                index = 1;
            } else if (routeName === 'profile'){
                index = 3;
            }

            this.buttons.forEach(function(item){
                item.active = false;
            });

            this.buttons[index].active = true;
        }
    }

}
</script>
