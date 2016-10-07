export default {
    user: {
        isAuthenticated: false,
        data: false,
    },

    check(context) {
        if (context.$http) {
            return context.$http.get('/api/user');    
        } else {
            return context.http.get('/api/user');
        }
    },
}
