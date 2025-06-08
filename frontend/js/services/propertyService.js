const PropertyService = {
  async fetchProperties() {
    try {
      const response = await fetch('/api/properties');
      const data = await response.json();
      return data;
    } catch (error) {
      console.error('Error fetching properties:', error);
      return [];
    }
  }
};