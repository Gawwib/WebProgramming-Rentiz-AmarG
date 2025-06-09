const AppointmentModel = {
  appointments: [],

  setAppointments(data) {
    this.appointments = data;
  },

  getAppointments() {
    return this.appointments;
  }
};
