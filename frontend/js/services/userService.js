
const UserService = {
  async login(credentials) {
    try {
      const response = await fetch('/api/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(credentials)
      });
      const data = await response.json();
      if (!response.ok) throw data.message || 'Login failed';
      return data;
    } catch (error) {
      throw error;
    }
  },

  async signup(data) {
    try {
      const response = await fetch('/api/signup', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });
      const result = await response.json();
      if (!response.ok) throw result.message || 'Signup failed';
      return result;
    } catch (error) {
      throw error;
    }
  }
};
