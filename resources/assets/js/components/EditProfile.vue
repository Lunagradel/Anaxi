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
                <img :src="image">
                <input type="file" v-on:change="fileChange">
            </div>
            <input class="anaxi-search anaxi-edit-input" type="text" v-model="firstName" placeholder="firstname">
            <input class="anaxi-search anaxi-edit-input" type="text" v-model="lastName" placeholder="lastname">
            <textarea class="anaxi-search anaxi-edit-textarea" type="text" maxLength="70" rows="2" placeholder="description" v-model="description"></textarea>
            <div class="anaxi-primary-btn" id="EditBtn" v-on:click="updateUser">
                Save
            </div>
        </div>
    </div>

</template>

<script>
export default {
    props: ["userFirstName", "userLastName", "userDescription"],

    data: function(){
        return {
            firstName: this.userFirstName,
            lastName: this.userLastName,
            description: this.userDescription,
            image: ''
        }
    },

    methods: {
        updateUser: function(){

            let self = this;

            axios.post('/edituser', {
                firstName: this.firstName,
                lastName: this.lastName,
                description: this.description,
                image: this.image
            })
              .then(function (response) {
                console.log(response);
                self.$emit('updateProfileInfo', self.description, self.lastName, self.firstName);
                self.$emit('closeEdit');
                // let newDescription = response.data[0].description;
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
