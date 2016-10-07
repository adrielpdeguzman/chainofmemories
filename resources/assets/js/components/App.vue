<template>
    <div class="App">
        <nav class="Navbar">
            <router-link to="/">Home</router-link>
            <router-link to="/journals" v-if="user.isAuthenticated">Journals</router-link>

            <form method="post" :action="user.isAuthenticated ? '/logout' : '/login'">
                <input type="hidden" name="_token" :value="csrfToken">

                <template v-if="!user.isAuthenticated">
                    <input type="text" class="input--text" name="username" id="username" placeholder="Username">
                    <input type="password" class="input--text" name="password" id="password" placeholder="Password">
                </template>

                <button class="button--link" type="submit">
                    {{ user.isAuthenticated ? 'Logout' : 'Login' }}
                </button>
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
        /**
         * The component's data.
         */
        data() {
            return {
                csrfToken: document.querySelector('meta[name=csrf-token]').content,
                user: auth.user,
            };
        },
    }
</script>
