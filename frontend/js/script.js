(function ($) {

  "use strict";

  const rangeInput = document.querySelectorAll(".range-input input"),
    priceInput = document.querySelectorAll(".price-input input"),
    range = document.querySelector(".slider .progress");
  let priceGap = 1000;

  priceInput.forEach((input) => {
    input.addEventListener("input", (e) => {
      let minPrice = parseInt(priceInput[0].value),
        maxPrice = parseInt(priceInput[1].value);

      if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
        if (e.target.className === "input-min") {
          rangeInput[0].value = minPrice;
          range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
        } else {
          rangeInput[1].value = maxPrice;
          range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
        }
      }
    });
  });


  rangeInput.forEach((input) => {
    input.addEventListener("input", (e) => {
      let minVal = parseInt(rangeInput[0].value),
        maxVal = parseInt(rangeInput[1].value);

      if (maxVal - minVal < priceGap) {
        if (e.target.className === "range-min") {
          rangeInput[0].value = maxVal - priceGap;
        } else {
          rangeInput[1].value = minVal + priceGap;
        }
      } else {
        priceInput[0].value = minVal;
        priceInput[1].value = maxVal;
        range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
        range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
      }
    });
  });

  // init Chocolat light box
  var initChocolat = function () {
    Chocolat(document.querySelectorAll('.image-link'), {
      imageSize: 'contain',
      loop: true,
    })
  }


  $(document).ready(function () {

    renderNavbar();

    // swiper
    var swiper = new Swiper(".residence-swiper", {
      slidesPerView: 3,
      spaceBetween: 30,
      freeMode: true,
      navigation: {
        nextEl: ".residence-swiper-next",
        prevEl: ".residence-swiper-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        300: {
          slidesPerView: 1,
          spaceBetween: 20,
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 30,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 30,
        },
      }
    });

    var swiper = new Swiper(".testimonial-swiper", {
      slidesPerView: 1,
      spaceBetween: 30,
      freeMode: true,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });

    // product single page
    var thumb_slider = new Swiper(".product-thumbnail-slider", {
      autoplay: true,
      loop: true,
      spaceBetween: 8,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
    });

    var large_slider = new Swiper(".product-large-slider", {
      autoplay: true,
      loop:true,
      spaceBetween: 10,
      effect: 'fade',
      thumbs: {
        swiper: thumb_slider,
      },
    });


    initChocolat();


  });


// Custom Logic for index.html

if (document.getElementById('searchForm')) {
  document.getElementById('searchForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const city = document.getElementById('location').value;
    const type = document.getElementById('type').value;

    const params = new URLSearchParams({ city, type });
    window.location.href = `properties.html?${params.toString()}`;
  });
}

// Custom Logic for propreties.html


// Store inquiries by property ID
const inquiriesByProperty = {};

function openPropertyPopup(title, details, image, price, id) {
  const modal = document.getElementById('propertyPopup');
  if (!modal) return;

  document.getElementById('propertyTitle').innerText = title;
  document.getElementById('propertyDetails').innerText = details;
  document.getElementById('propertyImage').src = image;
  document.getElementById('propertyPrice').innerText = `Price: $${price} / month`;

  // Set current property ID
  document.getElementById('currentPropertyId').value = id;

  // Load inquiries
  const inquiryList = document.getElementById('inquiryList');
  inquiryList.innerHTML = ''; 

  const inquiries = inquiriesByProperty[id] || [];
  inquiries.forEach(entry => {
    const div = document.createElement('div');
    div.className = 'border-bottom border-secondary pb-2 mb-2';
    div.innerHTML = `<strong>Customer:</strong> ${entry}<br><strong>Agent:</strong> (Awaiting reply...)`;
    inquiryList.appendChild(div);
  });

  const myModal = new bootstrap.Modal(modal);
  myModal.show();
}



document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('filterCity')) {
    document.getElementById('filterCity').addEventListener('change', filterProperties);
    document.getElementById('filterType').addEventListener('change', filterProperties);

    const params = new URLSearchParams(window.location.search);
    document.getElementById('filterCity').value = params.get('city') || 'all';
    document.getElementById('filterType').value = params.get('type') || 'all';

    filterProperties();
  }

  // Initialize dynamic popup data bindings
  document.querySelectorAll('.property-item').forEach(item => {
    const id = item.dataset.id;
    const title = item.dataset.title;
    const details = item.dataset.details;
    const image = item.dataset.image;
    const price = item.dataset.price;

    const card = item.querySelector('.open-popup');
    if (card) {
      card.addEventListener('click', () => {
        openPropertyPopup(title, details, image, price, id);
      });
    }
  });
});

