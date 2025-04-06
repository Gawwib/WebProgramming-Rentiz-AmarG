function loadPage(page) {
    fetch(`views/${page}.html`)
      .then(response => {
        if (!response.ok) throw new Error(`Page not found: ${page}`);
        return response.text();
      })
      .then(html => {
        document.getElementById("content").innerHTML = html;
  
        // Wait for DOM to be ready
        setTimeout(() => {
          if (typeof window.pageInit === "function") {
            window.pageInit(page);
          }
        }, 100); // tiny delay to ensure elements exist
      })
      .catch(error => console.error("Error loading page:", error));
  }
  
  window.onload = function () {
    let page = window.location.hash.substring(1);
  
    if (!page) {
      // 👇 This forces redirect to #home (which triggers hashchange)
      window.location.hash = "#home";
      return;
    }
  
    loadPage(page);
  };
  
  
  window.onhashchange = function () {
    const page = window.location.hash.substring(1);
    loadPage(page);
  };
  

// Load the correct page on refresh or first visit
window.onload = function () {
  let page = window.location.hash.substring(1);
  if (!page) {
      page = "#home";
  }
  loadPage(page);
};

// Change page on hash change (when user clicks nav)
window.onhashchange = function () {
  const page = window.location.hash.substring(1);
  loadPage(page);
};
