var password = document.getElementById("password")
var confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Lösenorden är inte identiska");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;


function check_selected() {
  var selector = document.getElementById('delUser');
  var value = selector[selector.selectedIndex].value;
  if (value.length > 0) {
    document.getElementById('button_select').disabled = false;
  } else {
    document.getElementById('button_select').disabled = true;
  }
}