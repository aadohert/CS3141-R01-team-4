/**
 * Checks the slider to tell what theme to make the website.
 *
 * This function is called when the slider is checked or unchecked which it then changes the theme of the website. It does this by going through the elements and inverting the color of specific elements.
 *
 * @access     public
 *
 * @global
 *
 */
 function darkmode(){
    var element = document.body;
    if(document.getElementById('slider').checked){
        element.className = "dark-mode";
        const allElements = document.getElementsByTagName('*');
        for(const elements of allElements){
            if(!elements.classList.contains("const") && !elements.classList.contains("link")){
                elements.classList.add("a-style-dark");
                elements.classList.remove("a-style");
            }
            else{
                elements.classList.add("text-color-d")
                elements.classList.remove("text-color-l")
            }
        }
        localStorage.setItem("dark-mode", 1);
    }
    else{
        element.className = "light-mode";
        const allElements = document.getElementsByTagName('*');
        for(const elements of allElements){
            if(!elements.classList.contains("const") && !elements.classList.contains("link")){
                elements.classList.remove("a-style-dark");  
                elements.classList.add("a-style");
            }
            else{
                elements.classList.remove("text-color-d")
                elements.classList.add("text-color-l")
            }
        }
        localStorage.removeItem("dark-mode");
    }
}

/**
 * Checks what theme that the page was most recently in.
 *
 * This function checks what the theme of the website was last in when and calls the darkmode function depending on the state.
 *
 * @access     public
 *
 * @global
 *
 * @see darkmode
 */
function themeChecker(){
    if(localStorage.getItem("dark-mode")){
        document.getElementById("slider").checked = true;
        darkmode();
    }
}

/**
 * Every time a character is inputted into the starName input and corresponds to star, this function updates the input and removes the current elements in the list.
 *
 * This function updates the value of the autofill input and removes the current elements from the autofill list.
 *
 * @access     public
 *@see removeElements
 * @global
 *
 */
function displayNames(value){
    autoFillInput.value = value;
    removeElements();
}


/**
 * Removes the elements from the autofill list.
 *
 * Goes through the elements of the autofill list items and remvoes them.
 *
 * @access     public
 *
 * @global
 *
 */
function removeElements(){
    let items = document.querySelectorAll(".list-items");
    items.forEach((item) => {
        item.remove();
    });
}
