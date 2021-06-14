/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';
import $ from 'jquery';

// var contactSubmit = document.getElementById('contact_form_submit');

// contactSubmit.onclick = clearContactInputText();

// function clearContactInputText(){
//   var contactInputs = document.getElementsByClassName('contact_form');
//   for (var i = 0; i < contactInputs.length; i++) {
//     contactInputs[i].value = "";
//   }
// }

var downloaderSubmit = document.getElementById('video_download_submit');

downloaderSubmit.onclick = clearDownloaderInputText();
downloaderSubmit.onclick = changeButtonText();

function clearDownloaderInputText(){
  var downloaderInput = document.getElementById('video_download_input');
  if (downloaderInput.defaultValue==downloaderInput.value){
    downloaderInput.value = "";
  };
}

function changeButtonText(){
  if (localStorage.getItem("clicks") === null) {
    localStorage.clicks = '0';
  };
  var count = parseInt(localStorage.getItem('clicks'));

  switch (count) {
    case 0:
      submit.innerText = "Add another one!";
      localStorage.clicks = '1';
      break;
    case 1:
      submit.innerText = "And another one!";
      localStorage.clicks = '2'
      break;
    case 2:
      submit.innerText = "Aaand another one!";
      localStorage.clicks = '3'
      break;
    case 3:
      submit.innerText = "Moooreee links...";
      localStorage.clicks = '4'
      break;
    case 4:
      submit.innerText = "Feed me with links!";
      localStorage.clicks = '5'
      break;
    case 5:
      submit.innerText = "Put it in my input";
      localStorage.clicks = '6'
      break;
    case 6:
      submit.innerText = "I have enough... Kidding!";
      localStorage.clicks = '7'
      break;
    case 7:
      submit.innerText = "Links and I are one!";
      localStorage.clicks = '8'
      break;
    case 8:
      submit.innerText = "One more time!";
      localStorage.clicks = '0'
      break;
    }
  }

  // Get the modal
var modal = document.getElementById('delete');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}