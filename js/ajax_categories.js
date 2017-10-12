$(document).ready(function() {
    $("button").click(function() {
        $.ajax({
            url: "includes/sort_categories.php",
            type: "post",
            success: function(data){
                $("article").html(data);
            },
            error: function(){
                $("#error").html("Error with ajax");
            }
        });
    });
});