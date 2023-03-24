window.addEventListener("load", function () {
    const dropdownBtn = document.querySelector("#dropdown-btn"),
        dropdownMenu = document.querySelector("#dropdown-menu");

    dropdownBtn.addEventListener("click", function () {
        dropdownMenu.classList.toggle("hide");
    });
});