window.pageInit = function (page) {

  
window.pageInit = async function (page) {
  if (page.toLowerCase() !== "adminpanel") return;

  const token = localStorage.getItem("token");
  const headers = { "Authorization": token };

  try {
    // Load users
    const usersRes = await fetch("http://localhost/WebProgramming-Rentiz/WebProgramming-Rentiz-AmarG/backend/users", { headers });
    const users = await usersRes.json();
    document.getElementById("users-table-body").innerHTML = users.map(user => `
      <tr>
        <td>${user.user_id}</td>
        <td>${user.first_name} ${user.last_name}</td>
        <td>${user.email}</td>
        <td>${user.role}</td>
        <td>
          <button class="btn btn-sm btn-warning" onclick="toggleUserRole(${user.user_id}, '${user.role}')">
            ${user.role === 'client' ? 'Promote to Agent' : 'Demote to Client'}
          </button>
          <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.user_id})">Delete</button>
        </td>
      </tr>
    `).join("");

    // Load inquiries
    const inquiriesRes = await fetch("http://localhost/WebProgramming-Rentiz/WebProgramming-Rentiz-AmarG/backend/inquiries", { headers });
    const inquiries = await inquiriesRes.json();
    document.getElementById("inquiries-table-body").innerHTML = inquiries.map(q => `
      <tr>
        <td>${q.inquiry_id}</td>
        <td>${q.property_id}</td>
        <td>${q.user_id}</td>
        <td>${q.question}</td>
        <td>${q.answer || ''}</td>
        <td>
          <button class="btn btn-sm btn-success" onclick="answerInquiry(${q.inquiry_id})">Answer</button>
          <button class="btn btn-sm btn-danger" onclick="deleteInquiry(${q.inquiry_id})">Delete</button>
        </td>
      </tr>
    `).join("");

    // Load properties
    const propertiesRes = await fetch("http://localhost/WebProgramming-Rentiz/WebProgramming-Rentiz-AmarG/backend/properties", { headers });
    const properties = await propertiesRes.json();

    // Stats
    document.getElementById("total-clients").innerText = users.filter(u => u.role === 'client').length;
    document.getElementById("total-properties").innerText = properties.length;
    document.getElementById("total-inquiries").innerText = inquiries.length;

  } catch (err) {
    console.error("❌ Admin panel error:", err);
    alert("An error occurred while loading admin panel data.");
  }
};

window.toggleUserRole = async function (id, currentRole) {
  const token = localStorage.getItem("token");

  // Step 1: Get the current user data
  const res = await fetch(`http://localhost/WebProgramming-Rentiz/WebProgramming-Rentiz-AmarG/backend/users/${id}`, {
    headers: { Authorization: token }
  });
  const user = await res.json();

  // Step 2: Toggle role
  const newRole = currentRole === "client" ? "agent" : "client";

  const updatedUser = {
    first_name: user.first_name,
    last_name: user.last_name,
    email: user.email,
    phone_number: user.phone_number,
    role: newRole
  };

  await fetch(`http://localhost/WebProgramming-Rentiz/WebProgramming-Rentiz-AmarG/backend/users/${id}`, {
    method: "PUT",
    headers: {
      "Authorization": token,
      "Content-Type": "application/json"
    },
    body: JSON.stringify(updatedUser)
  });

  alert(`✅ User role updated to ${newRole}.`);
  window.location.reload();
};



// Delete user
window.deleteUser = async function (id) {
  const token = localStorage.getItem("token");
  await fetch(`http://localhost/WebProgramming-Rentiz/WebProgramming-Rentiz-AmarG/backend/users/${id}`, {
    method: "DELETE",
    headers: { "Authorization": token }
  });
  alert("🗑️ User deleted.");
  window.location.reload();
};

// Delete inquiry
window.deleteInquiry = async function (id) {
  const token = localStorage.getItem("token");
  await fetch(`http://localhost/WebProgramming-Rentiz/WebProgramming-Rentiz-AmarG/backend/inquiries/${id}`, {
    method: "DELETE",
    headers: { "Authorization": token }
  });
  alert("🗑️ Inquiry deleted.");
  window.location.reload();
};

// Answer inquiry
window.answerInquiry = async function (id) {
  const answer = prompt("Type your answer to this inquiry:");
  if (!answer) return;
  const token = localStorage.getItem("token");

  await fetch(`http://localhost/WebProgramming-Rentiz/WebProgramming-Rentiz-AmarG/backend/inquiries/${id}`, {
    method: "PUT",
    headers: {
      "Authorization": token,
      "Content-Type": "application/json"
    },
    body: JSON.stringify({ answer })
  });

  alert("✅ Answer saved.");
  window.location.reload();
};


// SIGNUP PAGE
if (page === "signup") {
  console.log("✅ signup page detected");

  const form = document.querySelector('form');
  console.log("Signup form found:", !!form);

  if (form) {
    form.addEventListener('submit', async function (e) {
      e.preventDefault();

      const firstName = document.getElementById('firstName').value.trim();
      const lastName = document.getElementById('lastName').value.trim();
      const phone = document.getElementById('phone').value.trim();
      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value.trim();
      const confirmPassword = document.getElementById('confirmPassword').value.trim();
      const agree = document.getElementById('agree').checked;

      if (!firstName || !lastName || !email || !password || !confirmPassword || !phone || !agree) {
        alert('Please fill all fields and agree to the privacy policy.');
        return;
      }

      if (password !== confirmPassword) {
        alert('Passwords do not match.');
        return;
      }

      const data = {
        first_name: firstName,
        last_name: lastName,
        email,
        password,
        phone_number: phone,
        role: 'client' // Always client by default
      };

      console.log("📤 Sending signup data:", data);

      try {
        const res = await fetch('http://localhost/WebProgramming-Rentiz/WebProgramming-Rentiz-AmarG/backend/auth/register', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(data)
        });

        if (!res.ok) throw new Error('Registration failed');

        const result = await res.json();
        console.log("✅ Signup success:", result);
        alert('✅ Registered successfully!');
        window.location.hash = '#login';
      } catch (err) {
        console.error("❌ Signup error:", err);
        alert('❌ ' + err.message);
      }
    });
  }
}

