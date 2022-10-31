/**@abstract
 * This function is called when the checkbox is checked or unchecked and changes to darkmode depending on its status
 * 
 */
 function darkmode(){
    var element = document.body;
    if(document.getElementById('slider').checked){
        element.className = "dark-mode";
        document.getElementById("ahrefI").className = "a-style-dark";
        document.getElementById("ahrefF").className = "a-style-dark";
        localStorage.setItem("dark-mode", 1);
    }
    else{
        element.className = "light-mode";
        document.getElementById("ahrefI").className = "a-style";
        document.getElementById("ahrefF").className = "a-style";
        localStorage.removeItem("dark-mode");
    }
}
function themeChecker(){
    if(localStorage.getItem("dark-mode")){
        document.getElementById("slider").checked = true;
        darkmode();
    }
}

var test = ["test", "test1", "science", "computer science"];
let autoFillInput = document.getElementById("starName");
autoFillInput.addEventListener("keyup", function(){
    removeElements();
    for(let i of test){
        if(i.toLowerCase().startsWith(autoFillInput.value.toLowerCase()) && autoFillInput.value != ""){
            let listItem = document.createElement("li");
            listItem.classList.add("list-items");
            listItem.style.cursor = "pointer";
            listItem.setAttribute("onclick", "displayNames('" + i + "')");
            let word = "<b>" + i.substring(0, autoFillInput.value.length) + "</b>";
            word += i.substr(autoFillInput.value.length);
            listItem.innerHTML = word;
            document.querySelector(".autofill").appendChild(listItem);
        }
    }
});
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
