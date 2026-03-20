

document.addEventListener("DOMContentLoaded", function () {

fetch("components/header.html")
.then(res => res.text())
.then(data => {
  document.getElementById("header").innerHTML = data;

  // Attach event AFTER loading header
  const btn = document.getElementById("menuBtn");
  if (btn) {
    btn.addEventListener("click", () => {
      document.getElementById("mobileMenu").classList.toggle("hidden");
    });
  }
});

fetch("components/footer.html")
.then(res => res.text())
.then(data => document.getElementById("footer").innerHTML = data);

});