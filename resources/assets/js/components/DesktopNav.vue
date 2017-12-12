<template>
  <nav class="anaxi-nav">
      <div class="anaxi-nav-content">
          <router-link to="/" exact>
              <div class="logo">
                  <p>
                      Anaxi
                  </p>
              </div>
          </router-link>
          <div class="anaxi-nav-content-btns">
              <div class="anaxi-primary-btn" id="postBtn"><p>Post</p></div>
              <i class="ion-android-globe"></i>
              <router-link to="/" >
                  <div class="profile-btn-content">
                      <p class="profile-name">Anders</p>
                      <div class="profile-avatar">
                      </div>
                  </div>
              </router-link>
          </div>
      </div>
  </nav>
</template>

<script>
export default {
  mounted() {
      console.log('Desktop Nav mounted.')
  }
}
</script>
