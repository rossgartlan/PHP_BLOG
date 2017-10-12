$(document).ready(function() {
    $("button").click(function() {
        $.ajax({
            url: "includes/sort_fixture.php",
            type: "post",
            success: function(data){
                $("#fix").html(data);
            },
            error: function(){
                $("#error").html("Error with ajax");
            }
        });
    });
});