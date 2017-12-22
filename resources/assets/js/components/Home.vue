<template>
    <div class="flexthis">
        <!--<trip></trip>-->
      <!--<experience></experience>-->
    </div>
</template>

<script>

    import Experience from './Experience.vue';
    import Trip from './Trip.vue';

    export default {
        components: {
            Experience,
            Trip
        }
    }
</script>

<style lang="css">

    .flexthis {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 20px;
    }
</style>
