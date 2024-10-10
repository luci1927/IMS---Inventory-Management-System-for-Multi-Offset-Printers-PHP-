function signIn() {
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var department = document.getElementById("department");

    var f = new FormData();
    f.append("e", username.value);
    f.append("p", password.value);
    f.append("d", department.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState === 4) {
            var t = r.responseText;

            if (t === "multi") {
                window.location = "mop-index.php";
            } else if (t === "fair") {
                window.location = "fth-index.php";
            } else if (t === "rajah") {
                window.location = "rmi-index.php";
            } else {
                alert("Invalid credentials or department");
            }
        }
    };

    r.open("POST", "signInProcess.php", true);
    r.send(f);
}


function mop_new_item() {

    var i = document.getElementById("item_code");
    var d = document.getElementById("description");
    var u = document.getElementById("unit");
    var q = document.getElementById("quantity");
    var re = document.getElementById("remarks");

    var form = new FormData();
    form.append("i", i.value);
    form.append("d", d.value);
    form.append("u", u.value);
    form.append("q", q.value);
    form.append("re", re.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var text = r.responseText;

            if (text == "success") {
                alert("Item added successfully.");
                window.location.reload();
            } else {
                alert(text);
            }


        }
    }

    r.open("POST", "process_mop_add_new_item.php", true);
    r.send(form);

}

function mop_update_qty(){

    var i = document.getElementById("item");
    var q = document.getElementById("quantity2");
    var u = document.getElementById("unit2");
    var re = document.getElementById("remarks2");

    var form = new FormData();
    form.append("i", i.value);
    form.append("q", q.value);
    form.append("u", u.value);
    form.append("re", re.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var text = r.responseText;

            if (text == "success") {
                alert(text);
                window.location.reload();
            } else {
                alert(text);
            }

        }
    }

    r.open("POST", "process_mop_update_item.php", true);
    r.send(form);
}

function load_mop_unit(){
    var item = document.getElementById("item").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;

            document.getElementById("unit2").innerHTML = t;

        }
    }

    r.open("GET", "load_mop_unit.php?i=" + item, true);
    r.send();
}


$(document).ready(function () {
    // Initialize the datepicker
    $('#datepicker2').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });

    // Attach the search function to the button click event
    $('#searchButton').click(function () {
        search(); // Call the search function when the button is clicked
    });
});

function search() {
    var selectedDate = $('#datepicker2').val(); // Get the value from the datepicker input

    // Debugging: Log the selected date
    console.log("Selected date: " + selectedDate);

    // Check if the selected date is valid
    if (!selectedDate) {
        alert("Please select a valid date.");
        return; // Exit if the date is not selected
    }

    $.ajax({
        url: 'process_mop_search.php', // Make sure the path is correct
        type: 'POST',
        data: { date: selectedDate }, // Send the selected date to the server
        success: function (response) {
            console.log("Response from server: " + response); // Log the response for debugging
            $('#reportsTable tbody').empty(); // Clear the existing table data
            $('#reportsTable tbody').html(response); // Populate the table with the new data
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status + ", " + error); // Log any AJAX errors
            alert('Error fetching data.');
        }
    });
}


// Function to export table data to CSV
function exportTableToCSV(tableId, filename = '') {
    const csv = [];
    const rows = document.querySelectorAll(`#${tableId} tr`);

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const cols = row.querySelectorAll('td, th');
        const csvRow = [];

        for (let j = 0; j < cols.length; j++) {
            csvRow.push(cols[j].innerText);
        }
        csv.push(csvRow.join(',')); // Join each row with commas
    }

    // Join all rows with new line character
    const csvString = csv.join('\n');

    // Create a download link
    const downloadLink = document.createElement('a');
    const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);

    // Specify filename
    filename = filename ? filename + '.csv' : 'table_data.csv';

    downloadLink.href = url;
    downloadLink.setAttribute('download', filename);
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink); // Remove the link after downloading
}

// Attach the CSV export function to the button click event
$('#exportCSVButton').click(function () {
    exportTableToCSV('reportsTable', 'Inventory_Reports'); // Call the export function
});



// Attach the PDF export function to the button click event
$('#exportPDFButton').click(function () {
    exportTableToPDF('reportsTable', 'Inventory Data Sheet'); // Call the export function
});


function exportTableToPDF(tableId, title = '') {
    console.log('Exporting PDF...');
    const { jsPDF } = window.jspdf;

    const pdf = new jsPDF('p', 'pt', 'a4');

    // Title
    pdf.setFontSize(20);
    pdf.text(title, pdf.internal.pageSize.getWidth() / 2, 30, { align: 'center' });

    // Date
    const date = new Date();
    const dateString = date.toLocaleDateString();
    pdf.setFontSize(12);
    pdf.text(`Date: ${dateString}`, 15, 50);

    // Get the table data
    const table = document.getElementById(tableId);
    const rows = [];

    // Extract header
    const header = Array.from(table.querySelectorAll('thead th')).map(th => th.innerText);
    rows.push(header);

    // Extract rows
    const tableRows = table.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        const cols = row.querySelectorAll('td');
        const rowData = Array.from(cols).map(td => td.innerText);
        rows.push(rowData);
    });

    // Generate the table in the PDF
    pdf.autoTable({
        head: [header],
        body: rows.slice(1), // Exclude the header from the body
        startY: 70, // Start position
        theme: 'grid', // Optional: 'striped', 'grid', 'plain'
    });

    // Save the PDF
    pdf.save('Inventory_Data_Sheet.pdf');
}



function exportTableToTXT(tableId, filenameBase = 'Inventory_Data_Sheet') {
    const table = document.getElementById(tableId);
    let txtData = '';

    // Define column widths (adjust these based on your needs)
    const columnWidths = [20, 15, 30, 15, 15, 10, 30]; // Widths for each column in characters

    // Extract header
    const header = Array.from(table.querySelectorAll('thead th')).map(th => th.innerText);
    txtData += formatRow(header, columnWidths) + '\n'; // Format headers

    // Extract rows
    const tableRows = table.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        const cols = row.querySelectorAll('td');
        const rowData = Array.from(cols).map(td => td.innerText);
        txtData += formatRow(rowData, columnWidths) + '\n'; // Format row data
    });

    // Create a blob and trigger download
    const blob = new Blob([txtData], { type: 'text/plain' });
    const link = document.createElement('a');
    const date = new Date();
    
    // Format the date and time for the filename
    const formattedDate = date.toISOString().replace(/:/g, '-').split('.')[0]; // Format to YYYY-MM-DDTHH-MM-SS
    const filename = `${filenameBase}_${formattedDate}.txt`;

    link.href = URL.createObjectURL(blob);
    link.download = filename;
    link.click();
    URL.revokeObjectURL(link.href); // Clean up URL.createObjectURL
}

// Function to format each row based on specified column widths
function formatRow(data, columnWidths) {
    return data.map((item, index) => {
        // Pad the string to the specified width
        return item.toString().padEnd(columnWidths[index] || 10, ' '); // Default width is 10 if not specified
    }).join(''); // Join with empty string to keep spaces
}

// Event listeners
$(document).ready(function() {
    $('#exportTXTButton').click(function () {
        exportTableToTXT('reportsTable');
    });
});




