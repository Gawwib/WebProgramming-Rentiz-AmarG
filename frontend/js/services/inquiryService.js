const InquiryService = {
  async fetchInquiries() {
    try {
      const response = await fetch('/api/inquiries');
      const data = await response.json();
      if (!response.ok) throw data.message || 'Error fetching inquiries';
      return data;
    } catch (error) {
      throw error;
    }
  },

  async submitInquiry(inquiry) {
    try {
      const response = await fetch('/api/inquiries', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(inquiry)
      });
      const data = await response.json();
      if (!response.ok) throw data.message || 'Error submitting inquiry';
      return data;
    } catch (error) {
      throw error;
    }
  }
};
