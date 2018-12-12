<template>
    <div>
        <div v-if="signedIn">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <textarea   rows="5" 
                                placeholder="Please enter your text" 
                                class="form-control" name="body" id="body" 
                                required
                                v-model="body">
                        </textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" @click="addReply">Post</button>
                </div>
            </div>
        </div>
        <p class="text-center" v-else>Please <a href="/login">sign in </a> to continue...</p>
    </div>
</template>


<script>
    export default {

        data() {
            return {
                body: ''
            };
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', { body: this.body })
                    .catch(error => {
                        flash(error.response.data);
                    })
                    .then(({data}) => {
                        this.body = '';
                        
                        flash('Your reply has been posted.');
                        
                        this.$emit('created', data);
                    }
                );
            }
        }
    }

</script>
