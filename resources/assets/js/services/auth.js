export default {
    user: {
        isAuthenticated: false,
        data: false,
    },

    /**
     * Check if the current user is authenticated
     */
    check(context) {
        if (context.$http) {
            return context.$http.get('/api/user');    
        } else {
            return context.http.get('/api/user');
        }
    },
}
