const UserView = {
  showLoginSuccess(user) {
    alert(`Welcome, ${user.first_name || user.username || 'User'}!`);
  },

  showLoginError(error) {
    alert('Login failed: ' + error);
  },

  showSignupSuccess() {
    alert('Signup successful! You can now log in.');
  },

  showSignupError(error) {
    alert('Signup error: ' + error);
  }
};
