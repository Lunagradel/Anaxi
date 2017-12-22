<template>

    <div class="anaxi-create anaxi-create-extra">
        <div class="anaxi-create-content anaxi-inner">
            <div class="anaxi-create-top">
                <div class="top-progress">
                    3/3
                </div>
                <div class="top-close" v-on:click="$emit('closeModal')">
                    &#10005
                </div>
            </div>
      <div class="anaxi-create-main">
            <div class="anaxi-create-location-content anaxi-create-extra-content">
                <textarea
                    class="description-input"
                    rows="5"
                    maxlength="140"
                    type="text"
                    name="description"
                    placeholder="Write a description.."
                    v-model="description"
                ></textarea>
            </div>
            <div class="content-character-limit">
                {{charactersLeft}}
            </div>
            <div class="content-add-image">
                <p>Add image</p>
                <input type="file" v-on:change="fileChange">
            </div>
            <div class="content-image-thumbnail">
                <img :src="image" alt="">
            </div>
        </div>
        <div class="anaxi-create-bottom anaxi-create-extra-bottom">
            <div class="extra-bottom-content">
                <div class="next-back-btns extra-back-btn" v-on:click="showRecommendModal">
                    <p>Back</p>
                </div>
                <div class="anaxi-primary-btn" id="createPostBtn" v-on:click="makePost">
                    Post
                </div>
            </div>

        </div>
        </div>

    </div>

</template>

<script>
export default {

    data: function(){
        return {
            description: '',
            image: ''
        }
    },
    computed: {
        charactersLeft() {
            let characters = this.description.length;
            let limit = 140;

            return (limit - characters) + " / " + limit;
        }
    },
    methods: {
        showRecommendModal: function(){
            this.$emit("closeExtra");
            this.$emit("showRecommend");
        },
        makePost: function(){
            this.$root.store.experienceToStore.description = this.description;
            this.$root.store.experienceToStore.image = this.image;
            this.$emit('closeExtra');
            this.$emit('showTrip');
        },
        fileChange: function(e){
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) {
                return;
            } else {
                this.createImage(files[0]);
            }
        },
        createImage: function(file){
            let reader = new FileReader();
            let self = this;
            reader.onload = (e) => {
                self.image = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

}
</script>
