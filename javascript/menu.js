// Dropdown menu:
window.addEventListener("load", function () {
  const dropdownBtn = document.querySelector("#dropdown-btn"),
    dropdownMenu = document.querySelector("#dropdown-menu");

  dropdownBtn.addEventListener("click", function () {
    dropdownMenu.classList.toggle("hide");
  });
});

// Searchbar:
const searchBar = document.getElementById('search-bar');
const cards = document.querySelectorAll('.card');

searchBar.addEventListener('keyup', () => {
  const searchText = searchBar.value.toLowerCase();
  cards.forEach(card => {
    const cardText = card.textContent.toLowerCase();
    if (cardText.includes(searchText)) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
});

// Image upload:
function submitBtn() {
  let input = document.createElement('input');
  input.type = 'file';
  input.onchange = _ => {
    let files = Array.from(input.files);
    input.log(files);
  };
  input.click();

}