// LOGIN PAGE
if (page === "login") {
  console.log("✅ login page detected");

  const form = document.querySelector('form');
  console.log("Login form found:", !!form);

  if (form) {
    form.addEventListener('submit', async function (e) {
      e.preventDefault();

      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value.trim();

      if (!email || !password) {
        alert("Please enter both email and password.");
        return;
      }

      console.log("📤 Logging in with:", { email, password });

      try {
        const res = await fetch('http://localhost/WebProgramming-Rentiz/WebProgramming-Rentiz-AmarG/backend/auth/login', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ email, password })
        });

        if (!res.ok) throw new Error("Login failed");

        const result = await res.json();
        console.log("✅ Login response:", result);

        localStorage.setItem("token", result.token);
        localStorage.setItem("user", JSON.stringify(result.user));

        console.log("📦 Token saved:", result.token);
        console.log("👤 User saved:", result.user);
        renderNavbar();
        alert("✅ Login successful!");
        location.href = location.origin + location.pathname + '?ts=' + Date.now() + '#home';
      } catch (err) {
        console.error("❌ Login error:", err);
        alert("❌ " + err.message);
      }
    });
  }
}





  // PROPERTIES PAGE
if (page.toLowerCase() === "properties") {
  const citySelect = document.getElementById('filterCity');
  const typeSelect = document.getElementById('filterType');

  function filterProperties() {
    const city = citySelect?.value || 'all';
    const type = typeSelect?.value || 'all';
    document.querySelectorAll('.property-item').forEach(property => {
      const match = (city === 'all' || city === property.dataset.city) &&
                    (type === 'all' || type === property.dataset.type);
      property.style.display = match ? 'block' : 'none';
    });
  }

  if (citySelect && typeSelect) {
    citySelect.addEventListener('change', filterProperties);
    typeSelect.addEventListener('change', filterProperties);
    filterProperties();
  }

  // Dynamically bind popup opening on SPA load
  document.querySelectorAll('.property-item').forEach(item => {
    const id = item.dataset.id;
    const title = item.dataset.title;
    const details = item.dataset.details;
    const image = item.dataset.image;
    const price = item.dataset.price;

    const card = item.querySelector('.open-popup');
    if (card) {
      card.addEventListener('click', () => {
        openPropertyPopup(title, details, image, price, id);
      });
    }
  });
}

  const inquiryForm = document.querySelector('#propertyPopup form[onsubmit]');
