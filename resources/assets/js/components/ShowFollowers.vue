<template>

    <div class="anaxi-follow-contaioner">
        <div class="anaxi-follow-content">
            <div class="follow-close" v-on:click="$emit('closeFollow')">
                &#10005
            </div>
            <div class="anaxi-follow-header" v-if="this.following">Following</div>
            <div class="anaxi-follow-header" v-else>Followers</div>
            <div class="anaxi-follow-users">
                <div class="anaxi-follow-user" v-for="(item, index) in this.followers" :key="index">
                    <router-link :to="{ name: 'profile', params: { id: item._id}}" v-if="typeIsFollowing">
                        <p>{{item.name}}</p>
                    </router-link>
                    <router-link :to="{ name: 'profile', params: { id: item._id.$oid}}" v-else>
                        <p>{{item.name}}</p>
                    </router-link>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    props: ['followers', 'following'],

    data: function(){
        return {
            typeIsFollowing: this.following
        }
    },

    mounted: function(){
        console.log("following:",this.followers);
        console.log("following:",this.following);
    }


}
</script>
