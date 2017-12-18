<template>
    <div>
    <div class="anaxi-profile-page">
        <div class="anaxi-profile">
            <div class="anaxi-profile-background anaxi-profile-inner">
                <div class="circle circle-15">
                    <div class="circle circle-14">
                        <div class="circle circle-13">
                            <div class="circle circle-12">
                                <div class="circle circle-11">
                                    <div class="circle circle-10">
                                        <div class="circle circle-9">
                                            <div class="circle circle-8">
                                                <div class="circle circle-7">
                                                    <div class="circle circle-6">
                                                        <div class="circle circle-5">
                                                            <div class="circle circle-4">
                                                                <div class="circle circle-3">
                                                                    <div class="circle circle-2">
                                                                        <div class="circle circle-1">
                                                                            <div class="circle" id="circle">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <div class="anaxi-profile-passport anaxi-profile-inner">
                <div class="anaxi-profile-passport-graphic">
                    <div class="graphic-title">
                        <p>PROFILE PAGE</p>
                        <p>PAGE DE PROFIL</p>
                        <p>PROFILSEITE</p>
                    </div>
                    <div class="graphic-image">

                    </div>
                </div>
                <div class="anaxi-profile-passport-information">
                    <div class="information-left">
                        <div class="information-mobile">
                            <div class="information-item">
                                <p>1. Lastname</p>
                                <p>ANDERSEN</p>
                            </div>
                            <div class="information-item">
                                <p>2. Firstname</p>
                                <p>ANDERS</p>
                            </div>
                        </div>
                        <div class="information-item">
                            <p>3. Description</p>
                            <p>heyo this is a description that is very long. maybe even two lines.</p>
                        </div>
                    </div>
                    <div class="information-right">
                        <div class="information-mobile">
                            <div class="information-item">
                                <p>4. Followers</p>
                                <p>100</p>
                            </div>
                            <div class="information-item">
                                <p>5. Following</p>
                                <p>100</p>
                            </div>
                        </div>
                        <div class="anaxi-primary-btn" id="profileBtn">
                            Edit
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

        <Experience v-for="(experience, index) in experiences" :key="index" v-bind:experience="experience"></Experience>
    </div>


</template>

<script>
  import Experience from './Experience.vue';
export default {
  components: {
    Experience
  },
  data: function(){
    return{
      experiences: [],
    }
  },
  mounted(){
    const self = this;
    axios.post('/getuserexperiences', this.$data)
      .then(function (response) {
        console.log(response.data[0].experiences);
        self.experiences = response.data[0].experiences;
//        this.$set('experiences', JSON.parse(response.data[0].experiences));
      })
      .catch(function (error) {
        console.log(error);
      });
  }

}
</script>
