window.addEventListener('DOMContentLoaded', (event) => {
    getCurrentDate();
});

function getCurrentDate() {
    let currentDate = new Date();
    let datePicker = document.getElementById("datePicker");

    let year = currentDate.getFullYear();
    let month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
    let day = currentDate.getDate().toString().padStart(2, '0');

    datePicker.value = `${year}-${month}-${day}`;
}