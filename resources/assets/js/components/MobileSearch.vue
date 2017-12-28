<template>

    <div class="anaxi-mobile-search-container">
        <div class="anaxi-nav-content-search">
            <input type="text" v-model="searchInput" placeholder="Search" class="anaxi-search desktop-search">
            <div class="anaxi-primary-btn search-btn" v-on:click="searchForValue">
                <i class="ion-ios-search-strong"></i>
            </div>
        </div>
        <div class="anaxi-mobile-content-result" v-show="showSearchResult">

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

    data: function(){
        return {
            searchInput: '',
            searchResult: false,
            showSearchResult: false,
            searchResultData: []
        }
    },
    methods: {
        searchForValue: function(){
            if (this.searchInput === '') {
                //nothing to search for
            } else {
                let self = this;
                axios.post('/searchforvalue', {'searchValue':self.searchInput})
                  .then(function (response) {
                      console.log("response from search", response.data);
                      if (response.data.length > 0){
                          self.searchResult = true;
                          self.searchResultData = response.data;
                          self.showSearchResult = true;
                      } else {
                          self.searchResult = false;
                          self.searchResultData = [];
                          self.showSearchResult = true;
                      }
                  })
                  .catch(function (error) {
                    console.log(error);
                  })
            }
        }
    },
    watch: {
        searchInput:function(newValue){
            if (newValue === ""){
                this.searchResult = false;
                this.searchResultData = [];
                this.showSearchResult = false;
            }
        }
    }

}
</script>
