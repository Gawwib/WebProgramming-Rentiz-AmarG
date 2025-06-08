const AgentView = {
  render(agents) {
    const container = $('#agentList');
    container.empty();
    agents.forEach(agent => {
      const html = `
        <div class="agent-card">
          <h5>${agent.name}</h5>
          <p>Email: ${agent.email}</p>
          <p>Phone: ${agent.phone}</p>
        </div>
      `;
      container.append(html);
    });
  },

  showUpdateSuccess() {
    alert('Agent updated successfully!');
  },

  showUpdateError(error) {
    alert('Error updating agent: ' + error);
  }
};
