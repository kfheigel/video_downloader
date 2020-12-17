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

document.getElementById("video_download_submit").onclick = clearInputText();

function clearInputText(){
  var input = document.getElementById('video_download_input');

  if (input.defaultValue==input.value){
    input.value = "";
  }
}

// localStorage.clicks = '0';
// document.getElementById("video_download_submit").onclick = changeButtonText();

// function changeButtonText(){
//   var submit = document.getElementById('video_download_submit');
//   var count = parseInt(localStorage.getItem('clicks'));

//   alert(count);
//   switch (count) {
//     case 1:
//       submit.innerText = "Add another one!";
//       localStorage.setItem("clicks", ++count);
//       break;
//     case 2:
//       submit.innerText = "And another one!";
//       localStorage.setItem("clicks", ++count);
//       break;
//     case 3:
//       submit.innerText = "Aaand another one!";
//       localStorage.setItem("clicks", ++count);
//       break;
//     case 4:
//       submit.innerText = "Moooreee";
//       localStorage.setItem("clicks", ++count);
//       break;
//     default:
//       submit.innerText = "Show me the links!";
//       localStorage.clear();
//   }
// }


// document.onload = restoreButtonText();

// function restoreButtonText(){
//   document.getElementById('video_download_submit').innerText = 'Show me the links!';
// }

