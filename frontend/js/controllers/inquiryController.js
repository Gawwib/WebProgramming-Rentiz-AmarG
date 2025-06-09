const InquiryController = {
  async loadInquiries() {
    try {
      const inquiries = await InquiryService.fetchInquiries();
      InquiryModel.setInquiries(inquiries);
      InquiryView.render(InquiryModel.getInquiries());
    } catch (err) {
      console.error(err);
    }
  },

  async submitInquiry(inquiry) {
    try {
      await InquiryService.submitInquiry(inquiry);
      InquiryView.showSubmitSuccess();
      // Optionally reload or update inquiries
    } catch (err) {
      InquiryView.showSubmitError(err);
    }
  }
};
