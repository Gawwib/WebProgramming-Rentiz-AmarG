const UserController = {
  async login() {
    const email = $('#email').val();
    const password = $('#password').val();
    const credentials = { email, password };

    try {
      const user = await UserService.login(credentials);
      UserModel.setUser(user);
      UserView.showLoginSuccess(user);
      // Optionally: redirect to dashboard or home page
    } catch (err) {
      UserView.showLoginError(err);
    }
  },

  async signup(data) {
    try {
      const result = await UserService.signup(data);
      UserView.showSignupSuccess();
      // Optionally: redirect to login page or home page
    } catch (err) {
      UserView.showSignupError(err);
    }
  },

  logout() {
    UserModel.clearUser();
    alert('You have been logged out.');
    // Optionally: redirect to home or login page
  }
};
