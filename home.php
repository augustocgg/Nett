<h3 class="text-center">Bienvenidos</h3>
<hr>
<center><small class="text-muted">Reserve su mesa ahora</small></center>
<style>
    #fp-canvas-container {
        height: 50vh;
        width: 100%;
        position: relative;
        overflow: hidden;
    }
    .fp-img {
        position: absolute;
        max-width: 100%;
        max-height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: auto;
        z-index: 1;
    }
    #fp-map {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1;
        width: 100%;
        height: 100%;
    }
    .fp-canvas {
        z-index: 2;
        background: #0000000d;
        cursor: crosshair;
    }
    area:hover {
        background: #0000004d;
        color: #fff !important;
    }
</style>
<?php 
$sql = "SELECT * FROM `table_list` ORDER BY tbl_no ASC";
$qry = $conn->query($sql);
$tbl = array();
while ($row = $qry->fetchArray()):
    $tbl[$row['table_id']] = array(
        "id" => $row['table_id'],
        "tbl_no" => $row['tbl_no'],
        "coordinates" => $row['coordinates'],
        "name" => $row['name']
    );
endwhile;
?>
<div class="col-12 mt-3">
    <div class="row">
        <div id="fp-canvas-container">
            <img src="./uploads/floorplan.png" alt="Floor Plan" class="fp-img border p-1 img_home_reserva" id="fp-img" usemap="#fp-map">
            <map name="fp-map" id="fp-map" class=""></map>
        </div>
    </div>
</div>
<script>
    var tbl = $.parseJSON('<?php echo json_encode($tbl) ?>');
    function map_tbls() {
        if (Object.keys(tbl).length > 0) {
            $('#fp-map').html('');
            Object.keys(tbl).map(k => {
                var data = tbl[k];
                var area = $("<area shape='rect'>");
                area.attr('href', "javascript:void(0)");
                var perc = data.coordinates.replace(" ", '').split(",");
                var x1 = $('#fp-img').width() * perc[0];
                var y1 = $('#fp-img').height() * perc[1];
                var x2 = $('#fp-img').width() * perc[2];
                var y2 = $('#fp-img').height() * perc[3];
                var width = x2 - x1;
                var height = y2 - y1;
                area.attr('coords', x1 + ", " + y1 + ", " + x2 + ", " + y2);
                area.text("#" + data.tbl_no);
                area.addClass('fw-bolder text-muted');
                area.css({
                    'position': 'absolute',
                    'height': height + 'px',
                    'width': width + 'px',
                    'top': y1 + 'px',
                    'left': x1 + 'px',
                    'display': 'flex',
                    'text-align': 'center',
                    'justify-content': 'center',
                    'align-items': 'center',
                });
                $('#fp-map').append(area);
                area.click(function() {
                    uni_modal('Reservando una Mesa', "manage_reservation.php?table_id=" + data.id);
                });
            });
        }
    }
    $(function() {
        map_tbls();
        $(window).on('resize', function() {
            map_tbls();
        });
    });
</script>
