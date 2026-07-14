document.addEventListener("DOMContentLoaded", function () {

    const search = document.getElementById("searchEmployee");

    if (!search) return;

    search.addEventListener("keyup", function () {

        let value = this.value.toLowerCase();

        let rows = document.querySelectorAll("#employeeTable tbody tr");

        rows.forEach(function(row){

            row.style.display = row.innerText.toLowerCase().includes(value)

            ? ""

            : "none";

        });

    });

});