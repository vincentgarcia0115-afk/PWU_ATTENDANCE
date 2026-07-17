$(document).ready(function () {

    $('#studentsTable').DataTable({
        pageLength: 10,

        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ],

        order: [[1, 'asc']],

        language: {
            search: "Search Student:",
            lengthMenu: "Show _MENU_ students",
            info: "Showing _START_ to _END_ of _TOTAL_ students",
            paginate: {
                previous: "Previous",
                next: "Next"
            },
            zeroRecords: "No matching student found"
        }
    });

    const modal = document.getElementById("editModal");
    const closeBtn = document.querySelector(".close");

    document.querySelectorAll(".edit-btn").forEach(button => {

        button.addEventListener("click", function () {

            document.getElementById("edit_id").value = this.dataset.id;
            document.getElementById("edit_first").value = this.dataset.first;
            document.getElementById("edit_middle").value = this.dataset.middle;
            document.getElementById("edit_last").value = this.dataset.last;
            document.getElementById("edit_course").value = this.dataset.course;
            document.getElementById("edit_year").value = this.dataset.year;
            document.getElementById("edit_spreadsheet").value = this.dataset.spreadsheet;

            modal.style.display = "flex";
        });

    });

    closeBtn.onclick = function () {
        modal.style.display = "none";
    };

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

});

document.querySelectorAll(".view-qr").forEach(button => {

    button.addEventListener("click", function(){

        const studentNumber = this.dataset.student;
        const studentName = this.dataset.name;
        const qrValue = this.dataset.qr;

        document.getElementById("qrStudentName").innerText =
            studentName;

        document.getElementById("qrStudentNumber").innerText =
            studentNumber;

        document.getElementById("studentQRImage").src =
            "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data="
            + encodeURIComponent(qrValue);

        document.getElementById("qrModal").style.display =
            "flex";
    });

});

document.querySelector(".close-qr").onclick = function(){
    document.getElementById("qrModal").style.display = "none";
}

window.onclick = function(event){
    const modal = document.getElementById("qrModal");

    if(event.target === modal){
        modal.style.display = "none";
    }
}