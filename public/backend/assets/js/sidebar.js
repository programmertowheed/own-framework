const sidebar = document.getElementById("sidebar");
const sidebarToggle = document.getElementById("sidebar-toggle");
const ddToggle = document.querySelectorAll(".dd-toggle");

if (sidebarToggle) {
    sidebarToggle.onclick = (e) => {
        const isOpen = sidebar.getAttribute("open");

        if (isOpen) {
            sidebar.removeAttribute("open");
        } else {
            sidebar.setAttribute("open", true);
        }
    };
}


Array.from(ddToggle).forEach((elm) => {
    elm.onclick = (e) => {
        const isOpen = elm.getAttribute("open");

        if (isOpen) {
            elm.removeAttribute("open");
        } else {
            elm.setAttribute("open", true);
        }
    };
});
