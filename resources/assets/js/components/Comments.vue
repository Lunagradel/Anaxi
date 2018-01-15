<template>

    <div class="anaxi-comments">
        <div class="anaxi-comments-items">
            <div class="anaxi-comments-item" v-for="comment in comments">
                <div class="comments-item">
                    <p>
                        <router-link :to="{ name: 'profile', params: { id: comment.userId }}">
                            <span class="comments-item-user">{{comment.user}}</span>
                        </router-link>
                        {{comment.text}}
                    </p>
                </div>
            </div>
        </div>
        <div class="anaxi-comments-line"></div>
        <div class="anaxi-comments-input">
            <input class="comment-input" type="text" name="comment" v-model="comment" placeholder="Add comment..">
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

            comment: '',
            comments: [

            ]
        }
    },

    methods: {
        addComment: function(){

            let self = this;
            let commentText = this.comment;
            let userName = this.$root.store.user.fullName;
            let userId = this.$root.store.user.id;

            if (!this.comment) {
                //can't post a empty comment!
            } else {
                axios.post('/addcomment', {
                    postId: this.experience._id.$oid,
                    comment: this.comment,
                    userName: this.$root.store.user.fullName
                })
                  .then(function (response) {
                    console.log(response);
                    self.addNewComment(commentText, userName, userId);
                    self.comment = '';
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            }
        },

        getComments: function(){

            let commentsArr = this.comments;

            //comments coming through props
            let commentsFromDB = this.experience.comments;
            // console.log(commentsFromDB);

            if (!commentsFromDB){
//                console.log("no comments");
            } else {
                commentsFromDB.forEach(function(item){

                    let comment = {text: item.comment, user: item.userName, userId: item.user.$oid};
                    commentsArr.push(comment);
                });
            }
        },

        addNewComment(comment, user, userId){
            let commentsArr = this.comments;
            let newComment = {text: comment, user: user, userId: userId};
            commentsArr.push(newComment);
        }
    },

    mounted: function(){

        this.getComments();
//        console.log(this.comments);


    }

}
</script>
