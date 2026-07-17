
$(document).ready(function(){

    $('#studentsTable').DataTable({

        pageLength: 10,

        lengthMenu: [
            [10,25,50,100,-1],
            [10,25,50,100,"All"]
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

});
