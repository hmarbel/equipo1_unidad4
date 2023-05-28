function confirmDialog() {
    //alert("Ok");
    cuteAlert({
        type: "question",
        title: "¡Espera!",
        message: "¿Deseas cerrar sesión?",
        confirmText: "Sí",
        cancelText: "No"
    }).then((e) => {
        //alert(e);
        if (e == "confirm") {
            //return true;
            document.location.href = "logout.php";
            //alert(":-)");
        } else {
            return false;
            //alert(":-(");
        }
    })
}

