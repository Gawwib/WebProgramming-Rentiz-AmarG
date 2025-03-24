function loadPage(page) {
  fetch(`views/${page}.html`)
      .then(response => {
          if (!response.ok) {
              throw new Error(`Page not found: ${page}`);
          }
          return response.text();
      })
      .then(html => {
          document.getElementById("content").innerHTML = html;

          // Reset and apply page-specific classes
          document.body.className = ""; // Reset any previous class
          

      })
      .catch(error => {
          console.error("Error loading page:", error);
      });
}

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
