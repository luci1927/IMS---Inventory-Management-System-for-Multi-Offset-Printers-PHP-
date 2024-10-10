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

function fth_new_item() {

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

    r.open("POST", "process_fth_add_new_item.php", true);
    r.send(form);

}

function rmi_new_item() {

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

    r.open("POST", "process_rmi_add_new_item.php", true);
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

function fth_update_qty(){

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

    r.open("POST", "process_fth_update_item.php", true);
    r.send(form);
}

function rmi_update_qty(){

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

    r.open("POST", "process_rmi_update_item.php", true);
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

function load_fth_unit(){
    var item = document.getElementById("item").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;

            document.getElementById("unit2").innerHTML = t;

        }
    }

    r.open("GET", "load_fth_unit.php?i=" + item, true);
    r.send();
}

function load_rmi_unit(){
    var item = document.getElementById("item").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;

            document.getElementById("unit2").innerHTML = t;

        }
    }

    r.open("GET", "load_rmi_unit.php?i=" + item, true);
    r.send();
}


$(document).ready(function () {

    $('#datepicker2').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });


    $('#searchButton').click(function () {
        searchmop();
    });
});

function searchmop() {
    var selectedDate = $('#datepicker2').val(); t

    console.log("Selected date: " + selectedDate);

    if (!selectedDate) {
        alert("Please select a valid date.");
        return; 
    }

    $.ajax({
        url: 'process_mop_search.php',
        type: 'POST',
        data: { date: selectedDate },
        success: function (response) {
            console.log("Response from server: " + response); 
            $('#reportsTable tbody').empty(); 
            $('#reportsTable tbody').html(response); 
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status + ", " + error); 
            alert('Error fetching data.');
        }
    });
}

$(document).ready(function () {
    $('#datepickerfth').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });

    $('#searchButtonfth').click(function () {
        searchfth();
    });
});

function searchfth() {
    var selectedDate = $('#datepickerfth').val(); 

    console.log("Selected date: " + selectedDate);

    if (!selectedDate) {
        alert("Please select a valid date.");
        return; 
    }

    $.ajax({
        url: 'process_fth_search.php', 
        type: 'POST',
        data: { date: selectedDate }, 
        success: function (response) {
            console.log("Response from server: " + response); 
            $('#reportsTablefth tbody').empty(); 
            $('#reportsTablefth tbody').html(response); 
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status + ", " + error); 
            alert('Error fetching data.');
        }
    });
}


$(document).ready(function () {
    $('#datepickerfth').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });

    $('#searchButtonfth').click(function () {
        search('#datepickerfth', '#reportsTablefth');
    });

    $('#datepickerrmi').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });

    $('#searchButtonrmi').click(function () {
        search('#datepickerrmi', '#reportsTablermi'); 
    });
});

function search(datepickerId, tableId) {
    var selectedDate = $(datepickerId).val(); 

    console.log("Selected date: " + selectedDate);

    if (!selectedDate) {
        alert("Please select a valid date.");
        return; 
    }

    $.ajax({
        url: 'process_rmi_search.php',
        type: 'POST',
        data: { date: selectedDate }, 
        success: function (response) {
            console.log("Response from server: " + response); 
            $(tableId + ' tbody').empty(); 
            $(tableId + ' tbody').html(response);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status + ", " + error); 
            alert('Error fetching data.');
        }
    });
}


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
        csv.push(csvRow.join(','));
    }


    const csvString = csv.join('\n');

    const downloadLink = document.createElement('a');
    const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);

    filename = filename ? filename + '.csv' : 'table_data.csv';

    downloadLink.href = url;
    downloadLink.setAttribute('download', filename);
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

$('#exportCSVButton').click(function () {
    exportTableToCSV('reportsTable', 'Inventory_Reports');
});



$('#exportPDFButton').click(function () {
    exportTableToPDF('reportsTable', 'Inventory Data Sheet');
});


