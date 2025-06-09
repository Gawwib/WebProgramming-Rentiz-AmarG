const AgentController = {
  async loadAgents() {
    try {
      const agents = await AgentService.fetchAgents();
      AgentModel.setAgents(agents);
      AgentView.render(AgentModel.getAgents());
    } catch (err) {
      console.error(err);
    }
  },

  async updateAgent(agent) {
    try {
      await AgentService.updateAgent(agent);
      AgentView.showUpdateSuccess();
      // Optionally reload agents
    } catch (err) {
      AgentView.showUpdateError(err);
    }
  }
};
