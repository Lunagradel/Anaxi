<template>

    <div class="anaxi-follow-contaioner">
        <div class="anaxi-follow-content">
            <div class="anaxi-follow-header">
                Followers
            </div>
            <div class="anaxi-follow-user">
                <p>name here</p>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    props: ['followers'],

    mounted: function(){
        console.log("followeres",this.followers);
    }


}
</script>
