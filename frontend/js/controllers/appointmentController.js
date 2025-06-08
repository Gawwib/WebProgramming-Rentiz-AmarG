const AppointmentController = {
  async loadAppointments() {
    try {
      const appointments = await AppointmentService.fetchAppointments();
      AppointmentModel.setAppointments(appointments);
      AppointmentView.render(AppointmentModel.getAppointments());
    } catch (err) {
      console.error(err);
    }
  },

  async bookAppointment(appointment) {
    try {
      await AppointmentService.bookAppointment(appointment);
      AppointmentView.showBookingSuccess();
      // Optionally reload appointments
    } catch (err) {
      AppointmentView.showBookingError(err);
    }
  }
};
