function InitNav() {
    const state = localStorage.getItem('TornadoMenuNav');
    console.log(state);
    if (state == 1) {
        openNav();
    } else if (state == 0) {
        closeNav();
    } else {
        openNav();
    }
}

function openNav() {
    if (document.getElementById("mySidenav").style.width == "250px") {
        SaveStatementMenuNav(0);
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("main").style.marginRight = "0";
    } else {
        SaveStatementMenuNav(1);
        document.getElementById("mySidenav").style.width = "250px";
        document.getElementById("main").style.marginRight = "250px";
    }

}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginRight = "0";
    SaveStatementMenuNav(0);
}

function SaveStatementMenuNav(state) {
    localStorage.setItem('TornadoMenuNav', state);
}