$(document).ready(function() {
    
    $(".resultLink").on("click", function() {
        
        var id = $(this).attr("data-linkId");
        var url = $(this).attr("href");

        if (!id) alert("data-link attribute not found.");

        increaseLinkClicks(id, url);

        alert("Yes");

        return false;
    })

});

function increaseLinkClicks(linkId, url)
{
    console.log(linkId);
    $.post("ajax/updateLinkCount.php", {linkId: linkId});
}