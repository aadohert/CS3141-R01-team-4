/**@abstract
 * This function is called when the checkbox is checked or unchecked and changes to darkmode depending on its status
 * 
 */
 function darkmode(){
    var element = document.body;
    if(document.getElementById('slider').checked){
        element.className = "dark-mode";
        const allElements = document.getElementsByTagName('*');
        for(const elements of allElements){
            if(!elements.classList.contains("const")){
                elements.classList.add("a-style-dark");
                elements.classList.remove("a-style");
            }
        }
        localStorage.setItem("dark-mode", 1);
    }
    else{
        element.className = "light-mode";
        const allElements = document.getElementsByTagName('*');
        for(const elements of allElements){
            if(!elements.classList.contains("const")){
                elements.classList.remove("a-style-dark");  
                elements.classList.add("a-style");
            }
        }
        localStorage.removeItem("dark-mode");
    }
}
function themeChecker(){
    if(localStorage.getItem("dark-mode")){
        document.getElementById("slider").checked = true;
        darkmode();
    }
}
function displayNames(value){
    autoFillInput.value = value;
    removeElements();
}
function removeElements(){
    let items = document.querySelectorAll(".list-items");
    items.forEach((item) => {
        item.remove();
    });
}
