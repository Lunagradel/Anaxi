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
            description: this.userDescription
        }
    },

    methods: {
        updateUser: function(){

            let self = this;

            axios.post('/edituser', {
                firstName: this.firstName,
                lastName: this.lastName,
                description: this.description
            })
              .then(function (response) {
                console.log(response);
                self.$emit('updateProfileInfo', self.description, self.lastName, self.firstName);
                // let newDescription = response.data[0].description;
              })
              .catch(function (error) {
                console.log(error);
              });
        }
    },


}
</script>
