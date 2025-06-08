const PropertyController = {
  async init() {
    const properties = await PropertyService.fetchProperties();
    PropertyModel.setProperties(properties);
    PropertyView.render(PropertyModel.getProperties());
  }
};