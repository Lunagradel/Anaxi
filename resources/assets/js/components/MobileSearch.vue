<template>

    <div class="anaxi-mobile-search-container">
        <div class="anaxi-nav-content-search">
            <input type="text" v-model="searchInput" placeholder="Search" class="anaxi-search desktop-search">
            <div class="anaxi-primary-btn search-btn" v-on:click="searchForValue">
                <i class="ion-ios-search-strong"></i>
            </div>
        </div>
        <div class="anaxi-mobile-content-result">

            <p v-if="!searchResult">Sorry, nothing was found.</p>
            <div class="result-items" v-for="(item, index) in searchResultData" :key="index" v-else>
                <router-link :to="{ name: 'profile', params: { id: item._id.$oid}}" v-on:click.native="searchLinkClicked">
                    <p>{{item.firstName}} {{item.lastName}}</p>
                </router-link>
            </div>

        </div>
    </div>

</template>

<script>
export default {
}
</script>
