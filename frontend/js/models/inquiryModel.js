const InquiryModel = {
  inquiries: [],

  setInquiries(data) {
    this.inquiries = data;
  },

  getInquiries() {
    return this.inquiries;
  }
};
