<template>
    <div class="App">
        <nav>
            <router-link to="/">Home</router-link>
            <router-link to="/login" v-if="!user.isAuthenticated">Login</router-link>
            <router-link to="/journals" v-if="user.isAuthenticated">Journals</router-link>

            <form method="post" action="/logout" v-if="user.isAuthenticated">
                <input type="hidden" name="_token" :value="csrfToken">
                <button class="button--link" type="submit">Logout</button>
            </form>
        </nav>

        <div class="container">
            <router-view></router-view>
        </div>

        <footer class="Footer">
            Footer
        </footer>
    </div>
</template>

<script>
    import auth from '../services/auth';

    export default {
        data() {
            return {
                csrfToken: document.querySelector('meta[name=csrf-token]').content,
                user: auth.user,
            };
        },
    }
</script>
