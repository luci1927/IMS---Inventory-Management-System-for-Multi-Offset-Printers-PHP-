function signIn() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var department = document.getElementById("department").value;

    var f = new FormData();
    f.append("e", username);
    f.append("p", password);
    f.append("d", department);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState === 4) {
            var t = r.responseText;
            console.log("Response from server:", t); 
    
            var departmentId = parseInt(t, 10);
    
            if (departmentId === 1) {
                window.location = "mop-index.php"; 
            } else if (departmentId === 2) {
                window.location = "fth-index.php";
            } else if (departmentId === 3) {
                window.location = "rmi-index.php"; 
            } else {
                alert("Invalid credentials or department");
            }
        }
    };

    r.open("POST", "signInProcess.php", true);
    r.send(f);
}



function signout() {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location.reload();
            }
        }
    };

    r.open("GET", "signoutProcess.php", true);
    r.send();

}


function mop_new_item() {

    var i = document.getElementById("item_code");
    var d = document.getElementById("description");
    var u = document.getElementById("unit");
    var ig = document.getElementById("item_group1");
    var isg = document.getElementById("item_sub_group1");

    var form = new FormData();
    form.append("i", i.value);
    form.append("d", d.value);
    form.append("u", u.value);
    form.append("ig", ig.value);
    form.append("isg", isg.value);

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



function mop_new_stock(){

    var i = document.getElementById("item3");
    var q = document.getElementById("quantity");
    var g = document.getElementById("grn2");
    var gt = document.getElementById("grn_type3");
    var s = document.getElementById("supplier2");
    var re = document.getElementById("remarks");

    var form = new FormData();
    form.append("i", i.value);
    form.append("q", q.value);
    form.append("g", g.value);
    form.append("gt", gt.value);
    form.append("s", s.value);
    form.append("re", re.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var text = r.responseText;

            if (text == "success") {
                alert("Stock added successfully.");
                window.location.reload();
            } else {
                alert(text);
            }


        }
    }

    r.open("POST", "process_mop_add_new_stock.php", true);
    r.send(form);
}

function fth_new_item() {

    var i = document.getElementById("item_code");
    var d = document.getElementById("description");
    var u = document.getElementById("unit");
    var q = document.getElementById("quantity1");
    var g = document.getElementById("grn1");
    var gt = document.getElementById("grn_type1");
    var s = document.getElementById("supplier1");
    var re = document.getElementById("remarks1");

    var form = new FormData();
    form.append("i", i.value);
    form.append("d", d.value);
    form.append("u", u.value);
    form.append("q", q.value);
    form.append("g", g.value);
    form.append("gt", gt.value);
    form.append("s", s.value);
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

function fth_new_stock(){

    var i = document.getElementById("item3");
    var q = document.getElementById("quantity");
    var g = document.getElementById("grn2");
    var gt = document.getElementById("grn_type3");
    var s = document.getElementById("supplier2");
    var re = document.getElementById("remarks");

    var form = new FormData();
    form.append("i", i.value);
    form.append("q", q.value);
    form.append("g", g.value);
    form.append("gt", gt.value);
    form.append("s", s.value);
    form.append("re", re.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var text = r.responseText;

            if (text == "success") {
                alert("Stock added successfully.");
                window.location.reload();
            } else {
                alert(text);
            }


        }
    }

    r.open("POST", "process_fth_add_new_stock.php", true);
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

function load_mop_unit_update(){
    var item = document.getElementById("item3").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText; 

            document.getElementById("unit3").innerHTML = t;

        }
    }

    r.open("GET", "load_mop_unit_update.php?i=" + item, true);
    r.send();
}


function load_mop_grn_type_update(){
    var item = document.getElementById("item3").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText; 

            document.getElementById("grn_type3").innerHTML = t;

        }
    }

    r.open("GET", "load_mop_grn_type_update.php?i=" + item, true);
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

function load_fth_unit_update(){
    var item = document.getElementById("item3").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText; 

            document.getElementById("unit3").innerHTML = t;

        }
    }

    r.open("GET", "load_fth_unit_update.php?i=" + item, true);
    r.send();
}

function load_fth_grn_type_update(){
    var item = document.getElementById("item3").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText; 

            document.getElementById("grn_type3").innerHTML = t;

        }
    }

    r.open("GET", "load_fth_grn_type_update.php?i=" + item, true);
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

    $('#datepicker1').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });


    $('#searchButton1').click(function () {
        searchmop();
    });
});

