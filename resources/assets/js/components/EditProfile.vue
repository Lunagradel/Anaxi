<template>

    <div class="anaxi-edit-profile">
        <div class="anaxi-edit-profile-content">
            <div class="edit-content-top">
                <div class="top-close" v-on:click="$emit('closeEdit')">
                    &#10005
                </div>
            </div>
            <div class="edit-content-header">
                <p>Edit your profile</p>
            </div>
            <div class="edit-content-image">
                <img :src="image" v-if="newImage">
                <img :src="'/img/'+image" v-else>
                <input type="file" v-on:change="fileChange">
            </div>
            <textarea class="anaxi-search anaxi-edit-textarea" type="text" maxLength="70" rows="2" placeholder="description" v-model="description"></textarea>
            <div class="anaxi-primary-btn" id="EditBtn" v-on:click="updateUser">
                Save
            </div>
        </div>
    </div>

</template>

<script>
export default {
    props: ["userDescription", "imageInfo"],

    data: function(){
        return {
            description: this.userDescription,
            image: this.imageInfo,
            oldImage: this.imageInfo,
            sameImage: true,
            newImage: false
        }
    },

    methods: {
        updateUser: function(){

            if (this.image === this.oldImage){
                console.log("no image change");
            } else {
                this.sameImage = false;
            }
            let self = this;

            axios.post('/edituser', {
                description: this.description,
                image: this.image,
                sameImage: this.sameImage
            })
              .then(function (response) {
                console.log(response);
                self.$emit('updateProfileInfo', self.description, response.data);
                self.$emit('closeEdit');
              })
              .catch(function (error) {
                console.log(error);
              });
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
                self.newImage = true;
            }
            reader.readAsDataURL(file);
        }
    },


}
</script>

<style scoped>

    img {
        max-height: 80px;
    }

</style>
