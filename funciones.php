<script type="text/javascript">

function paintAsientos(divId, ocupados) {
    var arreglo = <?php echo json_encode($ocupados); ?>;

    for (let i = 0; i < arreglo.length; i++) {
        let asiento = document.getElementById("asiento" + arreglo[i]);
        asiento.style = 'background-image: url("img/seatA.png"); background-size: 3rem; width: 3rem; height: 3rem; text-align: center; padding-left: 0.65rem; display: flex; align-items: center; justify-content: center;';
    }
}

</script>