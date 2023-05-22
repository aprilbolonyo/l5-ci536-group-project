
function displayThankYou() {
    var thankYouMessage = document.createElement("div");
    thankYouMessage.className = "thank-you-message";
    thankYouMessage.textContent = "Thanks for your order!";
    document.body.appendChild(thankYouMessage);
  
    setTimeout(function() {
      document.body.removeChild(thankYouMessage);
    }, 3000);
  }
  
  var payLaterButton = document.querySelector('input[value="Order now, pay later (Cash)"]');
  payLaterButton.addEventListener("click", function(event) {
    event.preventDefault(); 
    displayThankYou();
  });