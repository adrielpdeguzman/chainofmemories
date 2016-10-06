<template>
    <div class="App">
        <nav>
            <router-link to="/">Home</router-link>
            <router-link to="/journals">Journals</router-link>
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
    export default {

    }
</script>
