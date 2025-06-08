const PropertyView = {
  render(properties) {
    const container = $('#propertyList');
    container.empty();

    properties.forEach(property => {
      const propertyHTML = `
        <div class="property-card">
          <h3>${property.title}</h3>
          <p>${property.description}</p>
        </div>`;
      container.append(propertyHTML);
    });
  }
};