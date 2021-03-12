function validateForm(recieved) {
    var firstName = recieved.fName.value;
    var lastName = recieved.lName.value;
    var phoneNumber = recieved.pNumber.value;
    var amountPeople = recieved.aPeople.value;

    alert(firstName);
    alert(lastName);
    alert(phoneNumber);
    alert(amountPeople);
    return true;
  }