function exportTableToPDF(tableId, title = '') {
    console.log('Exporting PDF...');
    const { jsPDF } = window.jspdf;

    const pdf = new jsPDF('p', 'pt', 'a4');

    pdf.setFontSize(20);
    pdf.text(title, pdf.internal.pageSize.getWidth() / 2, 30, { align: 'center' });

    const date = new Date();
    const dateString = date.toLocaleDateString();
    pdf.setFontSize(12);
    pdf.text(`Date: ${dateString}`, 15, 50);

    const table = document.getElementById(tableId);
    const rows = [];

    const header = Array.from(table.querySelectorAll('thead th')).map(th => th.innerText);
    rows.push(header);

    const tableRows = table.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        const cols = row.querySelectorAll('td');
        const rowData = Array.from(cols).map(td => td.innerText);
        rows.push(rowData);
    });

    pdf.autoTable({
        head: [header],
        body: rows.slice(1), 
        startY: 70, 
        theme: 'grid', 
    });

    pdf.save('Inventory_Data_Sheet.pdf');
}




function exportTableToTXT(tableId, filenameBase = 'Inventory_Data_Sheet') {
    const table = document.getElementById(tableId);
    let txtData = '';

    const columnWidths = [20, 15, 30, 15, 15, 10, 30]; 

    const header = Array.from(table.querySelectorAll('thead th')).map(th => th.innerText);
    txtData += formatRow(header, columnWidths) + '\n'; 

    const tableRows = table.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        const cols = row.querySelectorAll('td');
        const rowData = Array.from(cols).map(td => td.innerText);
        txtData += formatRow(rowData, columnWidths) + '\n';
    });


    const blob = new Blob([txtData], { type: 'text/plain' });
    const link = document.createElement('a');
    const date = new Date();
    
    const formattedDate = date.toISOString().replace(/:/g, '-').split('.')[0]; 
    const filename = `${filenameBase}_${formattedDate}.txt`;

    link.href = URL.createObjectURL(blob);
    link.download = filename;
    link.click();
    URL.revokeObjectURL(link.href); 
}

function formatRow(data, columnWidths) {
    return data.map((item, index) => {
        return item.toString().padEnd(columnWidths[index] || 10, ' '); 
    }).join(''); 
}

$(document).ready(function() {
    $('#exportTXTButton').click(function () {
        exportTableToTXT('reportsTable');
    });
});

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
        csv.push(csvRow.join(',')); 
    }

    const csvString = csv.join('\n');

    const downloadLink = document.createElement('a');
    const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);

    filename = filename ? filename + '.csv' : 'table_data.csv';

    downloadLink.href = url;
    downloadLink.setAttribute('download', filename);
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink); 
}

$('#exportCSVButtonfth').click(function () {
    exportTableToCSV('reportsTablefth', 'Inventory_Reports');
});

$('#exportPDFButtonfth').click(function () {
    exportTableToPDF('reportsTablefth', 'Inventory Data Sheet'); 
});

function exportTableToPDF(tableId, title = '') {
    console.log('Exporting PDF...');
    const { jsPDF } = window.jspdf;

    const pdf = new jsPDF('p', 'pt', 'a4');


    pdf.setFontSize(20);
    pdf.text(title, pdf.internal.pageSize.getWidth() / 2, 30, { align: 'center' });


    const date = new Date();
    const dateString = date.toLocaleDateString();
    pdf.setFontSize(12);
    pdf.text(`Date: ${dateString}`, 15, 50);

    const table = document.getElementById(tableId);
    const rows = [];


    const header = Array.from(table.querySelectorAll('thead th')).map(th => th.innerText);
    rows.push(header);

    const tableRows = table.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        const cols = row.querySelectorAll('td');
        const rowData = Array.from(cols).map(td => td.innerText);
        rows.push(rowData);
    });

    pdf.autoTable({
        head: [header],
        body: rows.slice(1), 
        startY: 70, 
        theme: 'grid', 
    });

    pdf.save('Inventory_Data_Sheet.pdf');
}

