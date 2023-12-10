// script.js

document.addEventListener("DOMContentLoaded", function () {
    const calendarContainer = document.getElementById("calendar-container");

    function generateCalendar() {
        const currentDate = new Date();
        const currentMonth = currentDate.getMonth();
        const currentYear = currentDate.getFullYear();

        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

        const calendarTable = document.createElement("table");
        calendarTable.classList.add("calendar");

        // Add a caption with the month and year
        const caption = calendarTable.createCaption();
        caption.textContent = new Intl.DateTimeFormat("en-US", { month: "long", year: "numeric" }).format(currentDate);

        const headerRow = calendarTable.createTHead().insertRow();
        const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        daysOfWeek.forEach((day) => {
            const th = document.createElement("th");
            th.textContent = day;
            headerRow.appendChild(th);
        });

        const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay();

        let dayCount = 1;

        for (let i = 0; i < 6; i++) {
            const row = calendarTable.insertRow();

            for (let j = 0; j < 7; j++) {
                if (i === 0 && j < firstDayOfMonth) {
                    const emptyCell = row.insertCell();
                    emptyCell.textContent = "";
                } else if (dayCount <= daysInMonth) {
                    const cell = row.insertCell();
                    cell.textContent = dayCount;
                    dayCount++;
                }
            }
        }

        calendarContainer.innerHTML = "";
        calendarContainer.appendChild(calendarTable);
    }

    generateCalendar();
});
