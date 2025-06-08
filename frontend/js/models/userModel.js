const UserModel = {
  user: null,

  setUser(data) {
    this.user = data;
  },

  getUser() {
    return this.user;
  },

  clearUser() {
    this.user = null;
  }
};