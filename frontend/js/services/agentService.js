const AgentService = {
  async fetchAgents() {
    try {
      const response = await fetch('/api/agents');
      const data = await response.json();
      if (!response.ok) throw data.message || 'Error fetching agents';
      return data;
    } catch (error) {
      throw error;
    }
  },

  async updateAgent(agent) {
    try {
      const response = await fetch('/api/agents/' + agent.id, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(agent)
      });
      const data = await response.json();
      if (!response.ok) throw data.message || 'Error updating agent';
      return data;
    } catch (error) {
      throw error;
    }
  }
};