function searchmop() {
    var selectedDate = $('#datepicker1').val(); 

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
            $('#reportsTable1 tbody').empty(); 
            $('#reportsTable1 tbody').html(response); 
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

$('#exportCSVButton1').click(function () {
    exportTableToCSV('reportsTable1', 'Inventory_Reports');
});

$('#exportCSVButton2').click(function () {
    exportTableToCSV('reportsTable2', 'Inventory_Reports');
});

$('#exportCSVButton3').click(function () {
    exportTableToCSV('reportsTable3', 'Inventory_Reports');
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




$('#exportPDFButton1').click(function () {
    exportTableToPDF('reportsTable1', 'Inventory Data Sheet');
});

$('#exportPDFButton2').click(function () {
    exportTableToPDF('reportsTable2', 'Inventory Data Sheet');
});

$('#exportPDFButton3').click(function () {
    exportTableToPDF('reportsTable3', 'Inventory Data Sheet');
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


function formatRow(data, columnWidths) {
    return data.map((item, index) => {
        return item.toString().padEnd(columnWidths[index] || 10, ' '); 
    }).join(''); 
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


function formatRow(data, columnWidths) {
    return data.map((item, index) => {
        return item.toString().padEnd(columnWidths[index] || 10, ' '); 
    }).join('');
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


function formatRow(data, columnWidths) {
    return data.map((item, index) => {

        return item.toString().padEnd(columnWidths[index] || 10, ' '); 
    }).join(''); 
}


 
function load_mop_out_table(){

    var item = document.getElementById("item").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText; 

            document.getElementById("inventoryTable").innerHTML = t;

        }
    }

    r.open("GET", "load_mop_out_table.php?i=" + item, true);
    r.send();
}

 function mop_inventory_out(){

    var i = document.getElementById("item");
    var q = document.getElementById("quantity2");
    var u = document.getElementById("issue_no");
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

    r.open("POST", "process_mop_inventory_out.php", true);
    r.send(form);

 }



 $(document).ready(function () {

    $('#datepicker2').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });


    $('#searchButton2').click(function () {
        searchmopissue();
    });
});

function searchmopissue() {
    var selectedDate = $('#datepicker2').val(); 

    console.log("Selected date: " + selectedDate);

    if (!selectedDate) {
        alert("Please select a valid date.");
        return; 
    }

    $.ajax({
        url: 'process_mop_search_issue.php',
        type: 'POST',
        data: { date: selectedDate },
        success: function (response) {
            console.log("Response from server: " + response); 
            $('#reportsTable2 tbody').empty(); 
            $('#reportsTable2 tbody').html(response); 
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status + ", " + error); 
            alert('Error fetching data.');
        }
    });
}

$(document).ready(function () {

    $('#datepicker3').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });


    $('#searchButton3').click(function () {
        searchmopgrn();
    });
});

function searchmopgrn() {
    var selectedDate = $('#datepicker3').val(); 

    console.log("Selected date: " + selectedDate);

    if (!selectedDate) {
        alert("Please select a valid date.");
        return; 
    }

    $.ajax({
        url: 'process_mop_search_grn.php',
        type: 'POST',
        data: { date: selectedDate },
        success: function (response) {
            console.log("Response from server: " + response); 
            $('#reportsTable3 tbody').empty(); 
            $('#reportsTable3 tbody').html(response); 
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status + ", " + error); 
            alert('Error fetching data.');
        }
    });
}




function add_unit(){
    var unit_name = document.getElementById("unit").value;

    var form = new FormData();
    form.append("u", unit_name);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var text = r.responseText;

            if (text == "success") {
                alert("Unit added successfully.");
                window.location.reload();
            } else {
                alert(text);
            }


        }
    }

    r.open("POST", "process_add_new_unit.php", true);
    r.send(form);
}

function add_grn(){
    var grn_type = document.getElementById("grn").value;

    var form = new FormData();
    form.append("g", grn_type);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var text = r.responseText;

            if (text == "success") {
                alert("GRN Type added successfully.");
                window.location.reload();
            } else {
                alert(text);
            }


        }
    }

    r.open("POST", "process_add_new_grn_type.php", true);
    r.send(form);
}

function add_supplier(){
    var supplier_name = document.getElementById("supplierName").value;
    var company = document.getElementById("company").value;
    var mobile = document.getElementById("mobile").value;

    var form = new FormData();
    form.append("s", supplier_name);
    form.append("c", company);
    form.append("m", mobile);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var text = r.responseText;

            if (text == "success") {
                alert("Supplier added successfully.");
                window.location.reload();
            } else {
                alert(text);
            }


        }
    }

    r.open("POST", "process_add_new_supplier.php", true);
    r.send(form);
}

function mop_add_item_group(){
    var item_group_code = document.getElementById("igc").value;
    var item_group_name = document.getElementById("ign").value;

    var form = new FormData();
    form.append("c", item_group_code);
    form.append("n", item_group_name);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var text = r.responseText;

            if (text == "success") {
                alert("Item Group added successfully.");
                window.location.reload();
            } else {
                alert(text);
            }


        }
    }

    r.open("POST", "process_mop_add_item_group.php", true);
    r.send(form);
}

function mop_add_item_sub_group(){

    var item_group_code = document.getElementById("itmgp").value;
    var item_sub_group_code = document.getElementById("igc1").value;
    var item_sub_group_name = document.getElementById("ign1").value;

    var form = new FormData();
    form.append("g", item_group_code);
    form.append("c", item_sub_group_code);
    form.append("n", item_sub_group_name);

    console.log(item_group_code);
    console.log("--");
    console.log(item_sub_group_code);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var text = r.responseText;

            if (text == "success") {
                alert("Item Group added successfully.");
                window.location.reload();
            } else {
                alert(text);
            }


        }
    }

    r.open("POST", "process_mop_add_item_sub_group.php", true);
    r.send(form);
}
function load_item_sub_group() {
    var item_group_code = document.getElementById("item_group1").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;

            document.getElementById("item_sub_group1").innerHTML = t;

            $('#item_sub_group1').selectpicker('refresh');
        }
    };

    r.open("GET", "load_item_sub_group.php?g=" + item_group_code, true);
    r.send();
}


function load_stock_update_report_table(){

    var item = document.getElementById("item3").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText; 

            document.getElementById("reportsTable1").innerHTML = t;

        }
    }

    r.open("GET", "load_mop_stock_update_report_table.php?i=" + item, true);
    r.send();
}

function load_issue_update_report_table(){

    var item = document.getElementById("item4").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText; 

            document.getElementById("reportsTable2").innerHTML = t;

        }
    }

    r.open("GET", "load_mop_issue_update_report_table.php?i=" + item, true);
    r.send();
}

function load_grn_update_report_table(){

    var item = document.getElementById("item5").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText; 

            document.getElementById("reportsTable3").innerHTML = t;

        }
    }

    r.open("GET", "load_mop_grn_update_report_table.php?i=" + item, true);
    r.send();
}