<!--This component is used for filtering post types. In order for the posts to be outputted in chronological order, these are sorted in the backend and filtered here-->
<template>
    <Trip v-bind:trip="post.content" v-bind:id="index" v-bind:date="computedDate" v-if="post.type === 'trip'"></Trip>
    <TripExperience v-bind:experience="post.content" v-bind:owner="post.owner" v-bind:id="index" v-bind:date="computedDate" v-else-if="post.type === 'tripExperience'"></TripExperience>
    <Experience v-bind:experience="post.content" v-bind:id="index" v-bind:date="computedDate" v-else></Experience>
</template>

<script>
  import Experience from './Experience.vue';
  import TripExperience from './TripExperience.vue';
  import Trip from './Trip.vue';
  export default {
    props: ['post', 'index'],
    data: function(){
      return {
      }
    },
    computed: {
      computedDate(){
        let sinceUnixEpoch = new Date( this.post.timeStamp * 1000 );
        return sinceUnixEpoch.toLocaleString();
      }
    },
    mounted: function() {
    },
    components: {
      Trip,
      TripExperience,
      Experience
    }
  }
</script>
