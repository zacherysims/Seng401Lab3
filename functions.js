$(document).ready( function(){
    //If user wants to...
    $("#form").submit(function(e){
        e.preventDefault();
        var blat= $("#blattitude").val(); 
        var blong = $("#blongitude").val();
        var tlat= $("#tlattitude").val(); 
        var tlong= $("#tlongitude").val();
        var flag = validatePoints(blat, blong, tlat, tlong);
        if(flag == 1)
        {
                $.ajax({
                    type: "POST",
                    url: "flicka.php", //(not racist)
                    data: {blat: blat, blong: blong, tlat: tlat, tlong: tlong},
                    cache: false,
                    success: function(data) {
                      document.getElementById("json").innerHTML = data;//put in json
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "images.php", 
                    data: {blat: blat, blong: blong, tlat: tlat, tlong: tlong},
                    cache: false,
                    success: function(data) {
                      document.getElementById("images").innerHTML = data;//put in pic
                    }
                });
        }
        else {
            if( flag == -1) {
                $("#result").html("left lattitude shouldn't be greater than right lattitude");
            }
            if (flag == -2) {
                document.getElementById("result").innerHTML = "bottom longitude shouldn't be greater than top longitude";
            }
            if (flag == -3) {
                document.getElementById("result").innerHTML = "one of you're points do not fall within valid long/lat bounds";
            }

            document.getElementById("submit").disabled = true;
        }
    });

});

function validatePoints(blat, blong, tlat, tlong){


    if(parseInt(blat) > parseInt(tlat)) {
        return -1;
    }
    if(parseInt(blong) > parseInt(tlong)) {
        return -2;
    }
    if(parseInt(blong) > 180 || parseInt(blong) < -180 || parseInt(tlong) > 180 || parseInt(tlong) < -180){
        return -3;
    }
    if(parseInt(blat) >90 || parseInt(blat) < -90 || parseInt(tlat) > 90 || parseInt(tlat) < -90) {
        return -3;
    }
    return 1;
};

function Toggle(){
    var json = document.getElementById("json");
    var images = document.getElementById("images");
    if(json.style.display == "none"){
        json.style.display = "block";
        images.style.display = "none";
    }
    else {
        images.style.display = "block";
        json.style.display = "none";
    }
}