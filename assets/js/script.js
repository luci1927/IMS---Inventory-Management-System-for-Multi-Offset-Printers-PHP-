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
