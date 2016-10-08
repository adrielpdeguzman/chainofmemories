<template>
    <div class="Login">
        <div class="panel">
            <div class="panel__body">
                <form method="post" action="/login">
                    <input type="hidden" name="_token" :value="csrfToken">
                    <div :class="['input-group', loginError ? 'input-group--has-error' : '']">
                        <label class="input-label" for="username">Username</label>
                        <input type="text" class="input-field" name="username" id="username" placeholder="Username">
                        <span class="input-error" v-if="loginError" v-text="loginError"></span>
                    </div>
                    <div :class="['input-group', loginError ? 'input-group--has-error' : '']">
                        <label class="input-label" for="password">Password</label>
                        <input type="password" class="input-field" name="password" id="password" placeholder="Password">
                    </div>
                    <button class="button button--primary utility-max-width" type="submit">Login</button>
                </form>
            </div>
        </div>
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
         * The component's data
         */
        data() {
            return {
                csrfToken: document.querySelector('meta[name=csrf-token]').content,
                loginError: !_.isUndefined(window.loginError) ? window.loginError : false,
            };
        },
    }
</script>
