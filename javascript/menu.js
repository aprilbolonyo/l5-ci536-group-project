// Dropdown menu:
window.addEventListener("load", function () {
  const dropdownBtn = document.querySelector("#dropdown-btn"),
    dropdownMenu = document.querySelector("#dropdown-menu");

  dropdownBtn.addEventListener("click", function () {
    dropdownMenu.classList.toggle("hide");
  });
  window.addEventListener("click", function(event) {
        if (!dropdownBtn.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add("hide");
        }
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

function transferData(idItemName, idPrice, idName, idRating, idLocation, idInfo, idPicture, idPhone) {
  var data = idItemName + '|' + idPrice + '|' + idName + '|' + idRating + '|' + idLocation + '|' + idInfo + '|' + idPicture + '|' + idPhone;
  window.location.href = 'itemInfo.html?data=' + encodeURIComponent(data);
}


window.addEventListener('DOMContentLoaded', function() {
  var urlParams = new URLSearchParams(window.location.search);
  var data = urlParams.get('data');

  if (data) {
    var values = data.split('|');
    var idItemName = values[0];
    var idPrice = values[1];
    var idName = values[2];
    var idRating = values[3];
    var idLocation = values[4];
    var idInfo = values[5];
    var idPicture = values[6];
    var idPhone = values[7];

    // Update the headings with the values
    document.getElementById('itemName').textContent = idItemName;
    document.getElementById('itemPrice').textContent = idPrice;
    document.getElementById('sellerName').textContent = idName;
    document.getElementById('itemRating').textContent = idRating;
    document.getElementById('itemLocation').textContent = idLocation;
    document.getElementById('itemInfo').textContent = idInfo;
    var itemImage = document.getElementById('itemImage');
    itemImage.innerHTML = "<img src='" + idPicture + "'>";
    document.getElementById('sellerPhone').textContent = idPhone;
  }
});

