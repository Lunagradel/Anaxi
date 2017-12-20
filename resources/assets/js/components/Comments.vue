<template>

    <div class="anaxi-comments">
        <div class="anaxi-comments-items">
            <div class="anaxi-comments-item">
                <div class="comments-item-user">
                    <p></p>
                </div>
                <div class="comments-item-comment">

                </div>
            </div>
        </div>
        <div class="anaxi-comments-input">
            <input type="text" name="comment" v-model="comment" placeholder="Add comment..">
            <div class="anaxi-comments-btn" v-on:click="addComment">
                Send
            </div>
        </div>

    </div>

</template>

<script>



export default {

    props: ['experience'],
    data: function(){
        return {

            comment: ''

        }
    },

    methods: {
        addComment: function(){

            axios.post('/addcomment', {
                postId: this.experience._id.$oid,
                comment: this.comment
            })
              .then(function (response) {
                console.log(response);
              })
              .catch(function (error) {
                console.log(error.response.data);
              });
        }
    }

}
</script>
