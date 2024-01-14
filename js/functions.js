// Mostar mensaje js
function showMessage(message) {
  var messageContainer = document.getElementById('message')

  messageContainer.style.display = 'block'

  messageContainer.innerText = message

  setTimeout(function () {
    messageContainer.style.display = 'none'
  }, 3000)  // Ocultar el mensaje después de 3 segundos
}