function exportTableToTXT(tableId, filenameBase = 'Inventory_Data_Sheet') {
    const table = document.getElementById(tableId);
    let txtData = '';

    const columnWidths = [20, 15, 30, 15, 15, 10, 30]; 

    const header = Array.from(table.querySelectorAll('thead th')).map(th => th.innerText);
    txtData += formatRow(header, columnWidths) + '\n'; 

    const tableRows = table.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        const cols = row.querySelectorAll('td');
        const rowData = Array.from(cols).map(td => td.innerText);
        txtData += formatRow(rowData, columnWidths) + '\n'; 
    });

    const blob = new Blob([txtData], { type: 'text/plain' });
    const link = document.createElement('a');
    const date = new Date();
    
    const formattedDate = date.toISOString().replace(/:/g, '-').split('.')[0]; 
    const filename = `${filenameBase}_${formattedDate}.txt`;

    link.href = URL.createObjectURL(blob);
    link.download = filename;
    link.click();
    URL.revokeObjectURL(link.href);
}

function formatRow(data, columnWidths) {
    return data.map((item, index) => {
        return item.toString().padEnd(columnWidths[index] || 10, ' '); 
    }).join('');
}

$(document).ready(function() {
    $('#exportTXTButtonfth').click(function () {
        exportTableToTXT('reportsTablefth');
    });
});

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
        csv.push(csvRow.join(','));
    }

    const csvString = csv.join('\n');

    const downloadLink = document.createElement('a');
    const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);

    filename = filename ? filename + '.csv' : 'table_data.csv';

    downloadLink.href = url;
    downloadLink.setAttribute('download', filename);
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

$('#exportCSVButtonrmi').click(function () {
    exportTableToCSV('reportsTablermi', 'Inventory_Reports'); 
});


$('#exportPDFButtonrmi').click(function () {
    exportTableToPDF('reportsTablermi', 'Inventory Data Sheet'); 
});

function exportTableToPDF(tableId, title = '') {
    console.log('Exporting PDF...');
    const { jsPDF } = window.jspdf;

    const pdf = new jsPDF('p', 'pt', 'a4');


    pdf.setFontSize(20);
    pdf.text(title, pdf.internal.pageSize.getWidth() / 2, 30, { align: 'center' });


    const date = new Date();
    const dateString = date.toLocaleDateString();
    pdf.setFontSize(12);
    pdf.text(`Date: ${dateString}`, 15, 50);


    const table = document.getElementById(tableId);
    const rows = [];


    const header = Array.from(table.querySelectorAll('thead th')).map(th => th.innerText);
    rows.push(header);

    // Extract rows
    const tableRows = table.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        const cols = row.querySelectorAll('td');
        const rowData = Array.from(cols).map(td => td.innerText);
        rows.push(rowData);
    });

    pdf.autoTable({
        head: [header],
        body: rows.slice(1), 
        startY: 70, 
        theme: 'grid', 
    });


    pdf.save('Inventory_Data_Sheet.pdf');
}

function exportTableToTXT(tableId, filenameBase = 'Inventory_Data_Sheet') {
    const table = document.getElementById(tableId);
    let txtData = '';


    const columnWidths = [20, 15, 30, 15, 15, 10, 30]; 


    const header = Array.from(table.querySelectorAll('thead th')).map(th => th.innerText);
    txtData += formatRow(header, columnWidths) + '\n'; 


    const tableRows = table.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        const cols = row.querySelectorAll('td');
        const rowData = Array.from(cols).map(td => td.innerText);
        txtData += formatRow(rowData, columnWidths) + '\n'; 
    });

    const blob = new Blob([txtData], { type: 'text/plain' });
    const link = document.createElement('a');
    const date = new Date();
    
    const formattedDate = date.toISOString().replace(/:/g, '-').split('.')[0]; 
    const filename = `${filenameBase}_${formattedDate}.txt`;

    link.href = URL.createObjectURL(blob);
    link.download = filename;
    link.click();
    URL.revokeObjectURL(link.href);
}

function formatRow(data, columnWidths) {
    return data.map((item, index) => {

        return item.toString().padEnd(columnWidths[index] || 10, ' '); 
    }).join(''); 
}


$(document).ready(function() {
    $('#exportTXTButtonrmi').click(function () {
        exportTableToTXT('reportsTablermi');
    });
});




