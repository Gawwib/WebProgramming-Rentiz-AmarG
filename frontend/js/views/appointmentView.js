const AppointmentView = {
  render(appointments) {
    const container = $('#appointmentList');
    container.empty();
    appointments.forEach(appointment => {
      const html = `
        <div class="appointment-card">
          <h5>${appointment.date}</h5>
          <p>${appointment.property_name}</p>
        </div>
      `;
      container.append(html);
    });
  },

  showBookingSuccess() {
    alert('Appointment booked successfully!');
  },

  showBookingError(error) {
    alert('Error booking appointment: ' + error);
  }
};
