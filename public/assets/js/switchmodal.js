const loginchange = () => {

    if (document.getElementById("changemodal").checked == true) {
        $("#inscription").fadeIn(2000);
        $("#loginchange").fadeOut(0);
    }
    else {
        $("#loginchange").fadeIn(2000);
        $("#inscription").fadeOut(0);
    }
    
}
const startpage = () => {

    $("#loginchange").fadeOut(0);

 
}
startpage();

document.getElementById("logincharge").addEventListener("click", loginchange);
document.getElementById("changemodal").addEventListener("click", loginchange);