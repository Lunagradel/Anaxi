<template>
    <div class="flexthis">
      <experience></experience>
    </div>
</template>

<script>

    import Experience from './Experience.vue';

    export default {
        components: {
            Experience
        }
    }
</script>

<style lang="css">

    .flexthis {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
</style>
