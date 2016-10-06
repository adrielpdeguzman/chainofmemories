export default {
    user: {
        isAuthenticated: false,
        data: false,
    },

    check(context) {
        return context.$http.get('/api/user');
    },
}
