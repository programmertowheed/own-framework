const themeBtns = document.querySelectorAll(".theme-color-icon");

const initTheme = localStorage.getItem("theme");

if (initTheme) {
    setTheme(initTheme);
}

function setTheme(theme, event) {
    event.stopPropagation();

    document.documentElement.setAttribute("data-theme", theme);

    localStorage.setItem("theme", theme);

    Array.from(themeBtns).forEach((themeBtn) => {
        if (themeBtn.title.toLowerCase() === theme.toLowerCase())
            return themeBtn.classList.add("act");

        themeBtn.classList.remove("act");
    });
}
