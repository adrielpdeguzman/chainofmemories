<template>
    <div class="Login">
        <form method="post" action="">
            <input type="hidden" name="_token" :value="csrfToken">
            <input class="text" type="text" name="username">
            <input class="text" type="password" name="password">
            <button class="button--default" type="submit">Login</button>
        </form>
    </div>
</template>

<script>
    import auth from '../services/auth';

    export default {
        /**
         * Check authentication before entering route.
         */
        beforeRouteEnter(to, from, next) {
            if (auth.user.isAuthenticated) {
                next('/');
            } else {
                next();
            }
        },

        /**
         * The component's data.
         */
        data() {
            return {
                csrfToken: document.querySelector('meta[name=csrf-token]').content,
            }
        },
    }
</script>
