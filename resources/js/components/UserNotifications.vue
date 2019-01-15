<template>
    <li class="nav-item dropdown" v-if="notifications.length">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell"></i>
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li v-for="notification in notifications">
              <a 
                :href="notification.data.link" 
                v-text="notification.data.message" 
                @click="markAsRead(notification)">
            </a>
          </li>
        </ul>
    </li>
</template>

<script>
    export default {
        data() {
            
            return { notifications: false }
        },

        created() {

            axios.get('/profiles/' + window.App.user.name + '/notifications')
                .then(response => this.notifications = response.data);
        },
        
        methods: {

            markAsRead(notification) {
                axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id)
            }
        }
    }
</script>
