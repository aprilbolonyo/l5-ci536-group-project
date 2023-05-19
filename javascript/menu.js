window.addEventListener("load", function () {
    const dropdownBtn = document.querySelector("#dropdown-btn"),
        dropdownMenu = document.querySelector("#dropdown-menu");

    dropdownBtn.addEventListener("click", function () {
        dropdownMenu.classList.toggle("hide");
    });
});

// <!-- HOPEFULLY SCRIPT TO CREATE SEARCHBAR  -->


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

