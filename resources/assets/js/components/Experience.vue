<template>

    <div class="anaxi-card">
        <div class="anaxi-card-post">
            <div class="anaxi-card-top">
                <p>Experience added top <span class="top-trip-btn">Egypt</span> trip.</p>
            </div>
            <div class="anaxi-card-content">
                <div class="anaxi-card-content-user">
                    <div class="user-avatar">

                    </div>
                    <div class="user-name">
                        {{userName}}
                    </div>
                </div>
                <div class="anaxi-card-content-recommendations">
                    <p v-if="Recommends" class="recommendations-answer" id="true">Recommends</p>
                    <p v-else class="recommendations-answer" id="false">Does not recommend</p>
                    <p class="recommendations-place">{{place}}</p>
                </div>
                <div class="anaxi-card-content-extra">
                    <div class="extra-text">
                        {{text}}
                    </div>
                    <div class="extra-image">

                    </div>
                </div>
            </div>
        </div>

        <div class="anaxi-card-bottom">
            Comments should be here. need to find out if it should be a component.
        </div>

    </div>

</template>

<script>

export default {

    data: function(){
        return {
            userName: "John Doe",
            Recommends: true,
            place: "Pyramid of Khufu",
            text: "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Need moore nfm."
        }
    }

}
</script>
