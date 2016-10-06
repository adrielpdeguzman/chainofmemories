export default {
    user: {
        isAuthenticated: false,
        data: false,
    },

    check(context) {
        context.$http.get('/api/user')
                .then(({body}) => {
                    this.user.data = body;
                    this.user.isAuthenticated = true;
                });
    },
}
