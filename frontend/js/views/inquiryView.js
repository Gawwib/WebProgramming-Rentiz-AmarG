const InquiryView = {
  render(inquiries) {
    const container = $('#inquiryList');
    container.empty();
    inquiries.forEach(inquiry => {
      const html = `
        <div class="inquiry-card">
          <h5>${inquiry.subject}</h5>
          <p>${inquiry.message}</p>
        </div>
      `;
      container.append(html);
    });
  },

  showSubmitSuccess() {
    alert('Inquiry submitted successfully!');
  },

  showSubmitError(error) {
    alert('Error submitting inquiry: ' + error);
  }
};
