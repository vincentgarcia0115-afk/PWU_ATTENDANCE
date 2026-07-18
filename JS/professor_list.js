

function openEditModal(
id,
employee,
first,
middle,
last,
email,
phone
){


document.getElementById("editModal").style.display="flex";


document.getElementById("edit_id").value=id;

document.getElementById("edit_employee").value=employee;

document.getElementById("edit_first").value=first;

document.getElementById("edit_middle").value=middle;

document.getElementById("edit_last").value=last;

document.getElementById("edit_email").value=email;

document.getElementById("edit_phone").value=phone;


}




function closeEditModal(){

document.getElementById("editModal").style.display="none";

}