if (inquiryForm) {
  inquiryForm.addEventListener('submit', submitInquiry);
}


 async function submitInquiry(event) {
  event.preventDefault();

  const question = document.getElementById("userQuestion").value.trim();
  const propertyId = document.getElementById("currentPropertyId").value;
  const token = localStorage.getItem("token");
  const user = JSON.parse(localStorage.getItem("user"));

  if (!question || !propertyId || !user || !token) {
    alert("❌ Please log in and fill out the question.");
    return;
  }

  try {
    const res = await fetch("http://localhost/WebProgramming-Rentiz/WebProgramming-Rentiz-AmarG/backend/inquiries", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Authorization": token
      },
      body: JSON.stringify({
        user_id: user.user_id,
        property_id: propertyId,
        question: question,
        answer: null
      })
    });

    if (!res.ok) throw new Error("Failed to submit inquiry");

    // Optional: Show immediately in UI
    const inquiryList = document.getElementById("inquiryList");
    const div = document.createElement("div");
    div.className = "border-bottom border-secondary pb-2 mb-2";
    div.innerHTML = `<strong>Customer:</strong> ${question}<br><strong>Agent:</strong> (Awaiting reply...)`;
    inquiryList.appendChild(div);

    document.getElementById("userQuestion").value = "";
    alert("✅ Inquiry submitted");
  } catch (err) {
    alert("❌ Error submitting inquiry: " + err.message);
  }
}


const appointmentForm = document.querySelector('#propertyPopup form:last-of-type');
if (appointmentForm) {
  appointmentForm.addEventListener("submit", async function (e) {
    e.preventDefault();

    const visitDate = document.getElementById("visitDate").value;
    const visitTime = document.getElementById("visitTime").value;
    const propertyId = document.getElementById("currentPropertyId").value;
    const user = JSON.parse(localStorage.getItem("user"));
    const token = localStorage.getItem("token");

    if (!user || !visitDate || !visitTime || !propertyId) {
      alert("❌ Please log in and fill all fields.");
      return;
    }

    try {
      const res = await fetch("http://localhost/WebProgramming-Rentiz/WebProgramming-Rentiz-AmarG/backend/appointments", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Authorization": token
        },
        body: JSON.stringify({
          property_id: propertyId,
          user_id: user.user_id,
          date: visitDate,
          time: visitTime
        })
      });

      if (!res.ok) throw new Error("Booking failed");

      alert("✅ Appointment booked!");
      appointmentForm.reset();
    } catch (err) {
      alert("❌ Error booking: " + err.message);
    }
  });
}



  

  // You can add more: if (page === 'contact') { ... }
};

function renderNavbar() {
  const user = JSON.parse(localStorage.getItem('user'));
  const nav = document.getElementById('dynamic-nav');
  nav.innerHTML = '';

  const links = [
    { label: 'Home', href: '#home' },
    { label: 'Properties', href: '#properties' },
    { label: 'About', href: '#about' },
    { label: 'Contact', href: '#contact' }
  ];

  links.forEach(link => {
    const li = document.createElement('li');
    li.classList.add('nav-item');
    li.innerHTML = `<a class="nav-link me-md-4" href="${link.href}">${link.label}</a>`;
    nav.appendChild(li);
  });

  if (!user) {
    // Not logged in
    nav.innerHTML += `
      <li class="nav-item"><a class="nav-link mx-md-4" href="#login">Login</a></li>
      <li class="nav-item"><a class="btn-medium btn btn-primary" href="#signup">Sign Up</a></li>
    `;
  } else {
    // Logged in
    if (user.role === 'agent') {
      nav.innerHTML += `
        <li class="nav-item"><a class="nav-link me-md-4" href="#AdminPanel">Admin Panel</a></li>
      `;
    }

        nav.innerHTML += `
      <li class="nav-item">
        <a class="btn btn-danger" href="#" onclick="logout()">Logout</a>
      </li>
    `;

  }
}


function logout() {
  // Remove session data
  localStorage.removeItem('token');
  localStorage.removeItem('user');

  alert('👋 You have been logged out.');

  // Force full hard reload to home (bypass cache)
  location.replace(location.origin + location.pathname + '?nocache=' + Date.now() + '#home');
  renderNavbar();
}



window.addEventListener('load', renderNavbar);
window.logout = logout;




})(jQuery);