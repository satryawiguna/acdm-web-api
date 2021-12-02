let today = new Date();

let months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
let arrCalendar = [];

let prevMonth = today.getMonth() - 1;
let currentMonth = today.getMonth();
let nextMonth = today.getMonth() + 1;

let prevYear = (currentMonth === 0) ? today.getFullYear() - 1 : today.getFullYear();
let currentYear = today.getFullYear();
let nextYear = (currentMonth === 11) ? today.getFullYear() + 1 : today.getFullYear();

let prevMonthAndYear = document.getElementById("prevMonthAndYear");
let currentMonthAndYear = document.getElementById("currentMonthAndYear");
let nextMonthAndYear = document.getElementById("nextMonthAndYear");

arrCalendar.push({
        month: prevMonth,
        year: prevYear,
        month_and_year: prevMonthAndYear
    }, {
        month: currentMonth,
        year: currentYear,
        month_and_year: currentMonthAndYear
    }, {
        month: nextMonth,
        year: nextYear,
        month_and_year: nextMonthAndYear
    });

showCalendar(arrCalendar);

function next() {
    for (let i = 0; i < arrCalendar.length; i++) {
        arrCalendar[i].year = (arrCalendar[i].month === 11) ? arrCalendar[i].year + 1 : arrCalendar[i].year;
        arrCalendar[i].month = (arrCalendar[i].month + 1) % 12;
    }

    showCalendar(arrCalendar);
}

function previous() {
    for (let i = 0; i < arrCalendar.length; i++) {
        arrCalendar[i].year = (arrCalendar[i].month === 0) ? arrCalendar[i].year - 1 : arrCalendar[i].year;
        arrCalendar[i].month = (arrCalendar[i].month === 0) ? 11 : arrCalendar[i].month - 1;
    }

    showCalendar(arrCalendar);
}

function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';

    hours = hours % 12;
    hours = hours ? hours : 12;
    minutes = minutes < 10 ? '0'+minutes : minutes;

    var strTime = hours + ':' + minutes + ampm;

    return strTime;
}

function showCalendar(arrCalendar) {
    for (let x = 0; x < arrCalendar.length; x++) {
        let tbl = document.getElementById("calendar-body-" + x);

        tbl.innerHTML = "";

        let firstDay = (new Date(arrCalendar[x].year, arrCalendar[x].month)).getDay();
        let daysInMonth = 32 - new Date(arrCalendar[x].year, arrCalendar[x].month, 32).getDate();

        arrCalendar[x].month_and_year.innerHTML = months[arrCalendar[x].month] + " " + arrCalendar[x].year;

        let date = 1;

        for (let i = 0; i < 6; i++) {
            let row = document.createElement("tr");

            for (let j = 0; j < 7; j++) {
                if (i === 0 && j < firstDay) {
                    let cell = document.createElement("td");
                    let cellText = document.createTextNode("");

                    cell.appendChild(cellText);
                    row.appendChild(cell);
                } else if (date > daysInMonth) {
                    break;
                } else {
                    let node = document.createElement("a");
                    let cell = document.createElement("td");
                    let cellText = document.createTextNode(date);

                    if (date === today.getDate() && arrCalendar[x].year === today.getFullYear() && arrCalendar[x].month === today.getMonth()) {
                        cell.classList.add("current-date");
                    }

                    node.setAttribute('href', '#');
                    node.setAttribute('data-toggle', 'modal');
                    node.setAttribute('data-target', '#dialogModal');
                    node.setAttribute('data-date', date + '/' + (parseInt(arrCalendar[x].month) + 1) + '/' + arrCalendar[x].year + ' ' + formatAMPM(new Date()));
                    node.appendChild(cellText);

                    cell.setAttribute('style', 'text-align: center;');
                    cell.appendChild(node);
                    row.appendChild(cell);

                    date++;
                }
            }

            tbl.appendChild(row);
        }
    }
}

$(document).ready(function () {
    $('#dialogModal').on('show.bs.modal', function(e) {
        var link = $(e.relatedTarget);

        $('#selectedDate').val(link.attr('data-date'));
    });
});

