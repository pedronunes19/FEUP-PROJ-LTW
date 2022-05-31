function address_requirement_toggle() {
    let type_val = document.getElementById("account-type").value;
    let val = document.getElementById("requirement-toggle-field").value;
    if ((type_val == "customer") && (val == "")){
        alert("Address is required when creating a customer account!");
        return false;
    }
    else {
        return true;
    }
}