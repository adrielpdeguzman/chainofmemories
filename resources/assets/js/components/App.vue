<template>
    <div class="App">
        <nav class="Navbar">
            <ul class="Navbar__brand">
                <router-link to="/" tag="li"><a class= "Navbar__link">Chain of Memories</a></router-link>
            </ul>

            <ul class="Navbar__left-links" v-if="user.isAuthenticated">
                <router-link to="/journals" tag="li"><a class="Navbar__link">Journals</a></router-link>
                <router-link to="/journals" tag="li"><a class="Navbar__link">Journals</a></router-link>
                <router-link to="/journals" tag="li"><a class="Navbar__link">Journals</a></router-link>
                <router-link to="/journals" tag="li"><a class="Navbar__link">Journals</a></router-link>
                <router-link to="/journals" tag="li"><a class="Navbar__link">Journals</a></router-link>
            </ul>

            <ul class="Navbar__right-links">
                <li v-if="user.isAuthenticated">
                    <form method="post" action="/logout">
                        <input type="hidden" name="_token" :value="csrfToken">

                        <button class="button--link Navbar__link" type="submit">Logout</button>
                    </form>
                </li>
                <router-link to="/login" tag="li" v-else><a class="Navbar__link">Login</a></router-link>
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
