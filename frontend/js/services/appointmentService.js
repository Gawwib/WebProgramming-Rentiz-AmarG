const AppointmentService = {
  async fetchAppointments() {
    try {
      const response = await fetch('/api/appointments');
      const data = await response.json();
      if (!response.ok) throw data.message || 'Error fetching appointments';
      return data;
    } catch (error) {
      throw error;
    }
  },

  async bookAppointment(appointment) {
    try {
      const response = await fetch('/api/appointments', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(appointment)
      });
      const data = await response.json();
      if (!response.ok) throw data.message || 'Error booking appointment';
      return data;
    } catch (error) {
      throw error;
    }
  }
};
