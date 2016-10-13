<template>
    <div class="App">
        <nav class="navbar">
            <ul class="navbar__brand">
                <router-link to="/" tag="li"><a class= "navbar__link">Chain of Memories</a></router-link>
            </ul>

            <ul class="navbar__left-links" v-if="user.isAuthenticated">
                <router-link to="/journals" tag="li"><a class="navbar__link">Journals</a></router-link>
            </ul>

            <ul class="navbar__right-links">
                <li v-if="user.isAuthenticated">
                    <form method="post" action="/logout">
                        <input type="hidden" name="_token" :value="csrfToken">

                        <button class="button--link navbar__link" type="submit">Logout</button>
                    </form>
                </li>
                <router-link to="/login" tag="li" v-else><a class="navbar__link">Login</a></router-link>
            </ul>
        </nav>

        <div class="Body">
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
