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
  var selector = document.getElementById('delAcount');
  var value = selector[selector.selectedIndex].value;
  if (value.length > 0) {
    document.getElementById('button_select').disabled = false;
  } else {
    document.getElementById('button_select').disabled = true;
  }
}

function checkSelectedMulti(){
  var selector = document.getElementById('fromKonto');
  var value = selector[selector.selectedIndex].value;

  var selector2 = document.getElementById('toKonto');
  var value2 = selector2[selector2.selectedIndex].value;

  //var value3 = document.getElementById("summa").value;
  
  if (value.length > 0 && value2.length > 0 && value != value2){
    document.getElementById('transfer').disabled = false;
  } else {
    document.getElementById('transfer').disabled = true;
  }
}

function selectAccount(){
  var selector = document.getElementById('accountSelect');
  var value = selector[selector.selectedIndex].value;
  window.location.replace(`bank.php?updateActiveAccount=${value}`);
}