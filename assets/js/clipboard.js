$(".address_copy").click(function (event) {
    event.preventDefault();
    copyToClipboard($(this).data("text"));
    $(this).find(".info").html("L'ip a été copier");

    setTimeout(() => {
        $(this).find(".info").html("Clique pour copier l'ip");
    }, 3000);

});

function copyToClipboard(text) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(text).select();
    console.log(text);
    document.execCommand("copy");
    $temp.remove();
}