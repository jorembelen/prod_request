<template>
    <div>
        <h1>{{ currentUserRole }} Home</h1>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        name: 'admin-home',
        computed: {
            ...mapGetters('auth', {
                isLoggedIn: 'isLoggedIn',
                currentUser: 'currentUser',
                currentUserRole: 'currentUserRole'
            })
        }
    }
</script>
